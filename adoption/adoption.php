<?php
require_once('../config.php');
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
        Template::mainPage("Look for addoption opportunities or add your own!", $anchors);
        ?>
        </div>
    </body>
</html>

<?php
mysqli_close($link);
