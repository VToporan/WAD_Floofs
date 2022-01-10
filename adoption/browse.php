<?php
require_once('../config.php');
?>

<html>
    <head>
        <title> Adoption </title>
    </head>
    
    <body>
        <div id="content" style="margin-left:0px">
            <?php
                $result = DB::select("Adoptions", ["Image", "Description", "U_ID"]);
                $display = ["Image", "Description", "Username", "Email"];

                if ($result) {
                    while($row = mysqli_fetch_array($result)) {
                        $user = DB::select("Users", ["Email", "Username"], ["U_ID = " . $row["U_ID"]]);
                        if($user) {
                            $userData = mysqli_fetch_array($user);
                            $row["Email"] = $userData["Email"];
                            $row["Username"] = $userData["Username"];
                        }
                        echo "<div class=\"store_item\" style=\"background-color:#FF90C6\">"; 
                        echo "<img src=\"data:image/png;base64,". base64_encode($row["Image"]). "\" class=\"store_img\">";
                        echo "<div>" . $row["Description"] . "</div>";
                        echo "<div> Contact </div>";
                        echo "<div> user: " . $row["Username"] . "</div>";
                        echo "<div> email: " . $row["Email"] . "</div>";
                        echo "</div>";
                    }
                }
            ?>
        </div>
    </body>
</html>

<?php
mysqli_close($link);
