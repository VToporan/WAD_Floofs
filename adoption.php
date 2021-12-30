<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$link = mysqli_connect("localhost", "root", "", "WAD_Floofs");
if ($link === false) {
    die("ERROR! Could not connect to Floofs database." . mysqli_connect_error());
}
?>

<html>
    <head>
        <link rel="stylesheet" href="general.css">
        <title> Adoption </title>
    </head>
    
    <body>
        <?php include './navbar.php'; ?>
        <div id="content" style="margin-left:0px">
<?php
if (!isset($_GET['view'])) {
    $view = "main";
} else {
    $view = $_GET['view'];
}

switch($view) {
case "main":
    error("Main page");
    break;

case "add":
    if(!isset($_SESSION['isLogged']) || $_SESSION['isLogged'] === false){
        error("You must be logged in to add adoption listings!");
    } else {
        $err = "";
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
            $description = mysqli_real_escape_string($link, $_REQUEST['description']);
            $insert = "INSERT INTO Adoption (Image, Description, U_ID) VALUES ('$image', '$description', '1')";
            if(mysqli_query($link, $insert)) {
                $err = "All good!";
            } else {
                $err = "Something went wrong!";
            }
        }

        echo '
        <form action="./adoption.php?view=add" method="post" enctype="multipart/form-data">
            <label><b>Image</b></label>
            <input type="file" name="image" required>
            <label><b>Description</b></label>
            <input type="text" name="description" maxlength="512" placeholder="Description" required>
            <span style="color: red">'; echo $err; echo '</span>
            <button type="submit" class="submit-button"> Add </button>
        </form>
        ';
    }
    break;
case "browse":
    $querry = "SELECT Image, Description FROM Adoption";
    $result = mysqli_query($link, $querry);
    while ($row = mysqli_fetch_array($result)) {
        $rows[] = $row;
    }
    foreach($rows as $row) {
        echo '<img src="data:image/png;base64,'.base64_encode($row['Image']).'"/>';
        printf("<p> %s </p>", $row['Description']);
    }
    break;
}

mysqli_close($link);
?>
        </div> 

	</body>
</html>

<?php
