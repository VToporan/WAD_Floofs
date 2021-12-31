<?php

echo '<div id="menu">';

$file = basename($_SERVER["PHP_SELF"]);
switch($file) {
case "index.php": 
    echo "Index";
    break;

case "adoption.php":
    echo '<a href="./adoption.php?view=add"> Add </a>';
    echo '<a href="./adoption.php?view=browse"> Browse </a>';
}

echo '
<a href="mailto:victor.toporan@student.upt.ro" class="footnote"> Email </a>
<a href="tel:+40712345678" class="footnote"> Phone </a>
';

echo '</div>';
?>

<?php

