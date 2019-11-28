<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

require_once "config.php";
require_once "spintax.php";
$user_id = $_SESSION["id"];
?>
<?php
    // Check empty comment
    if(empty(trim($_POST['comment']))){
        echo "Bạn chưa nhập tin đăng...";
    }else{
        // $spintax = new Spintax();
        $content = trim($_POST['comment']);
        // $content = $spintax->process($content);
    }
    $addtime = 1;
    
    // Check empty profiles / fanpage posts
    if(empty($_POST['uid'])){
        echo "Bạn chưa chọn profiles / fanpage...";
    }else{
        $ids = $_POST['uid'];
    }
    if(!empty($content) && isset($_FILES['image'])){
        $stmt = $pdo->prepare('INSERT INTO content (user_id, content) VALUES (:user_id, :content);');
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':content', $content);
        $stmt->execute();
        $post_id = $pdo->lastInsertId();
        foreach ($ids as $row){
            $time = time() + $addtime*(int)$_POST['time']*60;
            $time = date('Y-m-d H:i:s', $time);
            $addtime = $addtime + 1;
            $uid = $row;
            $stmt = $pdo->prepare('INSERT INTO posts (datetime, user_id, uid, post_id) VALUES (:datetime, :user_id, :uid, :post_id);');
            $stmt->bindParam(':datetime', $time);
            $stmt->bindParam(':user_id', $_SESSION["id"]);
            $stmt->bindParam(':uid', $uid);
            $stmt->bindParam(':post_id', $post_id);
            $stmt->execute();
        }
        foreach ($_FILES['image']['name'] as $name => $value){
            $errors = array();
            $file_name = $_FILES['image']['name'][$name];
            $file_size =$_FILES['image']['size'][$name];
            $file_tmp = $_FILES['image']['tmp_name'][$name];
            $file_type = $_FILES['image']['type'][$name];
            $file_ext = strtolower(end(explode('.',$_FILES['image']['name'][$name])));
            
            $expensions = array("jpeg","jpg","png");

            if(in_array($file_ext, $expensions) === false){
                $errors = "Không chấp nhận định dạng ảnh có đuôi này, mời bạn chọn JPEG hoặc PNG.";
            }

            if(empty($file_ext) == true){
                $errors = "Bạn chưa chọn hình ảnh upload...";
            }
            
            if($file_size > 2097152){
                $errors = 'Kích cỡ file ảnh phải dưới 2 MB...';
            }
            
            if(empty($errors) == true){
                move_uploaded_file($file_tmp,"images/".$file_name);
                $link = "/images/".$file_name;
                try{
                    $stmt = $pdo->prepare('INSERT INTO image (link, post_id) VALUES (:link, :post_id)');
                    $stmt->bindParam(':link', $link);
                    $stmt->bindParam(':post_id', $post_id);
                    $stmt->execute(); 
                    
                } catch(PDOException $e){
                    die("ERROR!");
                }
            }       
        }
        if(empty($errors) == true){
            echo "Bạn đã đăng bài thành công...\n";
        }
        else{
            print_r($errors);
        }
    }
?>
