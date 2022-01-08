<?php 
require_once('../config.php');
if (!$current_user->isAtLeast("admin")) {
    mysqli_close($link);
    header("location: ../index.php");
}

$table = 'Users';
$pkName = DB::tablePK($table);
$condition = $pkName . "!=" . $current_user->id();
$err = "";
if(isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $result = DB::delete($table, $id, [$condition]);
    var_dump($result);
    if(!1) {
        $err = "Could not delete " . $id . "!";
    }
}
?>

<html>
    <head>
        <title> Users </title>
    </head>
    
    <body>
        <div id="content" style="margin-left:0px">
            <?php 
                echo "View table: " . $table;
                error($err);
                DB::displayTable($table, [$condition]);
            ?>
        </div> 

	</body>
</html>

<?php
mysqli_close($link);
