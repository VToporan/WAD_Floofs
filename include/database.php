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
        $fields=[];
        foreach(array_combine($columns, $data) as $c=>$d) {
            $fields[] = " $c='$d' ";
        }
        $query .= join(", ", $fields);
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

    public static function displayHeader($columnNames) {
        echo "<tr>"; 
        foreach($columnNames as $column) {
            if (!self::isPassword($column)) {
                printf("<th> %s </th> \n", $column);
            }
        } 
        echo "</tr>";
    }

    public static function displayCell($row, $column) {
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

    public static function displayInput($column, $defaultValue = null, $edit = null, $hidden = null) {
        $length = 30;
        $type = "text";
        $value = "";
        if (self::isImage($column)) $type = "file";
        if (self::isPassword($column)) $type = "password"; 
        if (self::isEmail($column)) $type = "email"; 
        if (self::isDescription($column)) $length = "512"; 
        if (!is_null($defaultValue)) $value = $defaultValue;
        if (!is_null($edit) && self::isPassword($column)) $type = "hidden";
        if (!is_null($hidden)) $type = "hidden";
        if (is_null($hidden))
            echo "<label><b> $column </b></label>";
        echo "<input type=\"$type\" name=\"$column\" maxlength=\"$length\" value=\"$value\" required>";
    }

    public static function displayInsert($table, $condition = null, $defaultValues = null, $title = null) {
        $pkName = self::tablePK($table);
        $columnNames = self::getColumnNames($table);
        $columnNames = array_diff($columnNames, [$pkName]);
        $err = "";

        if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_REQUEST["insert"]) && $_REQUEST["insert"] == 2) {
            self::handleInput($table, $columnNames, $err);
        }

        if(!is_null($title)) {
            echo "<div style=\"display:block\"> $title </div>"; 
        } else {
            echo "<div style=\"display:block\"> Add into - $table</div>"; 
            Template::actionButton('back', true);
        }
        echo "<form action=\"". $_SERVER["PHP_SELF"] . "\" method=\"post\" enctype=\"multipart/form-data\">";
        if(!is_null($defaultValues)) {
            foreach($defaultValues as $col=>$data) {
                $columnNames = array_diff($columnNames, [$col]);
                self::displayInput($col, $defaultValue=$data, $edit=null, $hidden=true);
            }
        }
        foreach($columnNames as $column) {
            self::displayInput($column);
        }
        echo "<input type=\"hidden\" name=\"insert\" value=2 />";
        echo "<span style=\"color: red\"> $err </span>";
        echo "<button type=\"submit\" class=\"submit-button\"> Add </button>";
        echo "</form>";
    }

    public static function displayEdit($table, $id, $condition = null) {
        $pkName = self::tablePK($table);
        $columnNames = self::getColumnNames($table);
        $columnNames = array_diff($columnNames, [$pkName, "Password", "Image"]);
        $condition[] = $pkName . "=" . $id;
        $err = "";

        if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_REQUEST["edit1"])) {
            self::handleEdit($table, $columnNames, $err, $condition);
        }

        try {
            $dbItem = DB::select($table, $columnNames, $condition);
            if (!$dbItem || mysqli_num_rows($dbItem) != 1) { 
                throw new Exception("Error fetching data!" . var_dump($dbItem)); 
            }
            $dbItem = mysqli_fetch_array($dbItem);
        }
        catch (Exception $e) {
            error($e);
            return;
        }

        echo "<div style=\"display:block\"> Edit table $table on id $id </div>"; 
        Template::actionButton('back', true);
        echo "<form action=\"". $_SERVER["PHP_SELF"] . "\" method=\"post\" enctype=\"multipart/form-data\">";
        foreach($columnNames as $column) {
            self::displayInput($column, $dbItem[$column], $edit=true);
        }
        echo "<input type=\"hidden\" name=\"edit1\" value=2 />";
        echo "<input type=\"hidden\" name=\"edit\" value=$id />";
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

    private static function handleField($column, &$err, $edit = null) {
        $data = "";
        if(self::isImage($column)) {
            $image = $_FILES[$column];
            if(!self::checkImage($image, $err)) 
                return "";
            $data = addslashes(file_get_contents($image["tmp_name"]));
        } else {
            $data = $_REQUEST[$column];
            if(!is_null($edit)) return $data;
            if(self::isPassword($column)) {
                $data = "SHA($data)";
            }
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

    private static function handleEdit($table, $columnNames, &$err, $condition) {
        foreach($columnNames as $column) {
            $data[] = self::handleField($column, $err, $edit = true);
            if($err !== "") return;
        }
        if(self::update($table, $columnNames, $data, $condition))
            $err = "All good!";
        else
            $err = "So not good so baad!";
    }
};
?>
