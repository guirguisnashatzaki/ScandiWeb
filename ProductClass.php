<?php
abstract class Product {
    protected $sku;
    protected $name;
    protected $price;
    protected $type;

    public function __construct($sku, $name, $price, $type) {
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
        $this->type = $type;
    }

    abstract public function save($conn);
    abstract public function getAttributes();
}

class DVD extends Product {
    private $size;

    public function __construct($sku, $name, $price, $type, $size) {
        parent::__construct($sku, $name, $price, $type);
        $this->size = $size;
    }

    public function save($conn) {
        $attributes = $this->getAttributes();
        $stmt = $conn->prepare("INSERT INTO products (sku, name, price, type, size) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdsi", ...$attributes);
        $stmt->execute();
        $stmt->close();
    }

    public function getAttributes() {
        return [$this->sku, $this->name, $this->price, $this->type, $this->size];
    }
}

class Furniture extends Product {
    private $height;
    private $width;
    private $length;

    public function __construct($sku, $name, $price, $type, $height, $width, $length) {
        parent::__construct($sku, $name, $price, $type);
        $this->height = $height;
        $this->width = $width;
        $this->length = $length;
    }

    public function save($conn) {
        $attributes = $this->getAttributes();
        $stmt = $conn->prepare("INSERT INTO products (sku, name, price, type, height, width, length) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdsiii", ...$attributes);
        $stmt->execute();
        $stmt->close();
    }

    public function getAttributes() {
        return [$this->sku, $this->name, $this->price, $this->type, $this->height, $this->width, $this->length];
    }
}

class Book extends Product {
    private $weight;

    public function __construct($sku, $name, $price, $type, $weight) {
        parent::__construct($sku, $name, $price, $type);
        $this->weight = $weight;
    }

    public function save($conn) {
        $attributes = $this->getAttributes();
        $stmt = $conn->prepare("INSERT INTO products (sku, name, price, type, weight) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdsi", ...$attributes);
        $stmt->execute();
        $stmt->close();
    }

    public function getAttributes() {
        return [$this->sku, $this->name, $this->price, $this->type, $this->weight];
    }
}
?>
