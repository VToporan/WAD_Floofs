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

    public static function displayTable($table, $condition = null) {
        $headerQuery = "SHOW COLUMNS FROM " . $table;
        $columns = mysqli_query(self::$link, $headerQuery);
        $dataQuery = "SELECT * FROM " . $table;
        self::applyCondition($dataQuery, $condition);
        $data = mysqli_query(self::$link, $dataQuery);

        echo '<table>';
        echo '<tr>'; 
        while($row = mysqli_fetch_array($columns)) {
            $column = $row['Field'];
            $columnNames[] = $column;
            printf("<th> %s </th> \n", $column);
        } 
        echo '</tr>';
        while($row = mysqli_fetch_array($data)) {
            echo '<tr>'; 
            foreach($columnNames as $column) {
                printf("<td> %s </td>", $row[$column]);
            }
            echo '</tr>';
        }
            
        echo '</table>';
    }
};
?>
