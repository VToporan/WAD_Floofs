<?php
require_once('templates.php');
class DB{
    private static $link = "";

    public static function setLink($link) {
        self::$link = $link;
    }

    private static function applyCondition(&$query, $condition = null) {
        if (!is_null($condition)) {
            $query .= " WHERE " . join(" AND ", $condition);
        }
    }

    public static function select($table, $columns, $condition = null) {
        $query = "SELECT " . join(", ", $columns) . " FROM " . $table;
        self::applyCondition($query, $condition);
        return mysqli_query(self::$link, $query);
    }

    public static function delete($table, $id, $condition = null) {
        $pkName = self::tablePK($table);
        $query = "DELETE FROM " . $table;
        $condition[] = $pkName . "=" . $id;
        self::applyCondition($query, $condition);
        return mysqli_query(self::$link, $query);
    }

    public static function insert($table, $columns, $data) {
        $query = "INSERT INTO $table (" . join(", ", $columns) . ") VALUES (" . join(", ", $data) . ")";
        return mysqli_query(self::$link, $query);
    }

    public static function update($table, $columns, $data, $condition = null) {
        $query = "UPDATE " . $table . " SET ";
        foreach(array_combine($columns, $data) as $c=>$d) {
            $query .= " $c='$d' ";
        }
        self::applyCondition($query, $condition);
        return mysqli_query(self::$link, $query);
    }

    public static function tableHeader($table) {
        $headerQuery = "SHOW COLUMNS FROM " . $table;
        $columns = mysqli_query(self::$link, $headerQuery);
        return $columns;
    }

    public static function tableData($table, $condition = null) {
        $dataQuery = "SELECT * FROM " . $table;
        self::applyCondition($dataQuery, $condition);
        $data = mysqli_query(self::$link, $dataQuery);
        return $data;
    }

    public static function tablePK($table) {
        $pkQuery = "SHOW KEYS FROM " . $table . " WHERE Key_name = \"PRIMARY\"";
        $pkData = mysqli_query(self::$link, $pkQuery);
        $pkArray = mysqli_fetch_array($pkData);
        $pkName = $pkArray["Column_name"];
        return $pkName;
    }

    private static function isPassword($columnName) {
        if (strcasecmp($columnName, "password") != 0) return false;
        return true;
    }

    private static function isImage($columnName) {
        if (strcasecmp($columnName, "image") != 0) return false;
        return true;
    }

    private static function isDescription($columnName) {
        if (strcasecmp($columnName, "description") != 0) return false;
        return true;
    }

    private static function isEmail($columnName) {
        if (strcasecmp($columnName, "email") != 0) return false;
        return true;
    }

    public static function getColumnNames($table) {
        $header = self::tableHeader($table);
        if(!$header) {
            error("No columns found!");
            return;
        }

        while($row = mysqli_fetch_array($header)) {
            $column = $row["Field"];
            $columnNames[] = $column;
        }
        return $columnNames;
    }

    private static function displayHeader($columnNames) {
        echo "<tr>"; 
        foreach($columnNames as $column) {
            if (!self::isPassword($column)) {
                printf("<th> %s </th> \n", $column);
            }
        } 
        echo "</tr>";
    }

    private static function displayCell($row, $column) {
        $cellData = $row[$column];

        if(self::isPassword($column)) return;
        if(self::isImage($column)) {
            echo "<td> <img src=\"data:image/png;base64,".base64_encode($cellData)."\"/ style=\"width:200px; height:200px\"> </td>";
            return;
        }
        printf("<td> %s </td>", $cellData);
    }

    public static function displayAnchor($action, $id, $confirm = null) {
        echo "<td>"; 
        $ref = sprintf("href=\"%s?%s=%s\"", $_SERVER["PHP_SELF"], $action, $id);
        $conf = "";
        if(!is_null($confirm)) {
            $conf = sprintf("onclick=\"return confirm('%s');\"", $confirm);
        } 
        printf("<a %s %s> %s </a>", $ref, $conf, $action); 
        echo "</td>";
    }

    public static function displayData($data, $columnNames, $pkName) {
        if(!$data) {
            error("No data found!");
            return;
        }
        while($row = mysqli_fetch_array($data)) {
            echo "<tr>"; 
            foreach($columnNames as $column) {
                self::displayCell($row, $column);
            }
            $id = $row[$pkName];
            Template::actionButton("delete", $id, "Are you sure you want to delete id " . $id);
            Template::actionButton("edit", $id);
            echo "</tr>";
        }

    }

    public static function displayTable($table, $condition = null) {
        $data = self::tableData($table, $condition);
        $pkName = self::tablePK($table);
        $columnNames = self::getColumnNames($table);
        
        echo "<div style=\"display:block\"> Table - $table</div>"; 
        Template::actionButton("insert", true);
        echo "<table>";
        self::displayHeader($columnNames);
        self::displayData($data, $columnNames, $pkName);
        echo "</table>";
    }

    public static function displayInput($column, $placeHolder = null) {
        $length = 30;
        $type = "text";
        if (self::isImage($column)) $type = "file";
        if (self::isPassword($column)) $type = "password"; 
        if (self::isEmail($column)) $type = "email"; 
        if (self::isDescription($column)) $length = "512"; 
        echo "<label><b> $column </b></label>";
        echo "<input type=\"$type\" name=\"$column\" maxlength=\"$length\" required>";
    }

    public static function displayInsert($table, $condition = null) {
        $pkName = self::tablePK($table);
        $columnNames = self::getColumnNames($table);
        $columnNames = array_diff($columnNames, [$pkName]);
        $err = "";

        if($_SERVER["REQUEST_METHOD"] == "POST" && $_REQUEST["insert"] == 2) {
            self::handleInput($table, $columnNames, $err);
        }

        echo "<div style=\"display:block\"> Add into - $table</div>"; 
        Template::actionButton('back', true);
        echo "<form action=\"". $_SERVER["PHP_SELF"] . "\" method=\"post\" enctype=\"multipart/form-data\">";
        foreach($columnNames as $column) {
            self::displayInput($column);
        }
        echo "<input type=\"hidden\" name=\"insert\" value=2 />";
        echo "<span style=\"color: red\"> $err </span>";
        echo "<button type=\"submit\" class=\"submit-button\"> Add </button>";
        echo "</form>";
    }

    private static function checkImage($image, &$err) {
        $allowedTypes = ["image/jpeg", "image/png"];
        $size = $image["size"];

        $type = $image["type"];
        if(!in_array($type, $allowedTypes)) {
            $err = "File type not allowed! Please add a .jpeg or .png file.";
            return false;
        }
        
        if($size > 4000000) {
            $err = "File too large! Please compress and reupload $size.";
            return false;
        }

        return true;
     }

    private static function handleField($column, &$err) {
        $data = "";
        if(self::isImage($column)) {
            $image = $_FILES[$column];
            if(!self::checkImage($image, $err)) 
                return "";
            $data = addslashes(file_get_contents($image["tmp_name"]));
        } else {
            $data = $_REQUEST[$column];
            if(self::isPassword($column)) 
                $data = "SHA($data)";
        }
        return "'" . $data . "'";
    }

    private static function handleInput($table, $columnNames, &$err) {
        foreach($columnNames as $column) {
            $data[] = self::handleField($column, $err);
            if($err !== "") return;
        }
        if(self::insert($table, $columnNames, $data))
            $err = "All good!";
        else
            $err = "So not good so baad!";
    }

};
?>
