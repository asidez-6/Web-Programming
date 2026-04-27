<!DOCTYPE html>
<html>
<head>
    <title>PHP</title>
</head>
<body>
    <h1>
        <?php
            //echo
            echo "Hello, World!<br>";

            //var
            $name = "andi";
            echo "name: $name<br>";

            //op
            $val1 = 80;
            $val2 = 90;
            $sum = $val1 + $val2;
            echo "$val1 + $val2 = $sum <br>";

            //condition
            $Val = 75;
            if($Val >= 70){
                echo "passed<br>";
            }else{
                echo "not pass<br>";
            }

            //loop
            for ($i=0; $i < 5 ; $i++) { 
                echo "#$i data <br>";
            }
            $list = ["andi", "Budi", "Citra"];
            foreach ($list as $names) { 
                echo $names."<br>";
            }
        ?>
    </h1>
</body>
</html> 