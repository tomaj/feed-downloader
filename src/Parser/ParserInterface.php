<?php

namespace Tomaj\RssDownloader\Parser;

interface ParserInterface
{
    public function parseContent($content, $callback);
}
