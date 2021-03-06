<?php

namespace Agenda\Dao;

use PDO;
use Agenda\Dao\Connection;
use Agenda\Models\Event;
use PDOException;


class DaoEvent
{

    public function getAll($User_id)
    {

        try {
            $sql =
                'SELECT events.id, events.name, events.description, events.date, events.active, events.Users_id
        FROM events
        WHERE Users_id = ?
        AND active = 1';

            $pst = Connection::getPreparedStatement($sql);
            $pst->bindValue(1, $User_id);
            $pst->execute();
            $lista = [];
            $lista = $pst->fetchAll(PDO::FETCH_ASSOC);
            return $lista;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


    public function getById($id)
    {

        try {
            $sql =
            'SELECT events.id, events.name, events.date, events.description, events.active, events.Users_id
            FROM events 
            WHERE id = ?
            AND active = 1';
            $pst = Connection::getPreparedStatement($sql);

            $pst->bindValue(1, $id);
            $pst->execute();

            $pst->setFetchMode(PDO::FETCH_CLASS, 'Agenda\Models\Event');
            $evento = new Event();
            $evento = $pst->fetch();
            return $evento;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function create(Event $event)
    {

        try {
            $sql =
            'INSERT 
            INTO events (name, date, description, Users_id) 
            VALUES (?, ?, ?, ?)';

            $description = null;
            if ($event->getDescription() != null) {
                $description = $event->getDescription();
            }

            $date = null;
            if ($event->getDate() != null) {
                $date = $event->getDate();
            }

            $pst = Connection::getPreparedStatement($sql);

            $pst->bindValue(1, $event->getName());
            $pst->bindValue(2, $date);
            $pst->bindValue(3, $description);
            $pst->bindValue(4, $event->getUser_id());

            if ($pst->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function delete($id, $User_id)
    {

        try {
            $sql =
            'UPDATE events 
            SET active = 0
            WHERE id = ?
            AND Users_id = ?';
            $pst = Connection::getPreparedStatement($sql);

            $pst->bindValue(1, $id);
            $pst->bindValue(2, $User_id);

            if ($pst->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function update(Event $event)
    {

        try {
            $sql =
            'UPDATE events 
            SET events.name = ?, events.date = ?, events.description = ? 
            WHERE events.id = ?
            AND events.Users_id = ?';

            $pst = Connection::getPreparedStatement($sql);

            $pst->bindValue(1, $event->getName());
            $pst->bindValue(2, $event->getDate());
            $pst->bindValue(3, $event->getDescription());
            $pst->bindValue(4, $event->getId());
            $pst->bindValue(5, $event->getUser_id());


            if ($pst->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function isEmpty()
    {

        try {
            $sql =
            'SELECT * 
        FROM events
        WHERE Users_id = ?
        AND active = 1';

        $pst = Connection::getPreparedStatement($sql);
        $pst->execute();

        if ($pst->rowCount() < 1) {
            return true;
        } else {
            return false;
        }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    
    }

    public function isActive($id){
        try {

            $sql = 
            'SELECT events.active
            FROM events
            WHERE id = ?';

            $pst = Connection::getPreparedStatement($sql);
            $pst->bindValue(1, $id);
            $pst->execute();
            
            if ($pst->rowCount() < 1)
                return false;
            else
                return true;

            
            
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function active($id, $User_id){
        try {
            $sql =
                'UPDATE events 
        SET active = 1
        WHERE id = ?
        AND Users_id = ?';
            $pst = Connection::getPreparedStatement($sql);

            $pst->bindValue(1, $id);
            $pst->bindValue(2, $User_id);

            if ($pst->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
