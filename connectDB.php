<?php
function connection_DB() {
    $host = "localhost";
    $username ="root";
    $password = "";
    $database = "session9_form";
    $connect = mysqli_connect($host,$username,$password, $database);

   if ($connect) {
       
   } else {
       die("Kết nối không thành công: " . mysqli_connect_error());
   }
   return $connect;
}
?>