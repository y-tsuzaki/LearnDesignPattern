<?php

interface MyIterator {
  public function hasNext(): bool;
  public function next(): Object;
}

interface MyAggregate {
    public function getIterator(): MyIterator;
}

class Book {
    private $name;
    public function __construct(String $name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }
}

class BookShelf implements MyAggregate {
    private $books = [];

    public function getBookAt(int  $index) {
        return $this->books[$index];
    }

    public function appendBook(Book $book) {
        $this->books[] = $book;
    }

    public function getLength(): int {
        return count($this->books);
    }

    public function getIterator(): MyIterator
    {
        return new BookShelfIterator($this);
    }
}

class BookShelfIterator implements MyIterator {
    private $bookShelf;
    private $index = 0;

    public function __construct($bookShelf)
    {
        $this->bookShelf = $bookShelf;
    }

    public function hasNext(): bool
    {
        return  $this->index < $this->bookShelf->getLength();
    }

    public function next(): Object
    {
        $book = $this->bookShelf->getBookAt($this->index);
        $this->index++;
        return $book;
    }
}

class Main {
    public static function run()
    {
        $shelf = new BookShelf();
        $shelf->appendBook(new Book('デザインパターン入門'));
        $shelf->appendBook(new Book('ゲーテルエッシャーバッハ'));
        $shelf->appendBook(new Book('感覚器の進化'));
        $iterator = $shelf->getIterator();
        while($iterator->hasNext()) {
            print($iterator->next()->getName() . PHP_EOL);
        }
    }
}

Main::run();