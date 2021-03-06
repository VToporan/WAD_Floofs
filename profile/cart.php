<?php 
require_once('../config.php');
if(!$current_user->isLogged()){
    mysqli_close($link);
    header("location: ../index.php");
}
?>

<html>
    <head>
        <title> Cart </title>
    </head>
    
    <body>
        <div id="content" style="margin-left:0px">
        <?php
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            if(isset($_REQUEST["purchase"])) {
                $current_user->purchaseItems();
            }
            else if(isset($_REQUEST["remove"])) {
                $id = mysqli_real_escape_string($link, $_REQUEST["remove"]);
                $current_user->removeItem($id); 
            }
        } 
        echo "Cart total: \$". $current_user->total();
        $current_user->displayCart();
        ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <button type="submit" class="submit-button" name="purchase" value="1"
             onclick="return confirm('Are you sure this is your purchase?');"> Purchase </button>
        </form>
        </div> 

	</body>
</html>

<?php
