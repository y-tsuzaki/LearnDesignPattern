<?php


/**
 * インスタンスによるAdapterパターン（委譲を使ったもの）
 */

namespace sample02B {

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

    class PrintBanner implements MyPrint
    {
        private $banner;

        public function __construct(Banner $banner)
        {

            $this->banner = $banner;
        }

        public function printWeak(): void
        {
            $this->banner->showWithParen();
        }

        public function printStrong(): void
        {
            $this->banner->showWithAster();
        }
    }

    class Main
    {
        public static function run()
        {
            $printBanner = new PrintBanner(new Banner("ice born"));
            $printBanner->printWeak();
            print(PHP_EOL);
            $printBanner->printStrong();
        }
    }

    Main::run();
}