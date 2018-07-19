<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use App\Serializer\JsonApiAdapter;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of EventController
 *
 * @author bepetitcollot
 */
class EventController extends FOSRestController
{

    private $requestStack;
    private $adapter;
    
    public function __construct(JsonApiAdapter $adapter, \Symfony\Component\HttpFoundation\RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
        $this->adapter = $adapter;
    }
    
    public function getEventsAction()
    {
        $calendarIds = $this->requestStack->getCurrentRequest()->query->get('filter', array('calendar' => []))['calendar'];
        $em = $this->getDoctrine()->getManager();
        $eventRep = $em->getRepository('App\Entity\Event');
        $events = count($calendarIds) > 0 ? $eventRep->findByCalendarIds($calendarIds) : array();
        $data = $this->adapter->render($events, 1);

        $view = $this->view($data, 200)->setFormat('json');
        return $this->handleView($view);
    }

    public function postEventsAction()
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->submit($this->buildFormData());
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();
            $data = $this->adapter->render($event);
            
            $view = $this->view($data, 200)->setFormat('json');
            return $this->handleView($view);
        }

        $view = $this->view($form, 200)->setFormat('json');
        return $this->handleView($view);
    }

    public function patchEventsAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $eventRep = $em->getRepository('App\Entity\Event');
        $event = $eventRep->find($id);
        $form = $this->createForm(EventType::class, $event);
        $form->submit($this->buildFormData());
        if ($form->isValid()) {
            $event->setUpdatedAt(new \DateTime());
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $data = $this->adapter->render($event);

            $view = $this->view($data, 200)->setFormat('json');
            return $this->handleView($view);
        }

        $view = $this->view($form, 200)->setFormat('json');
        return $this->handleView($view);
    }

    public function deleteEventsAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $eventRep = $em->getRepository('App\Entity\Event');
        $event = $eventRep->find($id);
        $em->remove($event);
        $em->flush();

        return $this->handleView($this->view(null, 204)->setFormat('json'));
    }

    public function optionsEvents()
    {
        $view = $this->view(array('data' => array('GET', 'POST')), 200)->setFormat('json');
        return $this->handleView($view);
    }

    public function optionsEventsAction($id = null)
    {
        $view = $this->view(array('data' => array('GET', 'PATCH', 'DELETE')), 200)->setFormat('json');
        return $this->handleView($view);
    }

//    public function getCalendarAction($id)
//    {
//        $em = $this->getDoctrine()->getManager();
//        $calendarRep = $em->getRepository('App\Entity\Calendar');
//        $calendar = $calendarRep->find($id);
//        $data = $this->adapter->render($calendar);
//
//        $view = $this->view($data, 200)->setFormat('json');
//        return $this->handleView($view);
//    }

    private function buildFormData()
    {
        $requestContent = json_decode($this->requestStack->getCurrentRequest()->getContent(), true);
        $formData = $requestContent['data']['attributes'];
        foreach (array_keys($requestContent['data']['relationships']) as $relationship)
        {
            $formData[$relationship] = $requestContent['data']['relationships'][$relationship]['data']['id'];
        }
        
        return $formData;
    }
}
