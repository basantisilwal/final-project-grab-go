<?php
$conn= mysqli_connect("localhost","root","","`grab&go`");
if(!$conn){
    echo "Connection Failed" .mysqli_connect_error() or die();
}