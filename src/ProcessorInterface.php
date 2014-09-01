<?php

namespace Tomaj\RssDownloader;

use Tomaj\RssDownloader\Parser\ParserInterface;

interface ProcessorInterface
{
    public function processFeed($feedUrl, ParserInterface $parser, $callback);
}
