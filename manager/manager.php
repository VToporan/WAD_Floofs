<?php 
require_once('../config.php');
if (!$current_user->isAtLeast("manager")) {
    mysqli_close($link);
    header("location: ../index.php");
}

$message = "Manage inventory and adoption listings";
$anchors = [
    "Inventory" => [
        "Url" => "./inventory.php",
        "Image" => "manager/inventory.jpg",
    ],
    "Adoptions" => [
        "Url" => "./adoptions.php",
        "Image" => "manager/adoptions.jpg",
    ],
];
?>

<html>
    <head>
        <title> Manager </title>
    </head>
    
    <body>
        <div id="content" style="margin-left:0px">
        <?php
        Template::mainPage($message, $anchors);
        ?>
        </div> 

	</body>
</html>

<?php
mysqli_close($link);
