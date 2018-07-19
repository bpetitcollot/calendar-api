<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Description of Calendar
 *
 * @author bepetitcollot
 */
class Calendar
{
    private $id;
    private $name;
    private $events;
    
    public function __construct()
    {
        $this->events = new ArrayCollection();
    }
    
    public function getId()
    {
        return $this->id;
    }

        public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getEvents()
    {
        return $this->events;
    }

    public function addEvent($event)
    {
        if (!$this->events->contains($event)) {
            $this->events->add($event);
            $event->setCalendar($this);
        }
        return $this;
    }
    
    public function removeEvent($event)
    {
        if ($this->events->contains($event)) {
            $this->events->removeElement($event);
            $event->setCalendar(null);
        }
        return $this;
    }
}
