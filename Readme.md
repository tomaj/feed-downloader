Feed downloader
==============

[![Build Status](https://secure.travis-ci.org/tomaj/feed-downloader.png)](http://travis-ci.org/tomaj/feed-downloader)

[![Latest Stable Version](https://poser.pugx.org/tomaj/feed-downloader/v/stable.svg)](https://packagist.org/packages/tomaj/feed-downloader)
[![Latest Unstable Version](https://poser.pugx.org/tomaj/feed-downloader/v/unstable.svg)](https://packagist.org/packages/tomaj/feed-downloader)
[![License](https://poser.pugx.org/tomaj/feed-downloader/license.svg)](https://packagist.org/packages/tomaj/feed-downloader)

Simple library for downloading various feed.

Requirements
------------

Feed downloader requires PHP 5.3.0 or higher.

Instalation
-----------

The best way to install *feed-downloader* is using [Composer](http://getcomposer.org/):

```sh
$ composer require tomaj/feed-downloader
```

Usage
-----

You can use feed-downloader to download rss and process data with your function

```php
$downloader = new \Tomaj\FeedDownloader\Downloader\CurlDownloader();
$processor = new \Tomaj\FeedDownloader\Processor($downloader);
$result = $processor->processFeed($url, new \Tomaj\FeedDownloader\Parser\RssParser(), function(\Tomaj\FeedDownloader\FeedItem $item) {
	// custom handling $item
	echo $item->getTitle() . "\n";
	echo $item->getLink() . "\n";
	echo $item->getDescription() . "\n";
	echo $item->getGuid() . "\n";
	echo $item->getPubDate() . "\n";
});
if ($result === \Tomaj\FeedDownloader\Processor::PARSE_ERROR) {
	// error in xml
} elseif ($result === \Tomaj\FeedDownloader\Processor::DOWNLOAD_ERROR) {
	// error with downloading
}

```
Todo
----

- Encodings conversions
- DateTime in FeedItem
- Unify url/link with one getter
- Change ungly parser with multiple ifset() methods
- CurlDownloader test

-----

Repository [http://github.com/tomaj/feed-downloader](http://github.com/tomaj/feed-downloader).
