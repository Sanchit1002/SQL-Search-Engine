<?php
$servername="localhost";
$username="root";
$password="";
$dbname="search";
//to create connection
$conn=mysqli_connect($servername,$username,$password,$dbname);
if($conn){
    echo "connected";
}
else{
    echo "faild";
}
?>
