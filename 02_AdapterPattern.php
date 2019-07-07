<?php


/**
 * 別称 Wrapperパターン
 * Adapterパターンには2種類ある
 * - クラスによるAdapterパターン（継承を使ったもの）
 * - インスタンスによるAdapterパターン（委譲を使ったもの）
 */

namespace sample02 {

    interface MyPrint
    {
        public function printWeak(): void;

        public function printStrong(): void;
    }

    class Banner
    {
        private $string;

        public function Banner(String $string)
        {
            $this->string = $string;
        }

        public function showWithParen(): void
        {
            print('(' . $this->string . ')');
        }

        public function showWithAster(): void
        {
            print('*' . $this->string . '*');
        }
    }

    class PrintBanner extends Banner implements MyPrint
    {

        public function printWeak(): void
        {
            $this->showWithParen();
        }

        public function printStrong(): void
        {
            $this->showWithAster();
        }
    }

    class Main
    {
        public static function run()
        {
            $printBanner = new PrintBanner("ice born");
            $printBanner->printWeak();
            print(PHP_EOL);
            $printBanner->printStrong();
        }
    }

    Main::run();
}