<?php

namespace Tomaj\RssDownloader;

interface ProcessorInterface
{
    public function processFeed($feedUrl, $callback);
}
