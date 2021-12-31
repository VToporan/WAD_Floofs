<?php 
require_once('./session.php');
$current_user = $_SESSION['user'];
?>

<nav>
    <div id="nav">
        <a href="#" onclick="toggleMenu();">  ≡   </a>
        <a href="./index.php">home</a>
        <a href="./store.php">store</a>
        <a href="./adoption.php">adoption</a>
        <a href="./contact.php">contact</a>

        <?php 
        if(!$current_user->isLogged()) {
            echo '
            <a href="./login.php">login</a>
            <a href="./register.php">register</a>
            ';
        } else {
            if($current_user->role() >= 1) {
                echo '    
                <a href="./inventory.php">inventory</a>
                ';
            }
            if($current_user->role() >= 2) {
                echo '    
                <a href="./users.php">users</a>
                ';
            }
            echo '
            <a href="./index.php?logout=1">logout</a>
            <a href="./profile.php" >profile</a>
            ';
        }

        ?>

        <a href="#" style="hover=none;">Welcome, <?php echo $current_user->username() ?></a>
    </div>

    <script type="text/javascript">
    function toggleMenu() {
        var content = document.getElementById("content");
        var menu = document.getElementById("menu");
        if (menu.offsetWidth === 0) {
            menu.style.transition = "0.5s";
            content.style.transition = "margin-left 0.5s";
            menu.style.width = "15vw";
            content.style.marginLeft = "15vw";
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

                menu.style.width = "15vw";
                content.style.marginLeft = "15vw";
            }
        }
    }
    </script>
</nav> 
        <?php  require_once './menu.php';?>
<?php
