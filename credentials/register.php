<?php
require_once("../config.php");
$err = "";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = mysqli_real_escape_string($link, $_REQUEST["user"]);
    $email = mysqli_real_escape_string($link, $_REQUEST["email"]);
    $password = mysqli_real_escape_string($link, $_REQUEST["password"]);
    $repeatPassword = mysqli_real_escape_string($link, $_REQUEST["repeatPassword"]);

    try {
    if ($password != $repeatPassword) {
        throw new Exception("Passwords do not match!");
    }

    if (User::existsInDB($link, $username)) {
        throw new Exception("Username already taken!");
    }

    if (!$current_user->register($link, $username, $email, $password)) {
        throw new Exception("Something went rong with the registration");
    }

    if (!$current_user->login($link, $username, $password)) {
        throw new Exception("Something went wrong when loggin in");
    }

    header("location: ../index.php");        
    }
    catch(Exception $e) {
        $err = $e->getMessage();
    }
}
?>

<html>
    <head>
        <title> Register </title>
    </head>
    <body>
        <div id="content" style="margin-left:0px">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label><b>Username</b></label>
            <input type="text" name="user" maxlength="30" placeholder="Enter Username" required>
            <label><b>Email</b></label>
            <input type="email" name="email" maxlength="30" placeholder="Enter Email" required>
            <label><b>Password</b></label>
            <input type="password" name="password" maxlength="30" placeholder="Enter Password" required>
            <label><b>Repeat Password</b></label>
            <input type="password" name="repeatPassword" maxlength="30" minlength="10" placeholder="Repeat Password" requiredi-->
            <span style="color: red"><?php echo $err ?></span>
            <button type="submit" class="submit-button"> Register </button>
        </form>
        <a href="./login.php"> Already have an account? Register here! </a>
        </div>
    </body>
</html>

<?php
mysqli_close($link);
