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
                    echo "<table>";
                    DB::displayHeader($display);
                    while($row = mysqli_fetch_array($result)) {
                        echo "<tr>";
                        $user = DB::select("Users", ["Email", "Username"], ["U_ID = " . $row["U_ID"]]);
                        if($user) {
                            $userData = mysqli_fetch_array($user);
                            $row["Email"] = $userData["Email"];
                            $row["Username"] = $userData["Username"];
                        }
                        foreach($display as $column) {
                            DB::displayCell($row, $column);
                        }
                        echo "</tr>";
                    }
                    echo "</table>";
                }
            ?>
        </div>
    </body>
</html>

<?php
mysqli_close($link);
