<?php 
require_once('../config.php');
if (!$current_user->isAtLeast("manager")) {
    mysqli_close($link);
    header("location: ../index.php");
}
?>

<html>
    <head>
        <title> Manager </title>
    </head>
    
    <body>
        <div id="content" style="margin-left:0px">
            Manager page
        </div> 

	</body>
</html>

<?php
mysqli_close($link);
