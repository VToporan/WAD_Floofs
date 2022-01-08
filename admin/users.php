<?php 
require_once('../config.php');
if (!$current_user->isAtLeast("admin")) {
    mysqli_close($link);
    header("location: ../index.php");
}

$table = 'Users';
$err = "";
if(isset($_GET['delete'])) {
    $id = $_GET['delete'];
    if(!DB::delete($table, $id)) {
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
            User admin page
            <?php 
                error($err);
                DB::displayTable($table, DB::tablePK($table) . ' != ' . $current_user->id());
            ?>
        </div> 

	</body>
</html>

<?php
mysqli_close($link);
