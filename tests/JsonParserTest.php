<?php

require dirname(__FILE__) . '/../vendor/autoload.php';

use Tomaj\FeedDownloader\FeedItem;
use Tomaj\FeedDownloader\Processor;
use Tomaj\FeedDownloader\Parser\JsonParser;

class JsonParserTest extends PHPUnit_Framework_TestCase
{
    public function testProcessTwoItems()
    {
        $parser = new JsonParser();
        $content = '
{
    "indexElements": [
        {
            "title":"59,4 m kw., dla 4 osób: o jeden pokój za mało",
            "lead":"W naszym nowym mieszkaniu są trzy pokoje, tymczasem nam są potrzebne cztery: dzienny i trzy sypialnie (dla nas oraz dla dwóch córek: piętnasto- i siedmioletniej). Może wydzielić dodatkowe pomieszczenie w pokoju dziennym, a ten - dla powiększenia przestrzeni - otworzyć na przedpokój? A może salon powinien też pełnić funkcję naszej sypialni? W tym drugim przypadku wolelibyśmy zamknąć kuchnię. Ewa z mężem",
            "xx":16252853,
            "url":"http://czterykaty.pl/czterykaty/1,57590,16252853,59_4_m_kw___dla_4_osob__o_jeden_pokoj_za_malo.html",
            "commentsCount":null,
            "author":"Red.",
            "related":null,
            "dateFrom":"12-08-2014 07:20",
            "dateFromTs":1407820800000,
            "sectionId":57590,
            "baseDivisionXx":57590,
            "urlType":1,
            "urlXx":16252853,
            "urlSectionXx":57590,
            "type":910
        },
        {
            "title":"52,2 m kw., dla 3 osób: gdzie ustawić stół i sofę",
            "lead":"Prosimy o pomoc w zaaranżowaniu naszego pierwszego, wymarzonego mieszkania. W części dziennej oprócz kuchni jest nam potrzebny kąt wypoczynkowy z wygodną kanapą oraz stół dla trzyosobowej rodziny. Zastanawiamy się, gdzie ustawić niezbędne meble, musimy też znaleźć miejsce na szafy (im więcej ich będzie, tym lepiej). Problemem jest nieustawny przedpokój w kształcie litery U. Małgorzata i Sebastian",
            "xx":16050066,
            "url":"http://czterykaty.pl/czterykaty/1,57590,16050066,52_2_m_kw___dla_3_osob__gdzie_ustawic_stol_i_sofe.html",
            "commentsCount":null,
            "author":"Red.",
            "related":null,
            "dateFrom":"02-07-2014 07:10",
            "dateFromTs":1404277800000,
            "sectionId":57590,
            "baseDivisionXx":57590,
            "urlType":1,
            "urlXx":16050066,
            "urlSectionXx":57590,
            "type":910
        }
    ]
}';

		$self = $this;
		$counter = 0;

        $parser->parseContent($content, function(FeedItem $item) use ($self, &$counter) {
        	$counter++;
        	if ($counter == 1) {
                $self->assertEquals('59,4 m kw., dla 4 osób: o jeden pokój za mało', $item->getTitle());
                $self->assertEquals('http://czterykaty.pl/czterykaty/1,57590,16252853,59_4_m_kw___dla_4_osob__o_jeden_pokoj_za_malo.html', $item->getUrl());
                $self->assertEquals('W naszym nowym mieszkaniu są trzy pokoje, tymczasem nam są potrzebne cztery: dzienny i trzy sypialnie (dla nas oraz dla dwóch córek: piętnasto- i siedmioletniej). Może wydzielić dodatkowe pomieszczenie w pokoju dziennym, a ten - dla powiększenia przestrzeni - otworzyć na przedpokój? A może salon powinien też pełnić funkcję naszej sypialni? W tym drugim przypadku wolelibyśmy zamknąć kuchnię. Ewa z mężem', $item->getDescription());
                $self->assertEquals('12-08-2014 07:20', $item->getPubDate());
            }
            elseif ($counter == 2) {
                $self->assertEquals('52,2 m kw., dla 3 osób: gdzie ustawić stół i sofę', $item->getTitle());
                $self->assertEquals('http://czterykaty.pl/czterykaty/1,57590,16050066,52_2_m_kw___dla_3_osob__gdzie_ustawic_stol_i_sofe.html', $item->getUrl());
                $self->assertEquals('Prosimy o pomoc w zaaranżowaniu naszego pierwszego, wymarzonego mieszkania. W części dziennej oprócz kuchni jest nam potrzebny kąt wypoczynkowy z wygodną kanapą oraz stół dla trzyosobowej rodziny. Zastanawiamy się, gdzie ustawić niezbędne meble, musimy też znaleźć miejsce na szafy (im więcej ich będzie, tym lepiej). Problemem jest nieustawny przedpokój w kształcie litery U. Małgorzata i Sebastian', $item->getDescription());
                $self->assertEquals('02-07-2014 07:10', $item->getPubDate());
            }
        });

		$this->assertEquals(2, $counter);
    }

    public function testWrongJson()
    {
    	$parser = new JsonParser();
        $content = '{
		    "indexElements": [
		        {
		            "title":"59,4 m kw., dla 4 osób: o jeden pokój za mało",
		            "lead":"W naszym nowym mieszkaniu są trzy pokoje, tymczasem nam są potrzebne cztery: dzienny i trzy sypialnie (dla nas oraz dla dwóch córek: piętnasto- i siedmioletniej). Może wydzielić dodatkowe pomieszczenie w pokoju dziennym, a ten - dla powiększenia przestrzeni - otworzyć na przedpokój? A może salon powinien też pełnić funkcję naszej sypialni? W tym drugim przypadku wolelibyśmy zamknąć kuchnię. Ewa z mężem",
		            "xx":162528';

		$counter = 0;
        $result = $parser->parseContent($content, function(FeedItem $item) use (&$counter) {
        	$counter++;
        });
        $this->assertEquals(Processor::PARSE_ERROR, $result);
        $this->assertEquals(0, $counter);
    }
}
