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
    $email = mysqli_real_escape_string($link, $_REQUEST['email']);
    $password = mysqli_real_escape_string($link, $_REQUEST['password']);
    $repeatPassword = mysqli_real_escape_string($link, $_REQUEST['repeatPassword']);

    $querry = "SELECT Username, Email FROM Users WHERE Username = '$user' and Email = '$email'";
    $result = mysqli_query($link, $querry);

    if (mysqli_num_rows($result) != 0)
        $err = "User already exists!";
    if($password !== $repeatPassword)
        $err = "Passwords don't match!";

    $insert = "INSERT INTO Users (Username, Email, Password, Role) VALUES ('$user', '$email', SHA('$password'), '0')";
    if(mysqli_query($link, $insert)) {
        $querry = "SELECT Username, Email, Role FROM Users WHERE Username = '$user' and Password = SHA('$password')";
        $result = mysqli_query($link, $querry);

        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_array($result);
            $_SESSION['username'] = $user;
            $_SESSION['isLogged'] = true;
            $_SESSION['role'] = $row["Role"];
            $_SESSION['u_id'] = $row["U_ID"];
            header("location: ./index.php");
        }
       else {
        echo '<script> alert("Something went wrong! Returning to main page!"); location="index.php" </script>';
    }
}

mysqli_close($link);

?>

<html>
    <head>
        <link rel="stylesheet" href="general.css">
    </head>

    <body>
        <?php include './navbar.php' ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label><b>Username</b></label>
            <input type="text" name="user" maxlength="30" placeholder="Enter Username" required>
            <label><b>Email</b></label>
            <input type="email" name="email" maxlength="30" placeholder="Enter Email" required>
            <label><b>Password</b></label>
            <input type="password" name="password" maxlength="30" placeholder="Enter Password" required>
            <label><b>Repeat Password</b></label>
            <input type="password" name="repeatPassword" maxlength="30" minlength="10" placeholder="Repeat Password" requiredi-->
            <button type="submit" class="submit-button"> Register </button>
        </form>
    </body> 
</html>

<?php

