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
?>

<html>
    <head>
        <title> Adoption </title>
    </head>
    
    <body>
        <div id="content" style="margin-left:0px">
<?php
DB::displayInsert($table, $condition=null, $defaultValues=$default, $title="Add adoption listing");
?>
        </div> 
	</body>
</html>

<?php
mysqli_close($link);
