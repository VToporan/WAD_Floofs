<?php
$path = '/opt/lampp/htdocs/Floofs/include';
set_include_path(get_include_path() . PATH_SEPARATOR . $path);;
require_once('session.php');
require_once('database.php');
require_once('user.php');
require_once('templates.php');
require_once('item.php');
require_once('navbar.php');
require_once('menu.php');

$link = mysqli_connect("localhost", "root", "", "WAD_Floofs");
if ($link === false) {
    die("ERROR! Could not connect to Floofs database." . mysqli_connect_error());
}
$current_user = $_SESSION['user'];
DB::setLink($link);
Item::init();

function error($message) {
    if(!$message) return;
    echo '<div id="error">';
    echo $message;
    echo '</div>';
}

function message($message) {
    if(!$message) return;
    echo '<div id="message">';
    echo $message;
    echo '</div>';
}
?>

<head>
<link href='https://fonts.googleapis.com/css?family=Dekko' rel='stylesheet'>
<link rel="stylesheet" href="/Floofs/css/general.css">
<link rel="stylesheet" media="screen and (min-width: 1920px)" href="/Floofs/css/widescreen.css">
<link rel="stylesheet" media="screen and (max-width: 720px)" href="/Floofs/css/smallscreen.css">
</head>

<?php
