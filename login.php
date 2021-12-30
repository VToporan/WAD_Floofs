<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if(isset($_SESSION['isLogged']) && $_SESSION['isLogged'] === true) {
    header("location: ./index.php");
}

$link = mysqli_connect("localhost", "root", "", "WAD_Floofs");
if ($link === false) {
    die("ERROR! Could not connect to Floofs database." . mysqli_connect_error());
}

$err = "";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $user = mysqli_real_escape_string($link, $_REQUEST['user']);
    $password = mysqli_real_escape_string($link, $_REQUEST['password']);

    $querry = "SELECT Username, Email, Role FROM Users WHERE Username = '$user' and Password = SHA('$password')";
    $result = mysqli_query($link, $querry);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_array($result);
        $_SESSION['username'] = $user;
        $_SESSION['isLogged'] = true;
        $_SESSION['role'] = $row["Role"];
        $_SESSION['u_id'] = $row["U_ID"];
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
        <?php include './navbar.php'; ?>
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
