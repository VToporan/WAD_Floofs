<?php 

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if(isset($_SESSION['isLogged']) && $_SESSION['isLogged'] === false) {
    header("location: ./index.php");
}

if(!isset($_SESSION['role'])) { header("location: ./index.php"); }
if(isset($_SESSION['role']) && $_SESSION['role'] < 1) {
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
        <title> Inventory </title>
    </head>
    
    <body>
        <?php include './navbar.php'; ?>
        <div id="content" style="margin-left:0px">
            Inventory page
        </div> 

	</body>
<?php
mysqli_close($link);
?>
</html>

<?php
