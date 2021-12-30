<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['username'])) {
    $_SESSION['username'] = "Guest"; 
    $_SESSION['isLogged'] = False;
    $_SESSION['role'] = 0;
}
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header("location: ./index.php");
}

function error($message) {
    echo '<div id="error">';
    echo $message;
    echo '</div>';
}

?>
<nav>
    <div id="title"> FLOOFS </div>
    <div id="nav">
        <a href="#" onclick="toggleMenu();"> ≡ </a>
        <a href="./index.php">home</a>
        <a href="./store.php">store</a>
        <a href="./adoption.php">adoption</a>
        <a href="./contact.php">contact</a>

        <?php 
        if(isset($_SESSION['isLogged']) && $_SESSION['isLogged'] === false) {
            echo '
            <a href="./login.php">login</a>
            <a href="./register.php">register</a>
            ';
        } else {
            if(isset($_SESSION['role']) && $_SESSION['role'] >= 1) {
                echo '    
                <a href="./inventory.php">inventory</a>
                ';
            }
            if(isset($_SESSION['role']) && $_SESSION['role'] >= 2) {
                echo '    
                <a href="./users.php">users</a>
                ';
            }
            echo '
            <a href="./index.php?logout=1" >logout</a>
            <a href="./profile.php" >profile</a>
            ';
        }

        ?>

        <a href="#" style="hover=none;">Welcome, <?php echo $_SESSION['username'] ?></a>
    </div>

    <script type="text/javascript">
    function toggleMenu() {
        var content = document.getElementById("content");
        var menu = document.getElementById("menu");
        if (menu.offsetWidth === 0) {
            menu.style.transition = "0.5s";
            content.style.transition = "margin-left 0.5s";
            menu.style.width = "260px";
            content.style.marginLeft = "260px";
            localStorage.setItem("sidenav", "open");
        } else {
            menu.style.transition = "0.5s";
            content.style.transition = "margin-left 0.5s";
            menu.style.width = "0px";
            content.style.marginLeft = "0px";
            localStorage.setItem("sidenav", "closed");
        }
    }

    window.onload = function() {
        var content = document.getElementById("content");
        var menu = document.getElementById("menu");
        if(typeof(Storage) !== "undefined") {
            if (localStorage.getItem("sidenav") === "open") {
                menu.style.transition = "0s";
                content.style.transition = "0s";

                menu.style.width = "260px";
                content.style.marginLeft = "260px";
            }
        }
    }
    </script>
</nav> 
        <?php  include './menu.php';?>
<?php
