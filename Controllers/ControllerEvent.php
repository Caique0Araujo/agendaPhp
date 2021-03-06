<?php

namespace Agenda\Controllers;

use Agenda\Dao\DaoContact;
use Agenda\Dao\DaoEvent;
use Agenda\Models\Event;
use Agenda\Views\Events\EventView;

class ControllerEvent
{
    public function __construct()
    {
    }

    public function indexAll()
    {
        $events = array();


        $daoEvent = new DaoEvent();
        $daoContact = new DaoContact();

        $events = $daoEvent->getAll($_SESSION['id']);

        for($i = 0; $i < sizeof($events); $i++){
            $contacts = $daoContact->getByEvent($events[$i]['id']);
            $events[$i]['contacts'] = $contacts;
        }

        $view = new EventView();
        $view->dataContainer($events);
    }

    public function indexOne()
    {
    }

    public function store()
    {
        $view = new EventView();
        $view->addForm();
    }

    public function storeSave($name, $description, $date){
        $event = new Event();

        $event->setName($name);
        $event->setDescription($description);
        $event->setDate($date);
        $event->setUser_id($_SESSION['id']);

        $dao = new DaoEvent();
        $dao->create($event);
    }

    public function update($id)
    {   
        $dao = new DaoEvent();
        $event = $dao->getById($id);
        $view = new EventView();
        $view->editForm($event);
    }

    public function updateSave($id, $name, $description, $date){
        $event = new Event();

        $event->setId($id);
        $event->setName($name);
        $event->setDescription($description);
        $event->setDate($date);
        $event->setUser_id($_SESSION['id']);

        $dao = new DaoEvent();
        $dao->update($event);
    }
    public function delete($id)
    {
        $dao = new DaoEvent();
        $dao->delete($id, $_SESSION['id']);
    }
}
