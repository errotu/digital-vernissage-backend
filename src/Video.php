<?php
/**
 * Created by PhpStorm.
 * User: soenke
 * Date: 23.05.17
 * Time: 18:10
 */

namespace DigitalVernisage;


class Video
{
    private $videos = [];

    function __construct($json)
    {
        foreach ($json as $item) {
            $this->videos[] = ["source" => $item->source,
                "type" => $item->type];
        }
    }

    function serialize() {
        return $this->videos;
    }
}