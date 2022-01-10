<?php 
require_once('../config.php');
if (!$current_user->isAtLeast("admin")) {
    mysqli_close($link);
    header("location: ../index.php");
}

$table = "Adoptions";
$pkName = DB::tablePK($table);
$condition = ["U_ID" . "==" . $current_user->id()];
?>

<html>
    <head>
        <title> My Adoptions </title>
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
