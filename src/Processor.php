<?php

namespace Tomaj\FeedDownloader;

use Tomaj\FeedDownloader\Parser\ParserInterface;
use Tomaj\FeedDownloader\Downloader\DownloaderInterface;

class Processor implements ProcessorInterface
{
    private $downloader;

    const PARSE_ERROR    = 10;
    const DOWNLOAD_ERROR = 20;
    const PROCESS_OK     = true;

    public function __construct(DownloaderInterface $downloader)
    {
        $this->downloader = $downloader;
    }

    public function processFeed($feedUrl, ParserInterface $parser, $callback)
    {
        $content = $this->downloader->fetch($feedUrl);
        if (!$content) {
            return self::DOWNLOAD_ERROR;
        }
        return $parser->parseContent($content, $callback);
    }
}
