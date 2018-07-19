<?php
namespace App\Entity;

/**
 * Description of Calendar
 *
 * @author bepetitcollot
 */
class Event
{
    private $id;
    private $title;
    private $content;
    private $datetime;
    private $createdAt;
    private $updatedAt;
    private $calendar;

    public function __construct()
    {
        $this->datetime = new \DateTime();
        $this->createdAt = new \DateTime();
    }
    
    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getDatetime()
    {
        return $this->datetime;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function getCalendar()
    {
        return $this->calendar;
    }

    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    public function setDatetime($datetime)
    {
        $this->datetime = $datetime;
        return $this;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function setCalendar($calendar)
    {
        $this->calendar = $calendar;
        return $this;
    }

    public function getDate()
    {
        return $this->datetime->format('d/m/Y');
    }
    
    public function setDate($date)
    {
        list($day, $month, $year) = explode('/', $date);
        $this->datetime->setDate($year, $month, $day);
    }
}
