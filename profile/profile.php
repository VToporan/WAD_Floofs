<?php 
require_once('../config.php');
if(!$current_user->isLogged()){
    header("location: ../index.php");
}
?>

<html>
    <head>
        <title> Profile </title>
    </head>
    
    <body>
        <div id="content" style="margin-left:0px">
            Profile page
        </div> 

	</body>
</html>

<?php
mysqli_close($link);
