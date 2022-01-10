<?php
require_once('database.php');
class Item {
    private $name;
    private $description;
    private $price;
    private $quantity;
    private $maxQuantity;
    private $category;
    private $image;
    private $id;
    public static $table;
    public static $pk;
    public static $columns;
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
                throw new Exception("Invalid quantity! Item might have gotten out of stock...");
            }
            $this->maxQuantity = $dbItem["Quantity"];
            $this->name = $dbItem["Name"];
            $this->description = $dbItem["Description"];
            $this->price = $dbItem["Price"];
            $this->category = self::$categories[$dbItem["Category"]];
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
        Template::actionButton("remove", $this->id, "Are you sure you want to remove $this->name?");
        echo "</div>";
    }

    public static function displayAll($condition = null) {
        try {
            $dbItem = DB::select(self::$table, self::$columns, $condition);
            if (!$dbItem) { 
                throw new Exception("Error fetching item data!"); 
            }
            while ($item = mysqli_fetch_array($dbItem)) {
                $name = $item["Name"];
                $description = $item["Description"];
                $price = $item["Price"];
                $maxQuantity = $item["Quantity"];
                $image = base64_encode($item["Image"]);
                $id = $item[self::$pk];

                if($maxQuantity > 0) {
                    echo "<div class=\"store_item\">"; 
                } else {
                    echo "<div class=\"out_item\">"; 
                }
//                echo "<div class=\"item_img\"> <img src=\"data:image/png;base64, $image\"> </div>";
                echo "<div class=\"item_name\"> $name </div>";
                echo "<div class=\"item_desc\"> $description </div>";
                echo "<div class=\"display_price\"> \$$price </div>";
                echo "<input type=\"number\" name=\"quantity\" min=0 max=$maxQuantity value=0 form=\"$id\" required>";
                Template::actionButton("add to cart", $id, "Are you sure you want to add $name to cart?");
                echo "</div>";
            }

        } catch (Exception $e) {
            error($e->getMessage());
        }
    }

    public function updateQantity() {
        $diff = $this->maxQuantity - $this->quantity;
        $result = DB::update(self::$table, ["Quantity"], [$diff], [self::$pk . "=" . $this->id]);
        if(!$result) {
            error("Error updateing inventory!");
        }
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
?>
