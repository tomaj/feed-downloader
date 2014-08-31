<?php

namespace Tomaj\RssDownloader;

interface DownloaderInterface
{
    public function fetch($url);
}
