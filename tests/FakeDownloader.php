<?php

class FakeDownloader implements \Tomaj\RssDownloader\Downloader\DownloaderInterface
{
    public function fetch($url)
    {
        if ($url == OK_URL)
        {
            return '<?xml version="1.0" encoding="utf-8"?>
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

        }
        elseif ($url == WRONG_FORMAT)
        {
            return '<?xml version="1.0" encoding="utf-8"?>
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
        }
        elseif ($url == CANNOT_DOWNLOAD)
        {
            return false;
        }
    }
}
