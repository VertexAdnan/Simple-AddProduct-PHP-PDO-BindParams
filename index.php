<?php
session_start();
include 'config/config.php';
$_SESSION['msg'] = "";
$msg = $_SESSION['msg'];

if (isset($_POST['add'])) {
    $pname = $_POST['name'];
    $pdesc = $_POST['desc'];
    $pimage = $_FILES['image']['name'];
    if (isset($pname) || isset($pdesc) || isset($pimage)) {
        $data = array(
            ':name' => $username,
            ':desc' => $password,
            ':image' => $pimage
        );

        // Check if image file is a actual image or fake image
        $target_dir = "images/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                echo "The file " . htmlspecialchars(basename($_FILES["image"]["name"])) . " has been uploaded.";
            }
        }

        $query = "INSERT INTO `products`(`pname`, `pdesc`, `pimage`) VALUES (:name,:desc,:image)";
        $stmt = $dbh->prepare($query);
        $stmt->bindParam(':name', $data[':name'], PDO::PARAM_STR, 12);
        $stmt->bindParam(':desc', $data[':desc'], PDO::PARAM_STR, 12);
        $stmt->bindParam(':image', $data[':image'], PDO::PARAM_STR, 24);
        $stmt->execute();

        if ($stmt) {
            $msg = "Item added";
        } else {
            $msg = "Something was wrong";
        }
    }
}


?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP</title>
    <link href="assets/style.css" rel="stylesheet" type="text/css">
    <link href="assets/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-2"></div>
            <div class="col-lg-6 col-md-8 login-box">
                <div class="col-lg-12 login-key">
                    <img class="img" src="av.png" alt="av">
                </div>
                <div class="col-lg-12 login-title">
                    <?php if (isset($_SESSION['msg'])) {
                        print_r($msg);
                    } else {
                        echo 'Add Product';
                    } ?>
                </div>

                <div class="col-lg-12 login-form">
                    <div class="col-lg-12 login-form">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="form-control-label">Product Name</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Product Desc</label>
                                <input type="text" name="desc" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Product Image</label>
                                <input type="file" name="image" id="image" class="form-control" required>
                            </div>
                            <div class="col-lg-12 loginbttm">
                                <div class="col-lg-6 login-btm login-button">
                                    <button type="submit" name="add" class="btn btn-outline-primary">Add</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-3 col-md-2"></div>
            </div>
        </div>
</body>

</html>