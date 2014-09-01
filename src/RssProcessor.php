<?php

namespace Tomaj\RssDownloader;

class RssProcessor implements ProcessorInterface
{
    private $downloader;

    private $xpathItems = '//channel/item';

    const PARSE_ERROR    = 10;
    const DOWNLOAD_ERROR = 20;
    const PROCESS_OK     = true;

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
            $xml = new \SimpleXMLElement($content);
        } catch (\Exception $e) {
            return self::PARSE_ERROR;
        }

        $result = $xml->xpath($this->xpathItems);

        foreach ($result as $item) {
            $feedItem = new \Tomaj\RssDownloader\FeedItem();

            $feedItem->setTitle((string)$item->title);
            $feedItem->setLink((string)$item->link);
            $feedItem->setDescription((string)$item->description);
            $feedItem->setGuid((string)$item->guid);
            $feedItem->setPubDate((string)$item->pubDate);
        
            $callback($feedItem);
        }

        return self::PROCESS_OK;
    }
}
