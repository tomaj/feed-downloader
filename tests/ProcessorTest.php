<?php

require dirname(__FILE__) . '/../vendor/autoload.php';
require dirname(__FILE__) . '/FakeDownloader.php';

use Tomaj\FeedDownloader\Processor;
use Tomaj\FeedDownloader\Parser\RssParser;
use \Tomaj\FeedDownloader\FeedItem;

define('OK_URL', 'afoihjdsgoidhsg');
define('WRONG_FORMAT', 'asdasfsdaf');
define('CANNOT_DOWNLOAD', 'uyfuyfufuf');
define('OTHER_XML_FORMAT', 'e45yhsdgeryreh');

class ProcessorTest extends PHPUnit_Framework_TestCase
{
    public function testProcessTwoItems()
    {
        $downloader = new FakeDownloader();
        $processor = new Processor($downloader);

        $counter = 0;
        $self = $this;
        $processor->processFeed(OK_URL, new RssParser(), function(FeedItem $item) use (&$counter, $self) {
            $counter++;
        });

        $this->assertEquals(2, $counter);
    }

    public function testWrongXml()
    {
        $downloader = new FakeDownloader();
        $processor = new Processor($downloader);
        $result = $processor->processFeed(WRONG_FORMAT, new RssParser(), function(FeedItem $item) {});
        $this->assertEquals(Processor::PARSE_ERROR, $result);
    }

    public function testCannotDownload()
    {
        $downloader = new FakeDownloader();
        $processor = new Processor($downloader);
        $result = $processor->processFeed(CANNOT_DOWNLOAD, new RssParser(), function(FeedItem $item) {});
        $this->assertEquals(Processor::DOWNLOAD_ERROR, $result);
    }
}
