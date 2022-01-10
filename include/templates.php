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

        var_dump($_REQUEST);
        DB::displayTable($table, $condition);
    }


    public static function actionButton($action, $id, $confirm = null) {
        $conf = "";
        if(!is_null($confirm)) {
            $conf = sprintf("onclick=\"return confirm('%s');\"", $confirm);
        } 
        echo "<td>"; 
        echo "<form action=\"". $_SERVER["PHP_SELF"] . "\" method=\"post\" enctype=\"multipart/form-data\" id=\"form$id\">";
        echo "<button type=\"submit\" class=\"$action-button\" name=\"$action\" value=$id $conf> $action </button>";
        echo "</form>";
        echo "</td>";
    }
}
?>
