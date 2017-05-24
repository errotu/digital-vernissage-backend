<?php
/**
 * Created by PhpStorm.
 * User: soenke
 * Date: 19.05.17
 * Time: 11:07
 */

namespace DigitalVernisage;

require_once 'TranslatedString.php';
require_once 'Entry.php';
require_once 'Video.php';

class Vernisage
{

    private $baseUrl;
    private $languages;
    private $fallbackLanguage;
    /** @var \DigitalVernisage\TranslatedString $title */
    private $title;
    /** @var \DigitalVernisage\TranslatedString $intro */
    private $intro;
    /** @var \DigitalVernisage\Entry[] $entries */
    private $entries = [];
    private $templates;
    private $version;


    function __construct(string $jsonPath)
    {
        $this->templates = new \League\Plates\Engine(__DIR__ . '/templates');
        if (file_exists($jsonPath)) {
            $this->json = $jsonPath;
            $this->initialize();
        } else {
            throw new \InvalidArgumentException("Could not find JSON-File '" . $jsonPath);
        }
    }

    private function initialize()
    {
        $fd = fopen($this->json, "r");
        $file = json_decode(fread($fd, filesize($this->json)));
        fclose($fd);
        if ($file === null) {
            throw new \ParseError("Could not parse JSON-File");
        }

        $this->version = $file->version;
        $this->baseUrl = $file->baseurl;
        $this->languages = $file->languages;
        $this->fallbackLanguage = $file->fallback_language;
        $this->title = new TranslatedString($file->title);
        $this->intro = new TranslatedString($file->intro);
        $this->parseEntries($file->entries);

        $this->parseForm();
    }

    private function parseEntries($entries)
    {
        foreach ($entries as $val) {
            $this->entries[] = new Entry($val);
        }
    }

    private function findEntryById(int $id) {
        foreach($this->entries as $entry) {
            if($entry->getId() === $id) {
                return $entry;
            }
        }

        return null;
    }

    /**
     * @return Entry[]
     */
    public function getEntries(): array
    {
        return $this->entries;
    }

    public function render() {
        $page = key_exists("page", $_GET) ? $_GET['page'] : null;
        switch ($page) {
            case "entry":
                $this->renderEntry($_GET['id']);
                break;
            default:
                echo $this->templates->render("overview", ["app" => $this]);
        }

    }

    private function renderEntry($id) {
        echo $this->templates->render("entry", ["entry" => $this->findEntryById($id)]);
    }

    private function writeJson() {

        copy($this->json, $this->json . 'v' . $this->version);
        $this->version++;

        $fd = fopen($this->json, "w");

        $serializedEntries = [];
        foreach ($this->entries as $entry) {
            $serializedEntries[] = $entry->serialize();
        }

        $json = json_encode([
            "version" => $this->version,
            "baseurl" => $this->baseUrl,
            "languages" => $this->languages,
            "fallback_language" => $this->fallbackLanguage,
            "title" => $this->title->serialize(),
            "intro" => $this->intro->serialize(),
            "entries" => $serializedEntries
        ]);

        fwrite($fd, $json);
        fclose($fd);
    }

    /**
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * @return array
     */
    public function getLanguages()
    {
        return $this->languages;
    }

    /**
     * @return string
     */
    public function getFallbackLanguage()
    {
        return $this->fallbackLanguage;
    }

    /**
     * @return TranslatedString
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return TranslatedString
     */
    public function getIntro()
    {
        return $this->intro;
    }

    private function parseForm()
    {
        if(key_exists("welcome_submit", $_POST)) {
            foreach ($_POST as $key => $value) {
                if(strpos($key, "-") !== false) {
                    //Format: name-language
                    $str = explode("-", $key);
                    switch ($str[0]) {
                        case "title":
                            $this->title->write($str[1], $value);
                            break;
                        case "intro":
                            $this->intro->write($str[1], $value);
                    }
                }
            }

            $this->writeJson();
        }

        if(key_exists("entry_submit", $_POST)) {
            foreach ($_POST as $key => $value) {
                if(strpos($key, "-") !== false) {
                    //Format: name-language
                    $str = explode("-", $key);

                    $entry = $this->findEntryById($_GET['id']);

                    switch ($str[0]) {
                        case "title":
                            $entry->getTitle()->write($str[1], $value);
                            break;
                        case "text":
                            $entry->getText()->write($str[1], $value);
                    }
                }
            }

            $this->writeJson();
        }
    }


}