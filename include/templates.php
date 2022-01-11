<?php
class Template {
    public static function adminPage($table, $condition = null) {
        if(isset($_REQUEST["delete"])) {
            $id = $_REQUEST["delete"];
            if(!DB::delete($table, $id, $condition)) {
                error("Could not delete from $table - id $id!");
            } else {
                message("Deleted from $table - id $id");
                self::actionButton("back", true);
            }
            return;
        }           

        if(isset($_REQUEST["insert"])) {
            DB::displayInsert($table);
            return;
        }

        if(isset($_REQUEST["edit"])) {
            $id = $_REQUEST["edit"];
            DB::displayEdit($table, $id, $condition);
            return;
        }

        DB::displayTable($table, $condition);
    }


    public static function actionButton($action, $id, $confirm = null) {
        $conf = "";
        if(!is_null($confirm)) {
            $conf = sprintf("onclick=\"return confirm('%s');\"", $confirm);
        } 
        echo "<td class=\"button_td\">"; 
        echo "<form action=\"". $_SERVER["PHP_SELF"] . "\" method=\"post\" enctype=\"multipart/form-data\" id=\"form$id\">";
        echo "<button type=\"submit\" class=\"$action-button\" name=\"$action\" value=$id $conf> $action </button>";
        echo "</form>";
        echo "</td>";
    }

    public static function mainPage($message, $anchors) {
        $root = '/Floofs/images';
        $width = 100 / count($anchors);
        echo "<br> $message";
        echo "<div style=\"width:100%\">";
        foreach($anchors as $name=>$content) {
            $url = $content["Url"];
            $imgSource = $root . "/" . $content["Image"];
            echo "<a href=\"$url\" class=\"main_nav\" style=\"width:$width%\">";
            echo $name;
            echo "<img src=\"$imgSource\" class=\"nav_img\">";
            echo"</a>";
        }
        echo "</div>";
    }
}
?>
