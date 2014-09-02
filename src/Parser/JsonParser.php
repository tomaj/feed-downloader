<?php

namespace Tomaj\FeedDownloader\Parser;

use \Tomaj\FeedDownloader\Processor;
use \Tomaj\FeedDownloader\FeedItem;

class JsonParser implements ParserInterface
{
    public function parseContent($content, $callback)
    {
        $data = json_decode($content);

        if (!$data) {
            return Processor::PARSE_ERROR;
        }
        
        foreach ($data->indexElements as $key => $item) {
            $feedItem = new FeedItem();

            if (isset($item->title)) {
                $feedItem->setTitle($item->title);
            }
            if (isset($item->link)) {
                $feedItem->setLink($item->link);
            }
            if (isset($item->lead)) {
                $feedItem->setDescription($item->lead);
            }
            if (isset($item->guid)) {
                $feedItem->setGuid($item->guid);
            }
            if (isset($item->dateFrom)) {
                $feedItem->setPubDate($item->dateFrom);
            }
            if (isset($item->category)) {
                $feedItem->setCategory($item->category);
            }
            if (isset($item->image)) {
                $feedItem->setImage($item->image);
            }
            if (isset($item->url)) {
                $feedItem->setUrl($item->url);
            }

            $callback($feedItem);
        }

        return Processor::PROCESS_OK;
    }
}
