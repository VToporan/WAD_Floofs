<?php
require_once('../config.php');
$err = "";
$table = "Users";
$columns = ["Password"];
$condition = ["U_ID = " . $current_user->id()];
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $password = mysqli_real_escape_string($link, $_REQUEST['password']);
    $repeatPassword = mysqli_real_escape_string($link, $_REQUEST['repeatPassword']);
    $oldPassword = mysqli_fetch_array(DB::select($table, $columns, $condition))["Password"];
    
    try {
        if ($password != $repeatPassword) {
            throw new Exception("Passwords do not match!");
        }

        $password = sha1($password);
        if ($password == $oldPassword) {
            throw new Exception("New password can not be old password!");
        }

        $result = DB::update($table, $columns, [$password], $condition);
        if(!$result) {
            var_dump($result);
            throw new Exception("Error occured when updating password! Please try again");
        }

        header("location: ./profile.php");
    }
    catch (Exception $e) {
        $err = $e->getMessage();
    }
}
?>

<html>
    <head>
        <title> Change Password </title>
    </head>
    <body>
        <div id="content" style="margin-left:0px">
        Change password
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label><b>New Password</b></label>
            <input type="password" name="password" maxlength="30" placeholder="Enter Password" required>
            <label><b>Repeat Password</b></label>
            <input type="password" name="repeatPassword" maxlength="30" minlength="10" placeholder="Repeat Password" requiredi-->
            <span style="color: red"><?php echo $err ?></span>
            <button type="submit" class="submit-button" onclick="return confirm('Are you sure?')"> Change password </button>
        </form>
        </div>
    </body>
</html>

<?php
mysqli_close($link);
