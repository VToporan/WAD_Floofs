<?php
require_once('../config.php');
$message = "Look for adoption opportunities or add your own!";
$anchors = [
    "Browse" => [
        "Url" => "./browse.php",
        "Image" => "adoption/browse.jpeg",
    ],
    "Add listing" => [
        "Url" => "./add.php",
        "Image" => "adoption/add.jpg",
    ],
    "My listings" => [
        "Url" => "./listings.php",
        "Image" => "adoption/listings.jpg",
    ],
];
?>

<html>
    <head>
        <title> Adoption </title>
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
