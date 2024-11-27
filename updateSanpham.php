<?php
include "connectDB.php";
$edit_id = $_GET['edit_id'];
    $sql_query = "select * from products where ProductID = '" . $edit_id . "'";
    $connect = connection_DB();
    $result = mysqli_query($connect, $sql_query);
    $rows = mysqli_fetch_array($result);
    $ProductName = $rows[1];
    $CategoryName = $rows[2];
    $Size = $rows[3];
    $Color = $rows[4];
    $Price = $rows[5];
    $Quantity = $rows[6];
    $ImageURL = $rows[7];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Updata San pham</title>
    <link rel="stylesheet" href="css.css">
</head>

<body>
    <?php
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $ProductName = htmlspecialchars(trim($_POST['name_product'] ?? ''));
        $CategoryName = htmlspecialchars(trim($_POST['name_category'] ?? ''));
        $Size = htmlspecialchars(trim($_POST['size'] ?? ''));
        $Color = htmlspecialchars(trim($_POST['color'] ?? ''));
        $Price = htmlspecialchars(trim($_POST['price'] ?? ''));
        $Quantity = htmlspecialchars(trim($_POST['quantity'] ?? ''));
        $sql_update = "update products set ProductName = '$ProductName', CategoryName = '$CategoryName', Size = '$Size', Color = '$Color', Price = '$Price', Quantity = '$Quantity', ImageURL = '$ImageURL' ";
        $result_update = mysqli_query($connect, $sql_update);
        echo "<script>alert('Update product successfully!!!')
            window.location.href='qlSanpham.php';
        </script>";
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && is_uploaded_file(($_FILES['file']['tmp_name']))) {
        try {
            if ($_FILES['file']['error'] !== UPLOAD_ERR_OK) {
                throw new Exception("Loi khi upload file. Ma loi: " . $_FILES['file']['error']);
            }
            $fileName = $_FILES['file']['name'];
            $fileTmpPath = $_FILES['file']['tmp_name'];
            $fileSize = $_FILES['file']['size'];
            $fileType = mime_content_type($fileTmpPath);

            $uploadDir = 'uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $destination = $uploadDir . basename($fileName);

            if (!move_uploaded_file($fileTmpPath, $destination)) {
                throw new Exception("khong the di chuyen file den thu muc dich.");
            }
        } catch (Exception $e) {
            echo "<p style = 'color: red;'>Loi: " . $e->getMessage() . "</p>";
        }
        $ProductName = htmlspecialchars(trim($_POST['name_product'] ?? ''));
        $CategoryName = htmlspecialchars(trim($_POST['name_category'] ?? ''));
        $Size = htmlspecialchars(trim($_POST['size'] ?? ''));
        $Color = htmlspecialchars(trim($_POST['color'] ?? ''));
        $Price = htmlspecialchars(trim($_POST['price'] ?? ''));
        $Quantity = htmlspecialchars(trim($_POST['quantity'] ?? ''));
        $sql_update = "update products set ProductName = '$ProductName', CategoryName = '$CategoryName', Size = '$Size', Color = '$Color', Price = '$Price', Quantity = '$Quantity', ImageURL = '$destination' ";
        $result_update = mysqli_query($connect, $sql_update);
        echo "<script>alert('Update product successfully!!!')
            window.location.href='qlSanpham.php';
        </script>";
    }
    ?>
 <div id="contenair">
        <form method = "POST" action="#" enctype = "multipart/form-data">
        <div class ="form-group">
                <label for="product_id">Mã sản phẩm :</label>
                <input type="text" name="product_id" id="product_id" placeholder = "Enter Product ID" value="<?= $edit_id ?>" readonly>
                <span class="error"><?= $error['product_id'] ?? '' ?></span>
            </div>
            <div class ="form-group">
                <label for="name_product">Tên sản phẩm :</label>
                <input type="text" name="name_product" id="name_product" placeholder = "Enter Product Name" value="<?= $ProductName ?>">
                <span class="error"><?= $error['name_product'] ?? '' ?></span>
            </div>
            <div class ="form-group">
                <label for="name_category">Tên danh mục: </label>
                <input type="text" name="name_category" id="name_category" placeholder = "Enter Category Name" value="<?= $CategoryName ?>">
                <span class="error"><?= $error['name_category'] ?? '' ?></span>
            </div>
            <div class ="form-group">
                <label for="size">Kích thước: </label>
                <input type="text" name="size" id="size" placeholder = "Enter Size" value="<?= $Size ?>">
                <span class="error"><?= $error['size'] ?? '' ?></span>
            </div>
            <div class ="form-group">
                <label for="color">Màu sắc: </label>
                <input type="text" name="color" id="color" placeholder = "Enter Color" value="<?= $Color ?>">
                <span class="error"><?= $error['color'] ?? '' ?></span>
            </div>
            <div class ="form-group">
                <label for="price">Giá: </label>
                <input type="number" name="price" id="price" placeholder = "Enter Price"  value="<?= $Price ?>">
                <span class="error"><?= $error['price'] ?? '' ?></span>
            </div>
            <div class ="form-group">
                <label for="quantity">Số lượng:</label>
                <input type="number" name="quantity" id="quantity" placeholder = "Enter Quantity" value="<?= $Quantity ?>" >
                <span class="error"><?= $error['quantity'] ?? '' ?></span>
            </div>
            <div  class ="form-group">
                <label for="ImageURL">Image</label>
                <img style="height: 150px;width:auto" src="<?= $ImageURL ?>" alt="">
            </div>
            <div class ="form-group">
                <label for="anh">Ảnh: </label>
                <input type="file" name="file" id="file" >
                <span class="error"><?= $error['anh'] ?? '' ?></span>
            </div>
            <button type="submit" name = "edit">Lưu</button>
        </form>
</body>

</html>