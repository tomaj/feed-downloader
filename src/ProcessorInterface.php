<?php

namespace Tomaj\FeedDownloader;

use Tomaj\FeedDownloader\Parser\ParserInterface;

interface ProcessorInterface
{
    public function processFeed($feedUrl, ParserInterface $parser, $callback);
}
