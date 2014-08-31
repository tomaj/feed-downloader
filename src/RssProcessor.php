<?php

namespace Tomaj\RssDownloader;

class RssProcessor implements ProcessorInterface
{
    private $downloader;

    private $xpathItems = '//channel/item';

    const PARSE_ERROR = 10;
    const DOWNLOAD_ERROR = 20;

    public function __construct(DownloaderInterface $downloader)
    {
        $this->downloader = $downloader;
    }

    public function processFeed($feedUrl, $callback)
    {
        $content = $this->downloader->fetch($feedUrl);
        if (!$content) {
            return self::DOWNLOAD_ERROR;
        }
        $result = $this->processXml($content, $callback);
        return $result;
    }

    private function processXml($content, $callback)
    {
        try {
            $xml = new SimpleXMLElement($content);
        } catch (Exception $e) {
            return self::PARSE_ERROR;
        }

        $result = $xml->xpath($this->xpathItems);

        foreach ($result as $item) {
            $feedItem = new FeedItem();

            $feedItem->title = (string)$item->title;
            $feedItem->link = (string)$item->link;
            $feedItem->description = (string)$item->description;
            $feedItem->guid = (string)$item->guid;
            $feedItem->pubDate = (string)$item->pubDate;
        
            $callback($feedItem);
        }

        return true;
    }
}
