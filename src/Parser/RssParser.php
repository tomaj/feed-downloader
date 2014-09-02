<?php

namespace Tomaj\FeedDownloader\Parser;

use \Tomaj\FeedDownloader\Processor;
use \Tomaj\FeedDownloader\FeedItem;

class RssParser implements ParserInterface
{
    private $xpathItems = '//channel/item';

    public function parseContent($content, $callback)
    {
        try {
            $xml = new \SimpleXMLElement($content);
        } catch (\Exception $e) {
            return Processor::PARSE_ERROR;
        }

        $result = $xml->xpath($this->xpathItems);

        foreach ($result as $item) {
            $feedItem = new FeedItem();

            $feedItem->setTitle((string)$item->title);
            $feedItem->setLink((string)$item->link);
            $feedItem->setDescription((string)$item->description);
            $feedItem->setGuid((string)$item->guid);
            $feedItem->setPubDate((string)$item->pubDate);
        
            $callback($feedItem);
        }

        return Processor::PROCESS_OK;
    }
}
