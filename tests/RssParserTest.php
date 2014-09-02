<?php

require dirname(__FILE__) . '/../vendor/autoload.php';

use Tomaj\FeedDownloader\FeedItem;
use Tomaj\FeedDownloader\Processor;
use Tomaj\FeedDownloader\Parser\RssParser;

class RssParserTest extends PHPUnit_Framework_TestCase
{
    public function testProcessTwoItems()
    {
        $content = '<?xml version="1.0" encoding="utf-8"?>
<rss version="2.0">
    <channel>
        <title>ETREND PIANO RSS</title>
        <description></description>
        <link></link>
        <lastBuildDate>Sat, 30 Aug 2014 12:40:46 GMT</lastBuildDate>
        <generator>FeedCreator 1.7.2</generator>
        <item>
            <title>Koňak ako zberateľský artikel</title>
            <link>http://restauracie.etrend.sk/restauracie-vino/konak-ako-zberatelsky-artikel.html</link>
            <description>Koňak, rovnako ako akýkoľvek iný akostný alkoholický nápoj, je primárne určený na vychutnávanie a na príjemné trávenie času. No rovnako ako prvotriedne vína, aj on je vďačným objektom zberateľov.</description>
            <pubDate>Sat, 30 Aug 2014 07:36:00 GMT</pubDate>
            <guid>http://restauracie.etrend.sk/restauracie-vino/konak-ako-zberatelsky-artikel.html</guid>
        </item>
        <item>
            <title>Ekvádor chystá prvú digitálnu menu sveta s podporou centrálnej banky</title>
            <link>http://ekonomika.etrend.sk/svet/ekvador-chysta-prvu-digitalnu-menu-sveta-s-podporou-centralnej-banky.html</link>
            <description>Ekvádor plánuje vytvoriť vlastnú digitálnu menu, ktorá by mala byť prvou digitálnou menou na svete vydávanou centrálnou bankou. Podľa niektorých analytikov oslovených agentúrou AP je to prvý krok k opusteniu súčasnej oficiálnej meny v krajine, ktorou je americký dolár. Vláda to zatiaľ popiera.</description>
            <pubDate>Sat, 30 Aug 2014 07:20:42 GMT</pubDate>
            <guid>http://ekonomika.etrend.sk/svet/ekvador-chysta-prvu-digitalnu-menu-sveta-s-podporou-centralnej-banky.html</guid>
        </item>
    </channel>
</rss>';

        $parser = new RssParser();

        $counter = 0;
        $self = $this;

        $parser->parseContent($content, function(FeedItem $item) use (&$counter, $self) {
            $counter++;
            if ($counter == 1) {
                $self->assertEquals('Koňak ako zberateľský artikel', $item->getTitle());
                $self->assertEquals('http://restauracie.etrend.sk/restauracie-vino/konak-ako-zberatelsky-artikel.html', $item->getLink());
                $self->assertEquals('Koňak, rovnako ako akýkoľvek iný akostný alkoholický nápoj, je primárne určený na vychutnávanie a na príjemné trávenie času. No rovnako ako prvotriedne vína, aj on je vďačným objektom zberateľov.', $item->getDescription());
                $self->assertEquals('http://restauracie.etrend.sk/restauracie-vino/konak-ako-zberatelsky-artikel.html', $item->getGuid());
                $self->assertEquals('Sat, 30 Aug 2014 07:36:00 GMT', $item->getPubDate());
            }
            elseif ($counter == 2) {
                $self->assertEquals('Ekvádor chystá prvú digitálnu menu sveta s podporou centrálnej banky', $item->getTitle());
                $self->assertEquals('http://ekonomika.etrend.sk/svet/ekvador-chysta-prvu-digitalnu-menu-sveta-s-podporou-centralnej-banky.html', $item->getLink());
                $self->assertEquals('Ekvádor plánuje vytvoriť vlastnú digitálnu menu, ktorá by mala byť prvou digitálnou menou na svete vydávanou centrálnou bankou. Podľa niektorých analytikov oslovených agentúrou AP je to prvý krok k opusteniu súčasnej oficiálnej meny v krajine, ktorou je americký dolár. Vláda to zatiaľ popiera.', $item->getDescription());
                $self->assertEquals('http://ekonomika.etrend.sk/svet/ekvador-chysta-prvu-digitalnu-menu-sveta-s-podporou-centralnej-banky.html', $item->getGuid());
                $self->assertEquals('Sat, 30 Aug 2014 07:20:42 GMT', $item->getPubDate());
            }
        });

        $this->assertEquals(2, $counter);
    }

    public function testWrongXml()
    {
        $content = '<?xml version="1.0" encoding="utf-8"?>
<rss version="2.0" >
    <channel>
        <title>ETREND PIANO RSS</title>
        <description></description>
        <link></link>
        <lastBuildDate>Sat, 30 Aug 2014 12:40:46 GMT</lastBuildDate>
        <generator>FeedCreator 1.7.2</generator>
        <item>
            <title>Koňak ako zberateľský artikel</title>
            <link>http';
        $parser = new RssParser();
        $result = $parser->parseContent($content, function(FeedItem $item) {});
        $this->assertEquals(Processor::PARSE_ERROR, $result);
    }


	public function testOtherXmlFormat()
	{
		$content = '<?xml version="1.0" encoding="utf-8"?>
<items>
<item>
    <category><![CDATA[MyCategory]]></category>
    <url>http://urlka</url>
    <title><![CDATA[Item title]]></title>
    <leadin><![CDATA[Item description]]></leadin>
    <image>http://imageurl</image>
</item>
</items>';

        $rssParser = new RssParser();
        $counter = 0;
        
        $self = $this;
        $result = $rssParser->parseContent($content, function(FeedItem $item) use (&$counter, $self) {
            $counter++;

            $self->assertEquals('MyCategory', $item->getCategory());
            $self->assertEquals('http://urlka', $item->getUrl());
            $self->assertEquals('Item title', $item->getTitle());
            $self->assertEquals('Item description', $item->getDescription());
            $self->assertEquals('http://imageurl', $item->getImage());
        });

        $this->assertEquals(1, $counter);
        $this->assertEquals(Processor::PROCESS_OK, $result);
	}

}
