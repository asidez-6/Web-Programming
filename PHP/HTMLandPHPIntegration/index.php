<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student List</title>
</head>
<body>
    <h2>Student List</h2>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>No</th>
            <th>Name</th>
        </tr>
        <?php
            $list = ["Andi", "Budi", "Citra"];
            $no = 1;

            foreach ($list as $Name) {
                echo "<tr>";
                echo "<td>".$no."</td>";
                echo "<td>".$Name."</td>";
                echo "</tr>";
                $no++;
            }
        ?>
    </table>
</body>
</html>