<?php 
require_once('./session.php');
$current_user = $_SESSION['user'];
?>

<html>
    <head>
        <link rel="stylesheet" href="general.css">
        <title> Profile </title>
    </head>
    
    <body>
        <?php require_once './navbar.php'; ?>
        <div id="content" style="margin-left:0px">
            Profile page
        </div> 

	</body>
</html>

<?php
