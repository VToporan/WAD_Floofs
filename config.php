<?php
$path = '/opt/lampp/htdocs/Floofs/include';
set_include_path(get_include_path() . PATH_SEPARATOR . $path);;
require_once('session.php');
require_once('navbar.php');
require_once('menu.php');

$current_user = $_SESSION['user'];

$link = mysqli_connect("localhost", "root", "", "WAD_Floofs");
if ($link === false) {
    die("ERROR! Could not connect to Floofs database." . mysqli_connect_error());
}
?>
