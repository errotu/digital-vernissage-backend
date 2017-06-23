<?php
/**
 * Created by PhpStorm.
 * User: soenke
 * Date: 19.05.17
 * Time: 11:24
 */

namespace DigitalVernissage;


class Entry
{
    private $id = 0;
    private $type = "img";
    /** @var  TranslatedString $title */
    private $title;
    /** @var  TranslatedString $text */

    private $text;
    private $thumb;
    private $source;
    private $url;
    /** @var  Video $video */
    private $video;

    /**
     * Entry constructor.
     * @param $val
     */
    public function __construct($json = null)
    {
        if($json !== null) {
            $this->fromJson($json);
        } else {
            $this->title = new TranslatedString();
            $this->text = new TranslatedString();
        }
    }



    private function fromJson($json)
    {
        $this->id = $json->id;
        $this->type = $json->type;
        $this->title = new TranslatedString($json->title);
        $this->text = new TranslatedString($json->text);
        $this->thumb = $json->thumb;
        $this->source = $json->source;
        $this->url = $json->url;
        if($json->video) {
            $this->video = new Video($json->video);
        }
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @return mixed
     */
    public function getThumb()
    {
        return $this->thumb;
    }

    /**
     * @param mixed $thumb
     */
    public function setThumb($thumb)
    {
        $this->thumb = $thumb;
    }

    /**
     * @return mixed
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @param mixed $source
     */
    public function setSource($source)
    {
        $this->source = $source;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function serialize()
    {
        return ["id" => $this->id,
            "type" => $this->type,
            "title" => $this->title->serialize(),
            "text" => $this->text->serialize(),
            "thumb" => $this->thumb,
            "source" => $this->source,
            "url" => $this->url,
            "video" => $this->video == null ? null : $this->video->serialize()];
    }


}