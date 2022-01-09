<?php 
$current_user = $_SESSION['user'];
$root = '/Floofs';
$commonLinks = [
    "home" => "index.php",
    "store" => "store/store.php",
    "adoption" => "adoption/add.php",
    "contact" => "contact.php",
];
$loginLinks = [
    "login" => "credentials/login.php",
    "register" => "credentials/register.php",
];
$profileLinks = [
    "profile" => "profile/profile.php",
    "cart" => "profile/cart.php",
];
$managerLinks = [
    "manager" => "manager/manager.php",
];
$adminLinks = [
    "admin" => "admin/users.php",
];


function displayButtons($dictLinks) {
    $root = '/Floofs';
    foreach($dictLinks as $name => $url) {
        printf("<a href=\"%s/%s\"> %s </a>", $root, $url, $name);
    }
}
?>

<nav>
    <div id="nav">
        <a href="#" onclick="toggleMenu();">═</a>
        <?php 
        displayButtons($commonLinks);

        if($current_user->isAtLeast("manager")) {
            displayButtons($managerLinks);
        }
        if($current_user->isAtLeast("admin")) {
            displayButtons($adminLinks);
        }
        ?>
        <div id="dropdown">
        <a href="#">Welcome, <?php echo $current_user->username() ?></a>
        <div id="drop">
        <?php
        if(!$current_user->isLogged()) {
            displayButtons($loginLinks);
        } else {
            displayButtons($profileLinks);
            echo '<a href="' . $root . '/index.php?logout=1" onclick="return confirm(\'Are you sure to logout?\');">logout</a>';
        }
        ?>
        </div>
        </div>
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
<?php
