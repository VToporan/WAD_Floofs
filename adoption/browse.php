<?php
require_once('../config.php');
?>

<html>
    <head>
        <link rel="stylesheet" href="../general.css">
        <title> Adoption </title>
    </head>
    
    <body>
        <div id="content" style="margin-left:0px">
            <?php
                $querry = "SELECT Image, Description FROM Adoption";
                $result = mysqli_query($link, $querry);
                while ($row = mysqli_fetch_array($result)) {
                    $rows[] = $row;
                }
                foreach($rows as $row) {
                    echo '<img src="data:image/png;base64,'.base64_encode($row['Image']).'"/>';
                    printf("<p> %s </p>", $row['Description']);
                }
            ?>
        </div>
    </body>
</html>

<?php
mysqli_close($link);
