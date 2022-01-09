<?php
require_once('../config.php');
class Item {
    private $name;
    private $description;
    private $price;
    private $quantity;
    private $maxQuantity;
    private $category;
    private $image;
    private $id;
    private static $table;
    private static $pk;
    private static $columns;
    public static $categories = [
        0 => "Cat",
        1 => "Dog",
    ];

    public static function init() {
        self::$table = "Items";
        self::$pk = DB::tablePK(self::$table);
        self::$columns = DB::getColumnNames(self::$table);
    }

    public function item($id, $quantity) {
        try {
            $this->id = $id;
            $this->quantity = $quantity;
            $condition = [self::$pk . "=" . $id];
            $dbItem = DB::select(self::$table, self::$columns, $condition);
            if (!$dbItem || mysqli_num_rows($dbItem) != 1) { 
                throw new Exception("Error fetching item data!"); 
            }
            $dbItem = mysqli_fetch_array($dbItem);
            if ($quantity > $dbItem["Quantity"] || $quantity < 1) {
                throw new Exception("Invalid quantity!");
            }
            $this->maxQuantity = $dbItem["Quantity"];
            $this->name = $dbItem["Name"];
            $this->description = $dbItem["Description"];
            $this->price = $dbItem["Price"];
            $this->category = self::$categories[$dbItem["Categoty"]];
            $this->image = base64_encode($dbItem["Image"]);

        } catch (Exception $e) {
            error($e->getMessage());
        }
    }

    public function display() {
        echo "<div class=\"item_frame\">"; 
        echo "<div class=\"item_img\"> <img src=\"data:image/png;base64, $this->image\"> </div>";
        echo "<div class=\"item_name\"> $this->name </div>";
        echo "<div class=\"item_desc\"> $this->description </div>";
        echo "<div class=\"item_categ\"> $this->category </div>";
        echo "<div class=\"item_price\"> $this->price </div>";
        echo "<div class=\"item_quant\"> $this->quantity </div>";
        echo "</div>";
    }
    public function name() { return $this->name; }
    public function description() { return $this->description; }
    public function price() { return $this->price; }
    public function quantity() { return $this->quantity; }
    public function maxQuantity() { return $this->maxQuantity; }
    public function category() { return $this->category; }
    public function image() { return $this->image; }
    public function id() { return $this->id; }
}

Item::init();

?>
