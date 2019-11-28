<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

require_once "config.php";
require_once "function.php";

// Query facebook profiles
$user_id = $_SESSION["id"];
$stmt = $pdo->prepare('SELECT * FROM token WHERE user_id = :user_id limit 1;');
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$row = $stmt->fetch();
$token = $row['token'];

if (empty($token)) {
    # code...
    $token = 'Dán mã token vào đây...';
}
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Check if username is empty
    $stmt = $pdo->prepare('SELECT * FROM token WHERE id = :user_id; LIMIT 1;');
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $row = $stmt->fetch();
    if(empty(trim($_POST["token"]))){
        $token = "Bạn chưa nhập mã token...";
    } elseif(empty($row)) {
        $token = $_POST['token'];
        $graph = "https://graph.facebook.com/v5.0/me?fields=id,name&access_token=".$token;
        $profile = fanpage_id($graph);
        $name = trim($profile['name']);
        $uid = $profile['id'];
        $stmt = $pdo->prepare('INSERT INTO token (user_id, uid, name, token) VALUES (:user_id, :uid, :name, :token);');
        $stmt->bindParam(':uid', $uid);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
    }
    else{
        $token = trim($_POST["token"]);
        $graph = "https://graph.facebook.com/v5.0/me?fields=id,name&access_token=".$token;
        $profile = fanpage_id($graph);
        $name = trim($profile['name']);
        $uid = trim($profile['id']);
        $stmt = $pdo->prepare('UPDATE token SET uid = :uid, name = :name, token = :token WHERE id = :user_id;');
        $stmt->bindParam(':uid', $uid);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        $graph = "https://graph.facebook.com/v5.0/me?fields=accounts{id,name,access_token},id,name&access_token=".$token;
        $fanpage = fanpage_id($graph);
        foreach ($fanpage['accounts']['data'] as $name => $value){
            $uid = $value['id'];
            $name = $value['name'];
            $token = $value['access_token'];
            $stmt = $pdo->prepare('SELECT * FROM token WHERE id = :user_id;');
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();
            $rows = $stmt->fetchAll();
            foreach ($rows as $row) { 
                # code...
                if ($row['uid'] == $uid){
                    $stmt = $pdo->prepare('UPDATE token SET uid = :uid, name = :name, token = :token WHERE id = :user_id;');
                }else {
                    $stmt = $pdo->prepare('INSERT INTO token(user_id, uid, name, token) VALUES (:user_id, :uid, :name, :token);');
                }
                
                $stmt->bindParam(':uid', $uid);
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':token', $token);
                $stmt->bindParam(':user_id', $user_id);
                $stmt->execute();
            }
        }
    }
}
$stmt = $pdo->prepare('SELECT * FROM token WHERE user_id = :user_id;');
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$rows = $stmt->fetchAll();
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Đăng bài viết Fanpage tự động | Tú Phạm</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script type="text/javascript">
    $(document).ready(function (e) {
        $("#uploadForm").on('submit',(function(e) {
            e.preventDefault();
            $.ajax({
                url: "upload.php",
                type: "POST",
                data:  new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                success: function(data){
                $("#imgUpload").html(data);
                $("#uploadForm")[0].reset();
                $("#txtFile").text("Choose file");
                $('img.card-img-top').attr('src', 'images/example.jpg');
                },
                error: function(){} 	        
        });
        }));
    });
    </script>
    <script>
    function preview_images(){
        var total = document.getElementById("images").files.length;
        $("#txtFile").text("bạn đã chọn " + total + " ảnh...");
        for(var i = 0; i < total; i++){
            var imgUrl = URL.createObjectURL(event.target.files[i])
            document.getElementsByClassName("card-img-top")[i].src = imgUrl;
        }
    }
    </script>    
</head>
<body>
<div class="container">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Best Sellers</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="#">Trang chủ<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="reset-password.php">Đổi mật khẩu</a>
            </li>
            </ul>
            <span class="navbar-text">
                Xin chào, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>! (<a href="logout.php">thoát</a>)
            </span>
        </div>
    </nav>
    <div class="row">
        <div class="col-12">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="input-group mb-3">
                <h5 class="card-header">Token của bạn</h5>
                <input name="token" type="text" class="form-control" placeholder="<?php echo $token;?>">
                <div class="input-group-append">
                    <button name="update" class="btn btn-outline-secondary" type="submit">Cập Nhập</button>
                </div>
            </div>  
            </form>
        </div>
        
        <div class="col-md-7 col-lg-5 col-12" id="article">
        <form id="uploadForm" action="upload.php" method="POST" enctype="multipart/form-data">             
                <div class="card mt-2">
                    <h5 class="card-header">Đăng bài Fanpage</h5>
                    <div class="card-body">
                        <label>Vui lòng chọn hình ảnh để upload.</label>
                        <div class="custom-file">
                            <input name="image[]" type="file" class="custom-file-input" id="images" onchange="preview_images();" multiple>
                            <label id="txtFile" class="custom-file-label" for="inputGroupFile01">Choose file</label>
                        </div>                    
                        <div class="form-group mt-2">
                            <label for="comment">Hỗ trợ Spin bài viết. Cú pháp: {Kiều Anh|Anh Phạm}</label>
                            <textarea class="form-control" rows="7" name="comment" id="comment"></textarea>
                        </div>
                        <div class="form-row align-items-center">
                            <div class="col-6">
                            <label class="sr-only" for="time">time</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                <div class="input-group-text">Hẹn giờ đăng</div>
                                </div>
                                <input name="time" value="30" type="text" class="form-control" id="time" placeholder="30">
                            </div>
                            </div>
                            <div class="col-6">
                                <button type="submit" value="submit" class="btn btn-primary mb-2">ĐĂNG BÀI VIẾT</button>
                            </div>
                        </div>
                    </div>
                </div> 
                <div class="card-body">

                <p class="card-text" id="imgUpload"></p>
                </div>
        </div>

        <div class="col-md-5 col-lg-3 col-12 check-row">
            <div class="card mt-2">
                <h5 class="card-header">Danh sách tài khoản</h5>
                <div class="card-body">
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="checkAll">
                                    <label class="custom-control-label" for="checkAll"><b>Chọn tất cả</b></label>
                            </div>

                            <?php                            
                            foreach ($rows as $row){
                                echo '<div class="custom-control custom-checkbox">';
                                echo '<input name="uid[]" value="'. $row['id'] .'" type="checkbox" class="custom-control-input" id="'. $row['id'] .'">';
                                echo '<label class="custom-control-label" for="'. $row['id'] .'">' . $row['name'] . '</label>';
                                echo '</div>';
                            }
                            ?>
                        </div>
                </div>
            </div>
        </form> 
        </div>

<script>
$("#checkAll").click(function () {
    $(".custom-control-input").prop('checked', $(this).prop('checked'));
});
</script>
        <div class="col-md-12 col-lg-4 col-12">
                <div class="card mt-2">
                    <img class="card-img-top p-1" src="images/example.jpg" height="300">
                    <div class="d-flex">
                        <img class="col-4 p-1 card-img-top border border-warning" src="images/example.jpg">
                        <img class="col-4 p-1 card-img-top border border-warning" src="images/example.jpg">
                        <img class="col-4 p-1 card-img-top border border-warning" src="images/example.jpg">
                    </div>
                </div>
        </div>
    </div>
    <p class="d-flex justify-content-center">Copyright © 2019 Tú Phạm. All rights reserved.</p>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>