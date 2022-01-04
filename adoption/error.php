<?php
require_once('../config.php');
?>

<html>
    <head>
        <link rel="stylesheet" href="../general.css">
        <title> Adoption </title>
    </head>
    
    <body>
        <div id="content" style="margin-left:0px">
            <?php error('You need to login to add adoption listings'); ?>
        </div> 
	</body>
</html>

<?php
mysqli_close($link);
