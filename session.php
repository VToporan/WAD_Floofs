<?php
class User{
    private $username = 'Guest';
    private $email = 'guest@example.com';
    private $role = -1;
    private $id = -1;
    private $isLogged = false;

    public function username() { return $this->username; }
    public function email() { return $this->email; }
    public function role() { return $this->role; }
    public function id() { return $this->id; }
    public function isLogged() { return $this->isLogged; }

    public function login($link, $username, $password) {
        $querry = "SELECT Username, Email, Role, U_ID FROM Users WHERE Username = '$username' and Password = SHA('$password')";
        $result = mysqli_query($link, $querry);

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
        $querry = "INSERT INTO Users (Username, Email, Password, Role) VALUES ('$username', '$email', SHA('$password'), '0')";
        if(mysqli_query($link, $querry)) {
            return true;
        }
        return false;
    }

    public static function existsInDB($link, $username) {
        $querry = "SELECT Username, Email, Role, U_ID FROM Users WHERE Username = '$username'";
        $result = mysqli_query($link, $querry);

        if (mysqli_num_rows($result) == 1)
            return true;
        return false;           
    }

    public function logout() {
        session_destroy();
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
