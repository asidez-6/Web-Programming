<?php
#1. connect to database
$host = "localhost";
$user = "root";
$pass = "";
$db = "blog";

$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) {
    die("connection failed :" . mysqli_connect_error());
}

#2. take data from database
$sql = "SELECT * FROM article ORDER BY date DESC";
$result = mysqli_query($conn, $sql);
$articleList = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $articleList[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic PHP dan JavaScript</title>
</head>

<body>
    <h2>Content Navigation</h2>
    <?php
    //navigation button according to article count
    for ($i = 0; $i < count($articleList); $i++) {
        echo "<button onclick= 'ShowArticle'>" . ($i + 1) . "</button>";
    }
    ?>

    <hr>
    <!-- div to show content-->
    <div id="Content">
        <h3><?php echo $articleList[0]['title'] ?? ''; ?></h3>
        <p><em><?php echo $articleList[0]['date'] ?? ''; ?></em></p>
        <?php if (!empty($articleList[0]['picture'])): ?>
            <img src="<?php echo $articleList[0]['picture']; ?>" width="200"><br>
        <?php endif; ?>
        <p><?php echo $articleList[0]['content'] ?? ''; ?></p>
    </div>
    <script>
        //PHP data conversion to JavaScript Array
        const article = <?php echo json_encode($articleList, JSON_HEX_TAG); ?>;

        //function to show article according to index
        function ShowArticle(index) {
            const ContentDiv = document.getElementById("Content");
            ContentDiv.innerHTML = "<h3>" + article[index].title + "</h3>" +
                "<p><em>" + article[index].date + "</em></p>" +
                (article[index].picture ? "<img src='" +
                    article[index].picture + "' width='200'><br>" : "") +
                "<p>" + article[index].content + "</p>";
        }
    </script>
</body>

</html>