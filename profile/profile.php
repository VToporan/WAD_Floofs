<?php 
require_once('../config.php');
if(!$current_user->isLogged()){
    header("location: ../index.php");
}

$message = "Hy, " . $current_user->username() . "!";
$anchors = [
    "Cart" => [
        "Url" => "./cart.php",
        "Image" => "profile/cart.jpg",
    ],
    "Change password" => [
        "Url" => "./pass.php",
        "Image" => "profile/password.jpg",
    ],
];
?>

<html>
    <head>
        <title> Profile </title>
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
