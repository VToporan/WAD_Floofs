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
<div id="footnote">
<p> Floofs </p>
<a href="mailto:victor.toporan@student.upt.ro"> Email </a>
<a href="tel:+40712345678"> Phone </a>
</div>
';

echo '</div>';
?>

<?php

