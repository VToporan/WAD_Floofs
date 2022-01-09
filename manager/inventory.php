<?php 
require_once('../config.php');
if (!$current_user->isAtLeast("manager")) {
    mysqli_close($link);
    header("location: ../index.php");
}

$table = "Items";
?>

<html>
    <head>
        <title> Inventory </title>
    </head>
    
    <body>
        <div id="content" style="margin-left:0px">
        <?php
        Template::adminPage($table);
        ?>
        </div> 

	</body>
</html>

<?php
mysqli_close($link);
