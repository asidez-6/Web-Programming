<?php
$connection = mysqli_connect("localhost", "root", "", "blog");

if(!connection){
    die("Connection failed: ".mysqli_connect_error());
}

$query = "SELECT title, date, picture, content FROM article";
$result = mysqli_query($connection,$query);

