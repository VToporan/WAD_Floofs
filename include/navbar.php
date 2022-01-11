<?php 
$current_user = $_SESSION['user'];
$root = '/Floofs';
$commonLinks = [
    "home" => "index.php",
    "store" => "store/store.php",
    "adoption" => "adoption/adoption.php",
    "contact" => "contact.php",
];
$loginLinks = [
    "login" => "credentials/login.php",
    "register" => "credentials/register.php",
];
$profileLinks = [
    "cart" => "profile/cart.php",
];
$managerLinks = [
    "manager" => "manager/manager.php",
];
$adminLinks = [
    "admin" => "admin/admin.php",
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
        echo "<div id=\"dropdown\">";
        echo "<a href=\"/Floofs/profile/profile.php\">Welcome," . $current_user->username() . "</a>";
        echo "<div id=\"drop\">";
        if(!$current_user->isLogged()) {
            displayButtons($loginLinks);
        } else {
            displayButtons($profileLinks);
            echo '<a href="' . $root . '/index.php?logout=1" onclick="return confirm(\'Are you sure to logout?\');">logout</a>';
        }
        echo "</div>";
        echo "</div>";
        ?>
    </div>

    <script type="text/javascript">
    function toggleMenu() {
        var content = document.getElementById("content");
        var menu = document.getElementById("menu");
        var width = window.screen.width;
        var menuWidth = "260px";
        if (width < 700) {
            menuWidth = "150px";
        }
        if (width > 1920) {
            menuWidth = "370px";
        }
        if (menu.offsetWidth === 0) {
            menu.style.transition = "0.5s";
            content.style.transition = "margin-left 0.5s";
            menu.style.width = menuWidth;
            content.style.marginLeft = menuWidth;
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
        var width = window.screen.width;
        var menuWidth = "260px";
        if (width < 900) {
            menuWidth = "150px";
        }
        if (width > 1920) {
            menuWidth = "370px";
        }
        if(typeof(Storage) !== "undefined") {
            if (localStorage.getItem("sidenav") === "open") {
                menu.style.transition = "0s";
                content.style.transition = "0s";

                menu.style.width = menuWidth;
                content.style.marginLeft = menuWidth;
            }
        }
    }
    </script>
</nav> 
<?php
