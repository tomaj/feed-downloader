<?php

namespace Tomaj\RssDownloader;

use Tomaj\RssDownloader\Parser\ParserInterface;
use Tomaj\RssDownloader\Downloader\DownloaderInterface;

class RssProcessor implements ProcessorInterface
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
