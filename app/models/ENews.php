<?php

/**
 * Class ENews
 *
 * This class represents a news item in the application.
 * It includes properties for id, title, description, date, and email.
 * It also includes methods for getting and setting these properties.
 */
class ENews {

    /**
     * @var int $idNews The ID of the news item.
     */
    private $idNews;

    /**
     * @var string $title The title of the news item.
     */
    private $title;

    /**
     * @var string $description The description of the news item.
     */
    private $description;

    /**
     * @var DateTime $date The date of the news item.
     */
    private DateTime $creation_time;

    private $idUser;

    /**
     * @var string $entity The name of the class. This is set to ENews::class.
     */
    private static $entity = ENews::class;

    /**
     * Constructor for the ENews class.
     *
     * @param string $title The title of the news item.
     * @param string $description The description of the news item.
     */
    public function __construct($idUser, $title, $description)
    {
        $this->idUser = $idUser;
        $this->title = $title;
        $this->description = $description;
        $this->setTime();
    }

    /**
     * Get the name of the class.
     *
     * @return string The name of the class.
     */
    public static function getEntity(): string
    {
        return self::$entity;
    }

    /**
     * Get the title of the news item.
     *
     * @return string The title of the news item.
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the title of the news item.
     *
     * @param string $title The new title of the news item.
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Get the description of the news item.
     *
     * @return string The description of the news item.
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the description of the news item.
     *
     * @param string $description The new description of the news item.
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getTime()
    {
        return $this->creation_time;
    }

    private function setTime()
    {
        $this->creation_time = new DateTime("now");
    }

    public function getTimeStr()
    {
        return $this->creation_time->format('Y-m-d H:i:s');
    }

    public function setCreationTime(DateTime $dateTime){
        $this->creation_time = $dateTime;
    }


    /**
     * Get the ID of the news item.
     *
     * @return int The ID of the news item.
     */
    public function getIdNews()
    {
        return $this->idNews;
    }

    /**
     * Set the ID of the news item.
     *
     * @param int $idNews The new ID of the news item.
     */
    public function setIdNews($idNews)
    {
        $this->idNews = $idNews;
    }

    public function getIdUser()
    {
        return $this->idUser;
    }

}