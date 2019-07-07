<?php

/***
 * Class AbstractDisplay
 * テンプレートとは何か
 * テンプレートというのは、文字の形に穴が空いている薄いプラスチックの板のことです。
 * その穴をペンでなぞると、手書きであっても整った文字を書くことができます。
 */

abstract class AbstractDisplay {
    public abstract function open(): void;
    public abstract function print(): void;
    public abstract function close(): void;

    public final function display(): void
    {
        $this->open();
        for ($i=0; $i<5; $i++) {
            $this->print();
        }
        $this->close();
    }
}

class CharDisplay extends AbstractDisplay {
    private $ch;
    public function __construct(String $ch)
    {
        $this->ch = $ch;
    }

    public function open(): void
    {
        print('<<');
    }

    public function print(): void
    {
        print($this->ch);
    }

    public function close(): void
    {
        print('>>' . PHP_EOL);
    }
}

class StringDisplay extends AbstractDisplay {
    private $string;
    private $width;
    public function __construct(String $string)
    {
        $this->string = $string;
        $this->width = mb_strlen($string);
    }

    public function open(): void
    {
        $this->printLine();
    }

    public function print(): void
    {
        print('|' . $this->string . '|' . PHP_EOL);
    }

    public function close(): void
    {
        $this->printLine();
    }

    private function printLine(){
        print('+');
        for ($i=0; $i< $this->width; $i++) {
            print('-');
        }
        print('+' . PHP_EOL);
    }
}


(new CharDisplay('a'))->display();
(new StringDisplay('push corn'))->display();
