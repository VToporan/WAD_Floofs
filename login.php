<?php
require_once('./session.php');
$current_user = $_SESSION['user'];

$link = mysqli_connect("localhost", "root", "", "WAD_Floofs");
if ($link === false) {
    die("ERROR! Could not connect to Floofs database." . mysqli_connect_error());
}

$err = "";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = mysqli_real_escape_string($link, $_REQUEST['user']);
    $password = mysqli_real_escape_string($link, $_REQUEST['password']);

    if ($current_user->login($link, $username, $password) === true) {
        header("location: ./index.php");
    } else {
        $err = "Invalid credentials";
    }
}

mysqli_close($link);
?>

<html>
    <head>
        <link rel="stylesheet" href="general.css">
        <title> Login </title>
    </head>
    <body>
        <?php require_once './navbar.php'; ?>
        <div id="content" style="margin-left:0px">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label><b>Username</b></label>
            <input type="text" name="user" maxlength="30" placeholder="Enter Username" required>
            <label><b>Password</b></label>
            <input type="password" name="password" maxlength="30" placeholder="Enter Username" required>
            <span style="color: red"><?php echo $err ?></span>
            <button type="submit" class="submit-button"> Login </button>
        </form>
        <a href="./register.php"> Are you new? Register here!</a>
        </div>
    </body>
</html>

<?php
