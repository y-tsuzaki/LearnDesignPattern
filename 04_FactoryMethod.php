<?php

/***
 * Factory Method
 * インスタンス生成をサブクラスに任せる
 */

abstract class Product {
    public abstract function use(): void;
}

abstract class Factory {
    public final function create(String $owner): Product {
        $p = $this->createProduct($owner);
        $this->registerProduct($p);
        return $p;
    }

    protected abstract function createProduct(String $owner): Product;
    protected abstract function registerProduct(Product $product): void;
}


class IDCard extends Product {
    private $owner;

    /**
     * IDCard constructor.
     * @param $owner
     */
    function __construct($owner) // 同じパッケージからしかアクセスできない
    {
        $this->owner = $owner;
    }

    public function use(): void {
        echo "use " . $this->owner . PHP_EOL;
    }

    public function getOwner(): String {
        return $this->owner;
    }
}

class IDCardFactory extends Factory {
    private $owners = [];
    protected function createProduct($owner): Product {
        return new IDCard($owner);
    }
    protected function registerProduct(Product $product): void
    {
        $this->owners[] = ((object)$product)->getOwner();
    }
}

$fac = new IDCardFactory();
$c1 = $fac->create("A");
$c2 = $fac->create("B");
$c3 = $fac->create("C");
$c1->use();
$c2->use();
$c3->use();