<?php

namespace Tomaj\FeedDownloader\Parser;

interface ParserInterface
{
    public function parseContent($content, $callback);
}
