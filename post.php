<?php
require_once "config.php";
require_once "function.php";
require_once "spintax.php";
?>

<?php
$stmt = $pdo->prepare('SELECT a.post_id, a.datetime, c.uid, b.content, c.token FROM posts a, content b, token c WHERE a.post_id = b.id AND a.uid = c.id AND a.status = "" ORDER BY a.id ASC LIMIT 1;');
$stmt->execute();
$rows = $stmt->fetchAll();
foreach ($rows as $row) {
    # code...
    $post_id = $row['post_id'];
    $time = $row['datetime'];
    $uid = $row['uid'];
    $content = $row['content'];
    $spintax = new Spintax();
    $content = $spintax->process(trim($content));
    $token = $row['token'];    
    $datetime = date('Y-m-d H:i:s', time());
    $base_dir = 'http://' . $_SERVER['SERVER_NAME'] . dirname(__FILE__);
    if ($time <= $datetime) {
        # code...
        $feed = $uid . '/photos';
        $caption = '';
        $published = 'false';
        $stmt = $pdo->prepare('SELECT * FROM image WHERE post_id = :post_id;');
        $stmt->bindParam(':post_id', $post_id);
        $stmt->execute();
        $links = $stmt->fetchAll();

        # Post photos
        $photos = array(
            'message' => $content
        );
        # Post single img.
        foreach ($links as $key => $value) {
            $img = $value['link'];
            $link = $base_dir . $img;
            $params = array (
                'url' => $link,
                'caption' => $caption,
                'published' => 'false',
                'access_token' => $token
            );
            $url = 'https://graph.facebook.com/'.$feed;
            $post = fb_posts($url, $params);        
            $id = $post['id'];
            if (!empty($id)) {
                $photos["attached_media[$key]"] = '{"media_fbid":"'.$id.'"}';
            }
        }
        $photos['access_token'] = $token;
        $feed = $uid . '/feed';
        $url = 'https://graph.facebook.com/'.$feed;
        $photo_posts = fb_posts($url, $photos);
        $status = $photo_posts['post_supports_client_mutation_id'];
        if ($status == True) {
            # code...
            $success = $photo_posts['id'];
            $stmt = $pdo->prepare('UPDATE posts SET success = :success, status = "publish" WHERE post_id = :post_id;');
            $stmt->bindParam(':success', $success);
            $stmt->bindParam(':post_id', $post_id);
            $stmt->execute();
        } else {
            # code...
            $stmt = $pdo->prepare('UPDATE posts SET status = "fail" WHERE post_id = :post_id;');
            $stmt->bindParam(':post_id', $post_id);
            $stmt->execute();
        }
    }
}
?>