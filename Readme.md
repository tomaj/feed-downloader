Rss downloader
==============

Simple library for downloading rss.

Requirements
------------

rss downloader requires PHP 5.3.0 or higher.

Instalation
-----------

The best way to install nette-rte-processor is using [Composer](http://getcomposer.org/):

```sh
$ composer require tomaj/nette-rte-processor
```

Usage
-----

You can use rss-downloader to download rss and process data with your function

```php
$downloader = \Tomaj\RssDownloader\CurlDownloader();
$processor = new \Tomaj\RssDownloader\RssProcessor($downloader);
$result = $processor->processFeed($url, function(\Tomaj\RssDownloader\FeedItem $item)) {
	// custom handling $item
	echo $item->title . "\n";
	echo $item->description . "\n";
	echo $item->guid . "\n";
});
if ($result == \Tomaj\RssDownloader\RssProcessor::PARSE_ERROR) {
	// error in xml
} elseif ($result == \Tomaj\RssDownloader\RssProcessor::DOWNLOAD_ERROR) {
	// error with downloading
}

```

-----

Repository [http://github.com/tomaj/rss-downloader](http://github.com/tomaj/rss-downloader).