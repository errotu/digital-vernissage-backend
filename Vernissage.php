<?php
/**
 * Created by PhpStorm.
 * User: soenke
 * Date: 19.05.17
 * Time: 11:07
 */

namespace DigitalVernissage;

require_once 'TranslatedString.php';
require_once 'Entry.php';
require_once 'Video.php';

class Vernissage
{

    private $baseUrl;
    private $languages;
    private $fallbackLanguage;
    /** @var \DigitalVernissage\TranslatedString $title */
    private $title;
    /** @var \DigitalVernissage\TranslatedString $intro */
    private $intro;
    /** @var \DigitalVernissage\Entry[] $entries */
    private $entries = [];
    private $templates;
    private $version;
    private $availableImages;


    function __construct(string $path)
    {
        $this->templates = new \League\Plates\Engine(__DIR__ . '/templates');
        if (file_exists($path . '/blog.json')) {
            $this->json = $path . '/blog.json';
            $this->basepath = $path;
            $this->initialize();
        } else {
            throw new \InvalidArgumentException("Could not find JSON-File in '" . $path);
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

        // Get available images
        $availableImg = [];
        foreach (scandir($this->basepath . '/img') as $img) {
            if((strpos(strtolower($img), "png") !== false || strpos(strtolower($img), "jpg") !== false) && (strpos(strtolower($img), "_thumb") === false)) {
                $tempImg = explode(".", $img);
                $thumb = $tempImg[0] . '_thumb.' . $tempImg[1];
                $availableImg[] = ['webPath' => $this->baseUrl . 'img/' . $img, 'name' => $img, 'thumb' => file_exists($this->basepath . '/img/' . $thumb) ? 'img/' . $thumb : null];
            }
        }
        $this->availableImages = $availableImg;
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
        if($page == "entry" && $this->renderEntry($_GET['id'])) {
        } else if ($page == "new" && $this->renderNew()) {
        } else {
            echo $this->templates->render("overview", ["app" => $this, "back" => false]);
        }
    }

    private function renderEntry($id) {
        $entry = $this->findEntryById($id);
        if($entry == null) {
            return false;
        }
        echo $this->templates->render("entry", ["entry" => $this->findEntryById($id), "id" => $id, "back" => true]);

        return true;
    }

    private function renderNew()
    {
        if ($_GET['step'] == 1) {
            echo $this->templates->render("new_step1", ["images" => $this->availableImages, "back" => true]);
            return true;
        } else {
            $newId = 1;
            foreach ($this->getEntries() as $entry) {
                if($entry->getId() >= $newId) {
                    $newId = $entry->getId() + 1;
                }
            }

            foreach ($this->availableImages as $img) {
                if($img['name'] == $_GET['newImage']) {
                    $newEntry = new Entry();
                    $newEntry->setSource($img['name']);
                    $newEntry->setThumb($img['thumb']);
                    $newEntry->setId($newId);
                    $newEntry->setType("img");

                    $this->entries[] = $newEntry;
                    $this->writeJson();
                    header("Location: " . explode('?', $_SERVER['REQUEST_URI'], 2)[0] . "?page=entry&id=" . $newId);
                    return true;
                }
            }
        }

        return false;
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

        if(key_exists("entry_delete", $_POST)) {
            $entry = $this->findEntryById($_GET['id']);
            if(($key = array_search($entry, $this->entries)) !== FALSE) {
                unset($this->entries[$key]);

                $this->writeJson();
            }
        }
    }



}