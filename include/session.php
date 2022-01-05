<?php
class User{
    private $username = 'Guest';
    private $email = 'guest@example.com';
    private $role = -1;
    private $id = -1;
    private $isLogged = false;
    private $roleDef = [
        "default" => 0,
        "manager" => 1,
        "admin" => 2,
    ];

    public function username() { return $this->username; }
    public function email() { return $this->email; }
    public function role() { return $this->role; }
    public function id() { return $this->id; }
    public function isLogged() { return $this->isLogged; }

    public function login($link, $username, $password) {
        $query = "SELECT Username, Email, Role, U_ID FROM Users WHERE Username = '$username' and Password = SHA('$password')";
        $result = mysqli_query($link, $query);

        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_array($result);
            $this->username = $row["Username"];
            $this->email = $row["Email"];
            $this->role = $row["Role"];
            $this->id = $row["U_ID"];
            $this->isLogged = true;
            return true;
        }
        return false;    
    }

    public function register($link, $username, $email, $password) {
        $query = "INSERT INTO Users (Username, Email, Password, Role) VALUES ('$username', '$email', SHA('$password'), '0')";
        if(mysqli_query($link, $query)) {
            return true;
        }
        return false;
    }

    public static function existsInDB($link, $username) {
        $query = "SELECT Username, Email, Role, U_ID FROM Users WHERE Username = '$username'";
        $result = mysqli_query($link, $query);

        if (mysqli_num_rows($result) == 1)
            return true;
        return false;           
    }

    public function isAtLeast($roleName) {
        $cmpRole = 1000;
        if (array_key_exists($roleName, $this->roleDef)) {
            $cmpRole = $this->roleDef[$roleName];
        }
        return $this->role >= $cmpRole;
    }
}


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user'])) {
    $current_user = new User();
    $_SESSION['user'] = $current_user;
}

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['user']);
    header("location: ./index.php");
}

function error($message) {
    echo '<div id="error">';
    echo $message;
    echo '</div>';
}

?>
