<?php

namespace App\Controller;

use App\Entity\Calendar;
use App\Form\CalendarType;
use App\Serializer\JsonApiAdapter;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of CalendarController
 *
 * @author bepetitcollot
 */
class CalendarController extends FOSRestController
{

    private $adapter;
    
    public function __construct(JsonApiAdapter $adapter)
    {
        $this->adapter = $adapter;
    }
    
    public function getCalendarsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $calendarRep = $em->getRepository('App\Entity\Calendar');
        $calendars = $calendarRep->findAll();
        $data = $this->adapter->render($calendars, 1);

        $view = $this->view($data, 200)->setFormat('json');
        return $this->handleView($view);
    }

    public function postCalendarsAction(Request $request)
    {
        $calendar = new Calendar();
        $form = $this->createForm(CalendarType::class, $calendar);
        $form->submit(json_decode($request->getContent(), true)['data']['attributes']);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($calendar);
            $em->flush();
            $data = $this->adapter->render($calendar);
            
            $view = $this->view($data, 200)->setFormat('json');
            return $this->handleView($view);
        }

        $view = $this->view($form, 200)->setFormat('json');
        return $this->handleView($view);
    }

    public function patchCalendarsAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $calendarRep = $em->getRepository('App\Entity\Calendar');
        $calendar = $calendarRep->find($id);
        $form = $this->createForm(CalendarType::class, $calendar);
        $form->submit(json_decode($request->getContent(), true)['data']['attributes']);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $data = $this->adapter->render($calendar);

            $view = $this->view($data, 200)->setFormat('json');
            return $this->handleView($view);
        }

        $view = $this->view($form, 200)->setFormat('json');
        return $this->handleView($view);
    }

    public function deleteCalendarsAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $calendarRep = $em->getRepository('App\Entity\Calendar');
        $calendar = $calendarRep->find($id);
        $em->remove($calendar);
        $em->flush();

        return $this->handleView($this->view(null, 204)->setFormat('json'));
    }

    public function optionsCalendars()
    {
        $view = $this->view(array('data' => array('GET', 'POST')), 200)->setFormat('json');
        return $this->handleView($view);
    }

    public function optionsCalendarsAction($id = null)
    {
        $view = $this->view(array('data' => array('GET', 'PATCH', 'DELETE')), 200)->setFormat('json');
        return $this->handleView($view);
    }

    public function getCalendarAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $calendarRep = $em->getRepository('App\Entity\Calendar');
        $calendar = $calendarRep->find($id);
        $data = $this->adapter->render($calendar, 1);

        $view = $this->view($data, 200)->setFormat('json');
        return $this->handleView($view);
    }

}
