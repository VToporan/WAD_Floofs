<?php 
require_once('../config.php');
if (!$current_user->isAtLeast("admin")) {
    mysqli_close($link);
    header("location: ../index.php");
}
?>

<html>
    <head>
        <link rel="stylesheet" href="../general.css">
        <title> Inventory </title>
    </head>
    
    <body>
        <div id="content" style="margin-left:0px">
            Inventory page
        </div> 

	</body>
</html>

<?php
mysqli_close($link);
