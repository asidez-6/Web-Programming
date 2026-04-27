<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Article List</title>
</head>
<body>
    
<h2>Article List</h2>

<?php
$connection = mysqli_connect("localhost", "root", "", "blog");
$result = mysqli_query($connection, "SELECT * FROM article");

while ($row = mysqli_fetch_assoc($result)) {
    echo "<div style = 'margin-bottom:20px;'>";
    echo "<h3>" . $row['title'] . "</h3>";
    echo "<p><em>" . $row['date'] . "<em><p>"; 
    echo "<img src = 'images/" . $row['picture'] . "' width = '200'><br>";
    echo "<p>" . $row['content'] . " </p>";
}   echo "<div>";
?>
</body>
</html>