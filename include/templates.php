<?php
class Template {
    public static function adminPage($table, $condition = null) {
        if(isset($_REQUEST["delete"])) {
            $id = $_REQUEST["delete"];
            if(!DB::delete($table, $id, $condition)) {
                error("Could not delete from $table - id $id!");
            } else {
                message("Deleted from $table - id $id");
                DB::displayAnchor("back", true);
            }
            return;
        }           

        if(isset($_REQUEST["insert"])) {
            DB::displayInsert($table);
            return;
        }

        DB::displayTable($table, $condition);
    }
}
?>
