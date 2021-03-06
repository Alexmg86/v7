<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use PHPHtmlParser\Dom;

class ParseController extends Controller
{
    protected $inner = [];
    protected $urls = [];
    protected $mainUrl = 'https://www.bork.ru';

    public function index()
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

    public function getName($url)
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
        $url = '/eShop/kitchen/';
        $filename = $this->getName($url);

        $dom = new Dom();
        if ($this->mainUrl == $url) {
            $dom->loadFromUrl($this->mainUrl);
        } else {
            $dom->loadFromUrl($this->mainUrl . $url);
        }

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

        $links = $dom->find('a');
        if (isset($links)) {
            foreach ($links as $link) {
                if (!$link->getTag()->hasAttribute('href')) {
                    continue;
                }
                $tag = $link->getTag();
                $href = $tag->getAttribute('href')->getValue();

                if (substr($href, 0, 2) == '//' || substr($href, 0, 1) != '/') {
                    continue;
                }

                if (!in_array($href, $this->urls)) {
                    $this->urls[] = $href;
                    $this->getByPage($href);
                }
            }
        }
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
