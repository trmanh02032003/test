<?php
    include "connectDB.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="trangchu.css">
</head>
<body>
    <header><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ3x-avGyroQcum7wnolqmuZmO6aO4YZjIkoQ&s" alt=""></header>
    <div class="banner">
        <img src="Screenshot 2024-11-26 175229.png" alt="">
    </div>
    <nav>
        <a href="Home.php">Trang chủ</a>
        <a href="Product.php">Sản phẩm</a>
        <a href="Cart.php">Giỏ hàng</a>
    </nav>
    <div class="container">
        <?php
            $sql_query = "select * from products";
            $connect= connection_DB();
            $result = mysqli_query($connect, $sql_query);
            if($result){
                while($rows = mysqli_fetch_array($result)){
                    echo "<div class='product'>
                        <img src=".htmlspecialchars($rows['ImageURL']).">
                        <h3>".htmlspecialchars($rows['ProductName'])."</h3>
                        <p>".htmlspecialchars($rows['Size'])."<span></span>".htmlspecialchars($rows['Color'])."</p>
                        <h2>".htmlspecialchars($rows['Price'])."</h2>
                    </div>";
                }
            }
        ?>
    </div>
    <aside>
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQn1fbMO74b4Vg5NgdnHc1EFyw0EUtx0t0M_Q&s" alt="">
        <img src="https://cdn2.fptshop.com.vn/unsafe/Uploads/images/tin-tuc/139048/Originals/RC_Collection_1000x1000%402x.png" alt="">
    </aside>
    <footer>
        
    </footer>
</body>
</html>