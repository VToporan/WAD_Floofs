<?php 
require_once('../config.php');

$err = "";
$condition = null;
if(isset($_REQUEST["category"])) {
    $category = $_REQUEST["category"];
    $condition[] = "Category = $category";
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = mysqli_real_escape_string($link, $_REQUEST["add_to_cart"]);
    $quantity = mysqli_real_escape_string($link, $_REQUEST["quantity"]);
    $current_user->addItem(new Item($id, $quantity));
}
?>

<html>
    <head>
        <title> Store </title>
    </head>
    
    <body>
        <div id="content" style="margin-left:0px">
            <div style="margin:auto"> Store </div>
            <?php
            error($err);
            Item::displayAll($condition);
            ?>
        </div> 

	</body>
</html>

<?php
