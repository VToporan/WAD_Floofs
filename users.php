<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if(!isset($_SESSION['isLogged']) || $_SESSION['isLogged'] === false) {
    header("location: ./index.php");
}

if(!isset($_SESSION['role'])) { header("location: ./index.php"); }
if(isset($_SESSION['role']) && $_SESSION['role'] < 2) {
    header("location: ./index.php");
}   

$link = mysqli_connect("localhost", "root", "", "WAD_Floofs");
if ($link === false) {
    die("ERROR! Could not connect to Floofs database." . mysqli_connect_error());
}
?>

<html>
    <head>
        <link rel="stylesheet" href="general.css">
        <title> Users </title>
    </head>
    
    <body>
        <?php include './navbar.php'; ?>
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
