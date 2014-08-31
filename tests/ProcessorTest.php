<?php

require dirname(__FILE__) . '/../vendor/autoload.php';
require dirname(__FILE__) . '/FakeDownloader.php';

define('OK_URL', 'afoihjdsgoidhsg');
define('WRONG_FORMAT', 'asdasfsdaf');
define('CANNOT_DOWNLOAD', false);

class ProcessorTest extends PHPUnit_Framework_TestCase
{
    public function testProcessThreeItems()
    {
        $downloader = new \Tomaj\RssDownloader\FakeDownloader();
        $processor = new \Tomaj\RssDownloader\RssProcessor($downloader);

        $counter = 0;
        $processor->processFeed(OK_URL, function(FeedItem $item) use (&$counter) {
            $counter++;
            if ($counter == 1) {
                $this->assertEquals('Koňak ako zberateľský artikel', $item->title);
                $this->assertEquals('http://restauracie.etrend.sk/restauracie-vino/konak-ako-zberatelsky-artikel.html', $item->link);
                $this->assertEquals('Koňak, rovnako ako akýkoľvek iný akostný alkoholický nápoj, je primárne určený na vychutnávanie a na príjemné trávenie času. No rovnako ako prvotriedne vína, aj on je vďačným objektom zberateľov.', $item->description);
                $this->assertEquals('http://restauracie.etrend.sk/restauracie-vino/konak-ako-zberatelsky-artikel.html', $item->guid);
                $this->assertEquals('Sat, 30 Aug 2014 07:36:00 GMT', $item->pubDate);
            }
            elseif ($counter == 2) {
                $this->assertEquals('Ekvádor chystá prvú digitálnu menu sveta s podporou centrálnej banky', $item->title);
                $this->assertEquals('http://ekonomika.etrend.sk/svet/ekvador-chysta-prvu-digitalnu-menu-sveta-s-podporou-centralnej-banky.html', $item->link);
                $this->assertEquals('Ekvádor plánuje vytvoriť vlastnú digitálnu menu, ktorá by mala byť prvou digitálnou menou na svete vydávanou centrálnou bankou. Podľa niektorých analytikov oslovených agentúrou AP je to prvý krok k opusteniu súčasnej oficiálnej meny v krajine, ktorou je americký dolár. Vláda to zatiaľ popiera.', $item->description);
                $this->assertEquals('http://ekonomika.etrend.sk/svet/ekvador-chysta-prvu-digitalnu-menu-sveta-s-podporou-centralnej-banky.html', $item->guid);
                $this->assertEquals('Sat, 30 Aug 2014 07:20:42 GMT', $item->pubDate);
            }
        });

        $this->assertEquals(2, $counter);
    }

    public function testWrongXml()
    {
        $downloader = new \Tomaj\RssDownloader\FakeDownloader();
        $processor = new \Tomaj\RssDownloader\RssProcessor($downloader);
        $result = $processor->processFeed(WRONG_FORMAT, function(FeedItem $item) {});
        $this->assertEquals(\Tomaj\RssDownloader\RssProcessor::PARSE_ERROR, $result);
    }

    public function testCannotDownload()
    {
        $downloader = new \Tomaj\RssDownloader\FakeDownloader();
        $processor = new \Tomaj\RssDownloader\RssProcessor($downloader);
        $result = $processor->processFeed(CANNOT_DOWNLOAD, function(FeedItem $item) {});
        $this->assertEquals(\Tomaj\RssDownloader\RssProcessor::DOWNLOAD_ERROR, $result);
    }
}
