<?php
require 'connectDB.php';
function validate_form(){
    $data = [
        'product_id' => '',
        'name_product'=> '',
        'name_category'=> '',
        'size'=>'',
        'color'=>'',
        'price'=>'',
        'quantity'=>'',
        'anh'=>'',
    ];
    $error=[];
    if(empty($_POST['product_id'])){
        $error['product_id'] = "Vui lòng nhập mã sản phẩm!";
    }else{
        $data['product_id']= htmlspecialchars(trim($_POST['product_id']));
    if(empty($_POST['name_product'])){
        $error['name_product'] = "Vui lòng nhập tên sản phẩm!";
    }else{
        $data['name_product']= htmlspecialchars(trim($_POST['name_product']));
    }
    if(empty($_POST['name_category'])){
        $error['name_category'] = "Vui lòng nhập tên danh mục!";
    }else{
        $data['name_category']= htmlspecialchars(trim($_POST['name_category']));
    }
    if(empty($_POST['size'])){
        $error['size'] = "Vui lòng nhập kích thước sản phẩm!";
    }else{
        $data['size']= htmlspecialchars(trim($_POST['size']));
    }
    if(empty($_POST['price'])){
        $error['price'] = "Vui lòng nhập giá của sản phẩm!";
    }else{
        $data['price']= htmlspecialchars(trim($_POST['price']));
    }
    if(empty($_POST['color'])){
        $error['color'] = "Vui lòng nhập màu sản phẩm!";
    }else{
        $data['color']= htmlspecialchars(trim($_POST['color']));
    }
    if(empty($_POST['quantity'])){
        $error['quantity'] = "Vui lòng nhập số lượng sản phẩm!";
    }else{
        $data['quantity']= htmlspecialchars(trim($_POST['quantity']));
    }
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["file"])) {
        try {
            if ($_FILES['file']['error'] !== UPLOAD_ERR_OK) {
                throw new Exception("Lỗi khi upload file. Mã lỗi: " . $_FILES['file']['error']);
            }

            $fileName = basename($_FILES['file']['name']);
            $fileTmpPath = $_FILES['file']['tmp_name'];
            $fileSize = $_FILES['file']['size'];
            $fileType = mime_content_type($fileTmpPath);

            $allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];

            if (!in_array($fileType, $allowedTypes)) {
                throw new Exception("Loại file không được hỗ trợ. Chỉ chấp nhận JPG, PNG, PDF.");
            }

            if ($fileSize > 2 * 1024 * 1024) {
                throw new Exception("File quá lớn. Kích thước tối đa là 2MB.");
            }

            $uploadDir = 'uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $destination = $uploadDir . $fileName;

            if (!move_uploaded_file($fileTmpPath, $destination)) {
                throw new Exception("Không thể di chuyển file đến thư mục đích.");
            }
            $data['anh'] = $destination;
            echo "<p style='color: green;'>File '$fileName' đã được upload thành công.</p>";
        } catch (Exception $e) {
            echo "<p style='color: red;'>Lỗi: " . $e->getMessage() . "</p>";
        }
    }
}
    return ['data'=>$data,'error'=>$error]; 
}
if ($_SERVER["REQUEST_METHOD"] === "POST"){
    $result = validate_form();
    $data = $result['data'];
    $error = $result['error'];
    if (empty($error)) {
        $id = $data['product_id'];
        $product = $data['name_product'];
        $category = $data['name_category'];
        $size = $data['size'];
        $color =$data['color'];
        $price = $data['price'];
        $quantity =$data['quantity'];
        $anh = $data['anh'];
        $connect =  connection_DB(); 
        $query = "INSERT INTO products (ProductID, ProductName, CategoryName,Size,Color,Price,Quantity,ImageURL) VALUES ('$id', '$product', '$category','$size',' $color', '$price','$quantity','$anh')";
        if (mysqli_query($connect, $query)) {
            header("Location: qlSanpham.php");
            exit;
        } else {
            echo "<p style='color: red;'>Lỗi: " . mysqli_error($connect) . "</p>";
        }
}
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Them san pham</title>
    <link rel="stylesheet" href="css.css">
</head>
<body>
    <h1>Thêm sản phẩm</h1>
    <div id="contenair">
        <form method = "POST" action="#" enctype = "multipart/form-data">
        <div class ="form-group">
                <label for="product_id">Mã sản phẩm :</label>
                <input type="text" name="product_id" id="product_id" placeholder = "Enter Product ID" value="<?= htmlspecialchars($data['product_id'] ?? '') ?>">
                <span class="error"><?= $error['product_id'] ?? '' ?></span>
            </div>
            <div class ="form-group">
                <label for="name_product">Tên sản phẩm :</label>
                <input type="text" name="name_product" id="name_product" placeholder = "Enter Product Name" value="<?= htmlspecialchars($data['name_product'] ?? '') ?>">
                <span class="error"><?= $error['name_product'] ?? '' ?></span>
            </div>
            <div class ="form-group">
                <label for="name_category">Tên danh mục: </label>
                <input type="text" name="name_category" id="name_category" placeholder = "Enter Category Name" value="<?= htmlspecialchars($data['name_category'] ?? '') ?>">
                <span class="error"><?= $error['name_category'] ?? '' ?></span>
            </div>
            <div class ="form-group">
                <label for="size">Kích thước: </label>
                <input type="text" name="size" id="size" placeholder = "Enter Size" value="<?= htmlspecialchars($data['size'] ?? '') ?>">
                <span class="error"><?= $error['size'] ?? '' ?></span>
            </div>
            <div class ="form-group">
                <label for="color">Màu sắc: </label>
                <input type="text" name="color" id="color" placeholder = "Enter Color" value="<?= htmlspecialchars($data['color'] ?? '') ?>">
                <span class="error"><?= $error['color'] ?? '' ?></span>
            </div>
            <div class ="form-group">
                <label for="price">Giá: </label>
                <input type="number" name="price" id="price" placeholder = "Enter Price"  value="<?= htmlspecialchars($data['price'] ?? '') ?>">
                <span class="error"><?= $error['price'] ?? '' ?></span>
            </div>
            <div class ="form-group">
                <label for="quantity">Số lượng:</label>
                <input type="number" name="quantity" id="quantity" placeholder = "Enter Quantity" value="<?= htmlspecialchars($data['quantity'] ?? '') ?>">
                <span class="error"><?= $error['quantity'] ?? '' ?></span>
            </div>
            <div class ="form-group">
                <label for="anh">Ảnh: </label>
                <input type="file" name="file" id="file" >
                <span class="error"><?= $error['anh'] ?? '' ?></span>
            </div>
            <button type="submit" name = "add">Lưu</button>
        </form>

    </div>
</body>
</html>