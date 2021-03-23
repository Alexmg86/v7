<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use PHPHtmlParser\Dom;

class ParseController extends Controller
{
    protected $inner = [];

    public function index()
    {
        $urls = ['https://www.bork.ru/'];

        foreach ($urls as $url) {
            $this->getByPage($url);
        }

        dd(count($this->inner));
    }

    public function getByPage($url)
    {
        $dom = new Dom();
        $dom->loadFromUrl($url);

        $headers = [
            'title' => $dom->find('title')[0]->innerHtml
        ];

        $headItems = $dom->find('head')[0];

        $needHeaders = ['description', 'h1', 'keywords'];
        foreach ($headItems as $headItem) {
            if (!$headItem->getTag()->hasAttribute('name')) {
                continue;
            }
            $tag = $headItem->getTag();
            $name = $tag->getAttribute('name')->getValue();
            if (in_array($name, $needHeaders)) {
                $headers[$name ] = $tag->getAttribute('content')->getValue();
            }
        }

        $body = [];
        $bodyItems = $dom->find('body')[0];

        $this->getText($bodyItems);
    }

    public function getText($bodyItems)
    {
        foreach ($bodyItems as $bodyItem) {
            if ($bodyItem instanceof \PHPHtmlParser\Dom\Node\HtmlNode && $bodyItem->hasChildren()) {
                $this->getText($bodyItem->getChildren());
            } else {
                if (!empty(trim($bodyItem->text()))) {
                    $this->inner[] = trim($bodyItem->text());
                }
            }
        }
    }
}
