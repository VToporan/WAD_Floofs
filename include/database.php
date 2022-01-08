<?php
class DB{
    private static $link = '';

    public static function setLink($link) {
        self::$link = $link;
    }

    private static function applyCondition(&$query, $condition = null) {
        if (!is_null($condition)) {
            $query .= " WHERE " . $condition;
        }
    }

    public static function select($columns, $table, $condition = null) {
        $query = "SELECT " . join(", ", $columns) . " FROM " . $table;
        self::applyCondition($query, $condition);
        return mysqli_query(self::$link, $query);
    }

    public static function delete($table, $id) {
        $pkName = self::tablePK($table);
        $query = "DELETE FROM " . $table . " WHERE " . $pkName . " = " . $id;
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
        $pkQuery = "SHOW KEYS FROM " . $table . " WHERE Key_name = 'PRIMARY'";
        $pkData = mysqli_query(self::$link, $pkQuery);
        $pkArray = mysqli_fetch_array($pkData);
        $pkName = $pkArray['Column_name'];
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

    private static function displayHeader($header, &$columnNames) {
        if(!$header) {
            error("No columns found!");
            return;
        }
        echo '<tr>'; 
        while($row = mysqli_fetch_array($header)) {
            $column = $row['Field'];
            $columnNames[] = $column;
            if (!self::isPassword($column)) {
                printf("<th> %s </th> \n", $column);
            }
        } 
        echo '</tr>';
    }

    private static function displayCell($row, $column) {
        $cellData = $row[$column];

        if(self::isPassword($column)) return;
        if(self::isImage($column)) {
            echo '<td> <img src="data:image/png;base64,'.base64_encode($cellData).'"/ style="width:200px; height:200px"> </td>';
            return;
        }
        printf("<td> %s </td>", $cellData);
    }

    private static function displayAnchor($action, $id, $confirm = null) {
        echo '<td>'; 
        $ref = sprintf("href=\"%s?%s=%s\"", $_SERVER["PHP_SELF"], $action, $id);
        $conf = "";
        if(!is_null($confirm)) {
            $conf = sprintf("onclick=\"return confirm('%s');\"", $confirm);
        } 
        printf("<a %s %s> %s </a>", $ref, $conf, $action); 
        echo '</td>';
    }

    public static function displayData($data, $columnNames, $pkName) {
        if(!$data) {
            error("No data found!");
            return;
        }
        while($row = mysqli_fetch_array($data)) {
            echo '<tr>'; 
            foreach($columnNames as $column) {
                self::displayCell($row, $column);
            }
            $id = $row[$pkName];
            self::displayAnchor('delete', $id, 'Are you sure you want to delete id ' . $id);
            self::displayAnchor('edit', $id);
            echo '</tr>';
        }

    }

    public static function displayTable($table, $condition = null) {
        $header = self::tableHeader($table);
        $data = self::tableData($table, $condition);
        $pkName = self::tablePK($table);
        $columnNames = [];
        echo '<table>';
        self::displayHeader($header, $columnNames);
        self::displayData($data, $columnNames, $pkName);
        echo '</table>';
    }
};
?>
