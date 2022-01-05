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
        <title> Users </title>
    </head>
    
    <body>
        <div id="content" style="margin-left:0px">
            User admin page
            <?php 
                DB::displayTable('Users', 'U_ID != ' . $current_user->id());
            ?>
        </div> 

	</body>
</html>

<?php
mysqli_close($link);
