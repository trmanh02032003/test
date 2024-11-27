<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <style>
        img{
            height: 150px;
            width: 150px;
        }
        tr,th{
            text-align: center;
            width: 150px;
        }
    </style>
</head>
<body>
    <center>

        <?php
            require "connectDB.php";
            $connect = connection_DB();
            $sql_query = "select * from products";
                $result = mysqli_query($connect, $sql_query);
                echo "<table border='1'>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Size</th>
                                <th>Color</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Image</th>
                            </tr>";
                            if($result){
                                while($rows = mysqli_fetch_array($result)){
                                    echo "<tr>
                                        <td>". htmlspecialchars($rows[0])."</td>
                                        <td>". htmlspecialchars($rows[1])."</td>
                                        <td>". htmlspecialchars($rows[2])."</td>
                                        <td>". htmlspecialchars($rows[3])."</td>
                                        <td>". htmlspecialchars($rows[4])."</td>
                                        <td>". htmlspecialchars($rows[5])."</td>
                                        <td>". htmlspecialchars($rows[6])."</td>
                                        <td><img src='".htmlspecialchars($rows[7])."'></td>
                                        <td>
                                            <form action='' method='POST'>
                                            <input type='hidden' name='id' value='" . $rows[0] . "'>
                                                <button type='submit' name='delete'>Delete</button>
                                                <button type='none'><a href = 'updateSanpham.php?edit_id=".$rows[0]."'>Edit</a></button>
                                            </form>
                                        </td>
                                    </tr>";
                                    if(isset($_POST['delete'])){
                                        $id_delete = $_POST['id'];
                                    }
                            }
                        };
                        "</table>";
                        if($_SERVER['REQUEST_METHOD']==='POST'){
                            $sql_delete = "delete from products where ProductID = '".$id_delete."'";
                            $result_del = mysqli_query($connect, $sql_delete);
                            echo "<script>
                                window.location.href = 'qlSanpham.php';
                            </script>";
                        }
        ?>
        <a href="trangchu.php" style="Color:blue">Back Home</a><br>
        <a href="addSanpham.php" style="Color:blue">Add New Product</a>
    </center>

</body>
</html>