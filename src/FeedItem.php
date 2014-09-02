<?php

namespace Tomaj\FeedDownloader;

class FeedItem
{
    private $title;

    private $link;

    private $description;

    private $guid;

    private $pubDate;

    private $url;

    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function setLink($link)
    {
        $this->link = $link;
        return $this;
    }

    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public function setGuid($guid)
    {
        $this->guid = $guid;
        return $this;
    }

    public function setPubDate($pubDate)
    {
        $this->pubDate = $pubDate;
        return $this;
    }

    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getLink()
    {
        return $this->link;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getGuid()
    {
        return $this->guid;
    }

    public function getPubDate()
    {
        return $this->pubDate;
    }

    public function getUrl()
    {
        return $this->url;
    }
}
