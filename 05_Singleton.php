<?php

/**
 * Singletonパターン
 * 指定したクラスのインスタンスが絶対に１個しか存在しないことを保証したい
 * インスタンスが１個しか存在しないことをプログラム上で表現したい
 */

namespace sample05 {
    class Singleton {
        private static $singleton;

        private function __construct() {
            print("インスタンスを生成しました" . PHP_EOL);
        }
        public static function getInstance() {
            // PHPではプロパティ(メンバ変数)の初期化に式を使えない模様なので、ここで初期化を行う。
            // ただしこれは厳密にはSingletonパターンにはならないとのこと（練習問題）
            // マルチスレッドで実行した時に、単一のインスタンスになることを保証できないため。
            if (is_null(self::$singleton)) {
                self::$singleton = new Singleton();
            }
            return self::$singleton;
        }
    }

    print("start" . PHP_EOL);
    $obj1 = Singleton::getInstance();
    $obj2 = Singleton::getInstance();

    if ($obj1 === $obj2) {
        print("obj1 is obj2");
    } else {
        print("obj1 is not obj2");
    }
    print(PHP_EOL);
    print("end");
}