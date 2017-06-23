<?php
/**
 * Created by PhpStorm.
 * User: soenke
 * Date: 19.05.17
 * Time: 11:14
 */

namespace DigitalVernissage;


class TranslatedString
{
    private $translations = ["de" => null, "en" => null];

    function __construct($json = null)
    {
        if($json != null) {
            $this->fromJson($json);
        }
    }

    public function read($lang) {
        return $this->translations[$lang];
    }

    public function write($lang, $str) {
        $this->translations[$lang] = $str;
    }

    public function getLanguages() {
        return array_keys($this->translations);
    }

    public function fromJson($json) {
        foreach ($json as $lang => $string) {
            $this->write($lang, $string);
        }
    }

    public function getLanguage($lang) {
        switch ($lang) {
            case "de":
                return "🇩🇪 Deutsch";
            case "en":
                return "🇬🇧 English";
            default:
                return $lang;
        }
    }

    public function serialize()
    {
        return $this->translations;
    }

}