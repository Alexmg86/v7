<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use PHPHtmlParser\Dom;

class ParseSiteCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'site:parse';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $inner = [];
    protected $urls = [];
    protected $mainUrl = 'https://www.bork.ru';
    protected $count = 1;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->urls[] = $this->mainUrl;

        $this->getSiteMap();
    }

    public function getSiteMap()
    {
        $array = json_decode(json_encode(simplexml_load_file($this->mainUrl . '/sitemap.xml')), true)['url'];
        foreach ($array as $item) {
            $this->getByPage($item['loc']);
        }
    }

    public function getFileName($url)
    {
        $urlWithoutParam = explode('?', $url);
        $filename = 'index.txt';
        if ($urlWithoutParam[0] != $this->mainUrl . '/') {
            if (substr($urlWithoutParam[0], -1) == '/') {
                $url = substr($urlWithoutParam[0], 0, -1);
            }
            $filename = $url . '.txt';
        }
        return $filename;
    }

    public function getByPage($url)
    {
        $filename = $this->getFileName($url);
        
        dump($this->count . ' : ' . $filename);
        $this->count++;

        $dom = new Dom();
        $dom->loadFromUrl($this->mainUrl);

        if (isset($dom->find('title')[0])) {
            $this->inner[] = $dom->find('title')[0]->innerHtml;
        }

        $headItems = $dom->find('head')[0];
        $needHeaders = ['description', 'h1', 'keywords'];
        if (isset($headItems)) {
            foreach ($headItems as $headItem) {
                if (!$headItem->getTag()->hasAttribute('name')) {
                    continue;
                }
                $tag = $headItem->getTag();
                $name = $tag->getAttribute('name')->getValue();
                if (in_array($name, $needHeaders)) {
                    $this->inner[] = $tag->getAttribute('content')->getValue() . "\r\n";
                }
            }
        }

        $body = [];
        $bodyItems = $dom->find('body')[0];

        if (isset($bodyItems)) {
            $this->getText($bodyItems);
        }

        if (count($this->inner) > 0) {
            Storage::put("/site/" . $filename, $this->inner);
        }

        $this->inner = [];

        // $links = $dom->find('a');
        // if (isset($links)) {
        //     foreach ($links as $link) {
        //         if (!$link->getTag()->hasAttribute('href')) {
        //             continue;
        //         }
        //         $tag = $link->getTag();
        //         $href = $tag->getAttribute('href')->getValue();

        //         if (substr($href, 0, 2) == '//' || substr($href, 0, 1) != '/') {
        //             continue;
        //         }

        //         if (!in_array($href, $this->urls)) {
        //             $this->urls[] = $href;
        //             $this->getByPage($href);
        //         }
        //     }
        // }
    }

    public function getText($bodyItems)
    {
        foreach ($bodyItems as $bodyItem) {
            if ($bodyItem instanceof \PHPHtmlParser\Dom\Node\HtmlNode && $bodyItem->hasChildren()) {
                $this->getText($bodyItem->getChildren());
            } else {
                if (!empty(trim($bodyItem->text()))) {
                    $this->inner[] = trim($bodyItem->text()) . "\r\n";
                }
            }
        }
    }
}
