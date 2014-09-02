<?php

namespace Tomaj\FeedDownloader\Downloader;

interface DownloaderInterface
{
    public function fetch($url);
}
