<?php 
require_once('./config.php');
$anchors = [
    "Store" => [
        "Url" => "./store/store.php",
        "Image" => "store.jpeg",
    ],
    "Adoptions" => [
        "Url" => "./adoption/adoption.php",
        "Image" => "adoption.jpg",
    ],
    "Contact" => [
        "Url" => "./contact.php",
        "Image" => "contact.png",
    ],
];
?>

<html>
    <head>
        <title> Home </title>
    </head>
    
    <body>
        <div id="content" style="margin-left:0px">
        <?php
        Template::mainPage("Welcome to FLOOFS!", $anchors);
        ?>
        </div>
	</body>
</html>

<?php
