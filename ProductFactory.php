<?php
class ProductFactory {
    private static $productMap = [
        'DVD' => 'DVD',
        'Furniture' => 'Furniture',
        'Book' => 'Book'
    ];

    public static function create($sku, $name, $price, $type, $attributes) {
        if (!isset(self::$productMap[$type])) {
            throw new Exception("Invalid product type");
        }

        $className = self::$productMap[$type];
        return new $className($sku, $name, $price, $type, ...array_values($attributes));
    }
}
?>
