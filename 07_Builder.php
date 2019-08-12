<?php

/**
 * Builderパターン
 * 複雑なインスタンスを組み上げる
 *
 * # 登場人物
 * - Builder
 * - ConcreteBuilder : Builder役のインターフェースを継承した実際のインスタンス作成で呼び出されるメソッドが定義される
 * - Director : Builder役のメソッドを実行しインスタンスを作成する。ConcreteBuilderには依存しない。
 * - Client
 *
 * メモ：
 * 誰が何を言っているか
 * MainはBuilderのメソッドを知らない
 * DirectorはConcreteBuilderのメソッドを知らない
 * 細かい建設手順を知らなくても、どんな風な種類の建築物を作るか切り替えることができるのがBuilderパターンの特徴だと思った。
 *
 * 現実で例えると。
 * 現実世界で例えるとすると次のような感じだろうか。
 * 依頼者からは具体的な仕事内容が隠蔽される、依頼者はどんな建造物を立てるか選ぶだけ。
 * ディレクターは仕事の段取りを指示する
 * 建築会社は指定された建物が作れるように、指示された段取りごとに作業する
 * 実際の作業は、指定された建物がどんなものであるかによって異なる
 * 依頼者->ディレクター->建築会社->実際の作業
 */
namespace sample07 {

    use Error;

    abstract class Builder
    {
        abstract function makeTitle(String $title);

        abstract function makeString(String $str);

        abstract function makeItems(array $items);

        abstract function close(): void;
    }

    class Director
    {
        /**
         * @var Builder
         */
        private $builder;

        /**
         * Director constructor.
         * @param Builder $builder
         */
        public function __construct(Builder $builder)
        {
            $this->builder = $builder;
        }

        public function construct()
        {
            $this->builder->makeTitle("Greeting");
            $this->builder->makeString("朝から昼にかけて");
            $this->builder->makeItems([
                "おはようございます",
                "こんにちは"
            ]);
            $this->builder->makeString("夜に");
            $this->builder->makeItems(["こんばんは", "おやすみなさい", "さようなら"]);
            $this->builder->close();
        }
    }

    class TestBuilder extends Builder
    {

        private $buffer = "";

        function makeTitle(String $title)
        {
            $this->buffer .= "===========================\n";
            $this->buffer .= "『${title}』\n";
            $this->buffer .= "\n";
        }

        function makeString(String $str)
        {
            $this->buffer .= "■${str}\n";
            $this->buffer .= "\n";
        }

        function makeItems(array $items)
        {
            foreach ($items as $item) {
                $this->buffer .= "　・${item}\n";

            }
            $this->buffer .= "\n";
        }

        function close(): void
        {
            $this->buffer .= "===========================\n";
        }

        function getResult(): String
        {
            return $this->buffer;
        }
    }


    class HtmlBuilder extends Builder
    {
        private $filename;
        private $buffer = "";

        function makeTitle(String $title)
        {
            $this->filename = $title . ".html";
            $this->buffer .= "<html><head><title>${title}</title></head><body>\n";
            $this->buffer .= "<h1>${title}</h1>";
        }

        function makeString(String $str)
        {
            $this->buffer .= "<p>${str}</p>";
        }

        function makeItems(array $items)
        {
            $this->buffer .= "<ul>";
            foreach ($items as $item) {
                $this->buffer .= "<li>${item}</li>";
            }
            $this->buffer .= "</ul>";
        }

        function close(): void
        {
            $this->buffer .= "</body></html>";
            file_put_contents($this->filename, $this->buffer);
        }

        function getResult(): String
        {
            return $this->filename;
        }
    }

    class Main
    {
        static function main(array $arg)
        {
            if (count($arg) == 1) {
                throw new Error();
            }
            if ($arg[1] == "plain") {
                $textBuilder = new TestBuilder();
                $director = new Director($textBuilder);
                $director->construct();
                $result = $textBuilder->getResult();
                print($result);
            } elseif ($arg[1] == "html") {
                $htmlBuilder = new HtmlBuilder();
                $director = new Director($htmlBuilder);
                $director->construct();
                $filename = $htmlBuilder->getResult();
                print("$filename が作成されました.");
            }
        }
    }

    Main::main($argv);
}