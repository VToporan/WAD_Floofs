<?php
$file = basename($_SERVER["PHP_SELF"]);
$dir = basename(dirname($_SERVER["PHP_SELF"]));
$dirLinks = [
    "Floofs" => [
       "main" => "index.php", 
       "contact" => "contact.php", 
    ],
    "adoption" => [
        "main" => "adoption.php",
        "add listing" => "add.php",
        "browse listings" => "browse.php",
    ],
    "credentials" => [
        "login" => "login.php",
        "register" => "register.php",
    ],
    "profile" => [
        "main" => "profile.php",
        "change password" => "pass.php",
    ],
    "manager" => [
        "main" => "manager.php",
        "inventory" => "inventory.php",
        "adoptions" => "adoptions.php",
    ],
];

function displayMenuButtons($links) {
    if(!$links) return;
    foreach($links as $name => $url) {
        printf("<a href=\"./%s\"> %s </a>", $url, $name);
    }
}
?>

<div id="menu">
    <?php 
        if (array_key_exists($dir, $dirLinks)) {
            displayMenuButtons($dirLinks[$dir]); 
        }
    ?>

    <div id="footnote">
        <a href="mailto:victor.toporan@student.upt.ro"> Email </a>
        <a href="tel:+40712345678"> Phone </a>
    </div>
</div>

<?php

