<?php 
require_once('../config.php');
if (!$current_user->isAtLeast("manager")) {
    mysqli_close($link);
    header("location: ../index.php");
}

$table = 'Adoption';
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
        <title> Adoptions </title>
    </head>
    
    <body>
        <div id="content" style="margin-left:0px">
            Adoptions page
            <?php
                error($err);

                if(isset($_REQUEST['insert'])) {
                    DB::displayInsert($table);
                }
                else {
                    DB::displayTable($table);
                }
            ?>
        </div> 

	</body>
</html>

<?php
mysqli_close($link);
