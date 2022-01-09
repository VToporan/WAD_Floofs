<?php 
require_once('../config.php');
if(!$current_user->isLogged()){
    header("location: ./error.php");
}

$err = "";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    var_dump($_FILES);
    $image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
    $description = mysqli_real_escape_string($link, $_REQUEST['description']);
    $id = $current_user->id();
    $insert = "INSERT INTO Adoption (Image, Description, U_ID) VALUES ('$image', '$description', '$id')";
    if(mysqli_query($link, $insert)) {
        $err = "All good!";
    } else {
        $err = "Something went wrong!";
    }
}
?>

<html>
    <head>
        <title> Adoption </title>
    </head>
    
    <body>
        <div id="content" style="margin-left:0px">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <label><b>Image</b></label>
                <input type="file" name="image" required>
                <label><b>Description</b></label>
                <input type="text" name="description" maxlength="512" placeholder="Description" required>
                <span style="color: red"><?php echo $err ?></span>
                <button type="submit" class="submit-button"> Add </button>
            </form>
        </div> 
	</body>
</html>

<?php
mysqli_close($link);
