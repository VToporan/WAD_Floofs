<?php 
require_once('../config.php');
if (!$current_user->isAtLeast("manager")) {
    mysqli_close($link);
    header("location: ../index.php");
}

$message = "Manage inventory and adoption listings";
$anchors = [
    "Users" => [
        "Url" => "./users.php",
        "Image" => "admin/users.jpeg",
    ],
];
?>

<html>
    <head>
        <title> Admin </title>
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
