<?php 
require_once('../config.php');
if(!$current_user->isLogged()){
    header("location: ./error.php");
}

$err = "";
$table = "Adoptions";
$default = [
    "U_ID" => $current_user->id(),
];
$condition = ["U_ID = " . $current_user->id()];
?>

<html>
    <head>
        <title> My Listings </title>
    </head>
    
    <body>
        <div id="content" style="margin-left:0px">
        <?php
        if(isset($_REQUEST["delete"])) {
            $id = $_REQUEST["delete"];
            if(!DB::delete($table, $id, $condition)) {
                error("Could not delete from $table - id $id!");
            } else {
                message("Deleted from $table - id $id");
            }
        }           
        if(isset($_REQUEST["edit"])) {
            $id = $_REQUEST["edit"];
            DB::displayEdit($table, $id, $condition, $default);
        }
        DB::displayTable($table, $condition, "Adoption listing of " . $current_user->username());
        ?>
        </div> 
	</body>
</html>

<?php
mysqli_close($link);
