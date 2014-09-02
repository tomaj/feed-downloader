<?php

namespace Tomaj\FeedDownloader\Parser;

use \Tomaj\FeedDownloader\Processor;
use \Tomaj\FeedDownloader\FeedItem;

class RssParser implements ParserInterface
{
    private $xpathItems = '//item';

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

            if (isset($item->title)) {
                $feedItem->setTitle((string)$item->title);
            }
            if (isset($item->link)) {
                $feedItem->setLink((string)$item->link);
            }
            if (isset($item->leadin)) {
                $feedItem->setDescription((string)$item->leadin);
            }
            if (isset($item->description)) {
                $feedItem->setDescription((string)$item->description);
            }
            if (isset($item->guid)) {
                $feedItem->setGuid((string)$item->guid);
            }
            if (isset($item->pubDate)) {
                $feedItem->setPubDate((string)$item->pubDate);
            }
            if ($item->category) {
                $feedItem->setCategory((string)$item->category);
            }
            if ($item->image) {
                $feedItem->setImage((string)$item->image);
            }
            if ($item->url) {
                $feedItem->setUrl((string)$item->url);
            }
        
            $callback($feedItem);
        }

        return Processor::PROCESS_OK;
    }
}
