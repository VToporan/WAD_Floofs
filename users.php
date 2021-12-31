<?php 
require_once('./session.php');
$current_user = $_SESSION['user'];
?>

<html>
    <head>
        <link rel="stylesheet" href="general.css">
        <title> Users </title>
    </head>
    
    <body>
        <?php require_once './navbar.php'; ?>
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

mysqli_close($link);
?>
        </div> 

	</body>
</html>

<?php
