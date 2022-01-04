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
            $querry = "SELECT Username, Email, Role FROM Users";
            $result = mysqli_query($link, $querry);
            while ($row = mysqli_fetch_array($result)) {
                $rows[] = $row;
            }
            foreach($rows as $row) {
                printf("<p> %s / %s / %d </p>", $row['Username'], $row['Email'], $row['Role']);
            }
            ?>
        </div> 

	</body>
</html>

<?php
mysqli_close($link);
