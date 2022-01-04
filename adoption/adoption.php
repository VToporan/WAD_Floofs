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
            <a href="./add.php" style="width:100%; height:50%">add</a>
            <a href="./browse.php" style="width:100%; height:50%">browse</a>
        </div>
    </body>
</html>

<?php
mysqli_close($link);
