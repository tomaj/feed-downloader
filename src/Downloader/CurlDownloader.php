<?php

namespace Tomaj\FeedDownloader\Downloader;

class CurlDownloader implements DownloaderInterface
{
    private $timeout;

    public function __construct($timeout = 5)
    {
        if (!extension_loaded('curl')) {
            throw new \Exception("Need extension 'curl' for CurlDownloader");
        }
        $this->timeout = $timeout;
    }

    public function fetch($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout * 1000);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $content = curl_exec($ch);

        if (curl_errno($ch)) {
            return '';
        }

        $headers = curl_getinfo($ch);
        if ($headers['http_code'] != 200) {
            return '';
        }

        curl_close($ch);


        return $content;
    }
}
