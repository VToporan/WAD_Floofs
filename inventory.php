<?php 
require_once('./session.php');
$current_user = $_SESSION['user'];
?>


<html>
    <head>
        <link rel="stylesheet" href="general.css">
        <title> Inventory </title>
    </head>
    
    <body>
        <?php require_once './navbar.php'; ?>
        <div id="content" style="margin-left:0px">
            Inventory page
        </div> 

	</body>
<?php
mysqli_close($link);
?>
</html>

<?php
