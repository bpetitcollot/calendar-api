<?php
namespace App\Repository;

use Doctrine\ORM\EntityRepository;
/**
 * Description of CalendarRepository
 *
 * @author bepetitcollot
 */
class EventRepository extends EntityRepository
{
    public function findByCalendarIds($calendarIds)
    {
        return $this->createQueryBuilder('e')
            ->innerJoin('e.calendar', 'c')
            ->where('c.id IN (:calendarIds)')
            ->setParameter('calendarIds', $calendarIds)
            ->getQuery()->getResult();
    }
}
