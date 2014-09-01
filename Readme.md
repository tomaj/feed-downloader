Rss downloader
==============

[![Build Status](https://secure.travis-ci.org/tomaj/rss-downloader.png)](http://travis-ci.org/tomaj/rss-downloader)

[![Latest Stable Version](https://poser.pugx.org/tomaj/rss-downloader/v/stable.svg)](https://packagist.org/packages/tomaj/rss-downloader)
[![Latest Unstable Version](https://poser.pugx.org/tomaj/rss-downloader/v/unstable.svg)](https://packagist.org/packages/tomaj/rss-downloader)
[![License](https://poser.pugx.org/tomaj/rss-downloader/license.svg)](https://packagist.org/packages/tomaj/rss-downloader)

Simple library for downloading rss.

Requirements
------------

rss downloader requires PHP 5.3.0 or higher.

Instalation
-----------

The best way to install *rss-downloader* is using [Composer](http://getcomposer.org/):

```sh
$ composer require tomaj/rss-downloader
```

Usage
-----

You can use rss-downloader to download rss and process data with your function

```php
$downloader = new \Tomaj\RssDownloader\Downloader\CurlDownloader();
$processor = new \Tomaj\RssDownloader\RssProcessor($downloader);
$result = $processor->processFeed($url, new \Tomaj\RssDownloader\Parser\RssParser(), function(\Tomaj\RssDownloader\FeedItem $item) {
	// custom handling $item
	echo $item->getTitle() . "\n";
	echo $item->getLink() . "\n";
	echo $item->getDescription() . "\n";
	echo $item->getGuid() . "\n";
	echo $item->getPubDate() . "\n";
});
if ($result === \Tomaj\RssDownloader\RssProcessor::PARSE_ERROR) {
	// error in xml
} elseif ($result === \Tomaj\RssDownloader\RssProcessor::DOWNLOAD_ERROR) {
	// error with downloading
}

```

-----

Repository [http://github.com/tomaj/rss-downloader](http://github.com/tomaj/rss-downloader).