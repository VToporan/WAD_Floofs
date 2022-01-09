<?php 
require_once('../config.php');
if (!$current_user->isAtLeast("admin")) {
    mysqli_close($link);
    header("location: ../index.php");
}

$table = "Users";
$pkName = DB::tablePK($table);
$condition = [$pkName . "!=" . $current_user->id()];
?>

<html>
    <head>
        <title> Users </title>
    </head>
    
    <body>
        <div id="content" style="margin-left:0px">
            <?php 
            Template::adminPage($table, $condition);
            ?>
        </div> 

	</body>
</html>

<?php
mysqli_close($link);
