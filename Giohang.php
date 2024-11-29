<?php
session_start();
include "connectDB.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['giohang'])) {
    $cart_id = $_POST['cart_id'];

    $connect = connection_DB();

    $stmt = $connect->prepare("SELECT * FROM products WHERE ProductID = ?");
    $stmt->bind_param("s", $cart_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();

        $ProductName = $row['ProductName'];
        $CategoryName = $row['CategoryName'];
        $Size = $row['Size'];
        $Color = $row['Color'];
        $Price = $row['Price'];
        $Quantity = 1;
        $ImageURL = $row['ImageURL'];


        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        $productExists = false;
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['ProductID'] == $cart_id) {
                $item['Quantity']++;
                $productExists = true;
                break;
            }
        }

        if (!$productExists) {
            $_SESSION['cart'][] = [
                'ProductID' => $cart_id,
                'ProductName' => $ProductName,
                'CategoryName' => $CategoryName,
                'Size' => $Size,
                'Color' => $Color,
                'Price' => $Price,
                'Quantity' => $Quantity,
                'ImageURL' => $ImageURL
            ];
        }

        echo "Đã thêm sản phẩm vào giỏ hàng!";
    } else {
        echo "Sản phẩm không tồn tại!";
    }
}

if (!empty($_SESSION['cart'])) {
    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>Tên sản phẩm</th>
                <th>Kích thước</th>
                <th>Màu sắc</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Hình ảnh</th>
                <th>Xóa</th>
            </tr>";

    $total_price = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total_price += $item['Price'] * $item['Quantity'];
        echo "<tr>
                <td>" . htmlspecialchars($item['ProductID']) . "</td>
                <td>" . htmlspecialchars($item['ProductName']) . "</td>
                <td>" . htmlspecialchars($item['Size']) . "</td>
                <td>" . htmlspecialchars($item['Color']) . "</td>
                <td>" . htmlspecialchars($item['Price']) . "</td>
                <td>" . htmlspecialchars($item['Quantity']) . "</td>
                <td><img src='" . htmlspecialchars($item['ImageURL']) . "' width='50' height='50'></td>
                <form action='' method='POST'>
                 <input type='hidden' name='id' value='" . $item['ProductID'] . "'>
                <td><button type='submit' name='delete' class='btn btn-danger btn-sm'>Xóa</button></td>
                </form>
              </tr>";
    }

    echo "<tr>
            <td colspan='5'>Tổng tiền:</td>
            <td>" . $total_price . "</td>
            <td colspan='2'><a href='checkout.php'>Thanh toán</a></td>
          </tr>";
    echo "</table>";

    if (isset($_POST['delete'])) {
        $id_delete = $_POST['id'];
        foreach ($_SESSION['cart'] as $key => $item) {
            if ($item['ProductID'] == $id_delete) {
                unset($_SESSION['cart'][$key]);
                break;
            }
        }
        header("Location: Giohang.php");
        exit();
    }
} else {
    echo "Không có sản phẩm nào trong giỏ hàng!";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        img {
            height: 150px;
            width: 150px;
        }

        tr,
        th {
            text-align: center;
            width: 150px;
        }

        a {
            color: white;
            text-decoration: none;
        }
    </style>
</head>

<body>
        <button type="button" class="btn btn-success"><a href="trangchu.php">Tiếp tục mua hàng</a></button>
</body>

</html>