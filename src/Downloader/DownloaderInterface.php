<?php

namespace Tomaj\RssDownloader\Downloader;

interface DownloaderInterface
{
    public function fetch($url);
}
