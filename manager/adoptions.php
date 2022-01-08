<?php 
require_once('../config.php');
if (!$current_user->isAtLeast("manager")) {
    mysqli_close($link);
    header("location: ../index.php");
}
?>

<html>
    <head>
        <title> Adoptions </title>
    </head>
    
    <body>
        <div id="content" style="margin-left:0px">
            Adoptions page
            <?php
                DB::displayTable('Adoption');
            ?>
        </div> 

	</body>
</html>

<?php
mysqli_close($link);
