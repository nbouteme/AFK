<?php

class Event
{
	public static function create($prop)
	{
		$query = Database::$PDO->prepare('INSERT INTO EVENT (ORGANISATEUR)
										  VALUES(?)');
        $id = Users::idOf($prop);
		$query->execute([$id]);
        return Database::$PDO->lastInsertId();
	}

	public static function subscribe($user, $id)
	{
        if(self::hasSubscribedFor($user, $id)) return;

        $query = Database::$PDO->prepare('INSERT INTO PARTICIPEVENT (IDUSER, IDEVENT) VALUES(?, ?)');
        $idu = Users::idOf($user);
		$query->execute([$idu, $id]);
        
	}

	public static function unsubscribe($user, $id)
	{
        if(!self::hasSubscribedFor($user, $id)) return;

		$query = Database::$PDO->prepare('DELETE * FROM PARTICIPEEVENT WHERE IDUSER = ? AND IDEVENT = ?');
        $idu = Users::idOf($user);
		$query->execute([$idu, $id]);
	}

    public static function getProp($id)
    {
		$query = Database::$PDO->prepare('SELECT * FROM EVENT WHERE IDEVENT = ?');
		$query->execute([$id]);
        $ido = $query->fetch()['ORGANISATEUR'];
        return Users::getUserName($ido);
    }

	public static function exists($id)
	{
		$query = Database::$PDO->prepare('SELECT * FROM EVENT WHERE IDEVENT = ?');
		$query->execute([$id]);
        return $query->columnCount() === 1;
	}

    public static function getData($id)
    {
        $data = array();

        $fn = 'app/cache/event-' .  $id . '.xml';
        $fd = fopen($fn, 'r');
        $xmlStr = fread($fd, filesize($fn));
        fclose($fd);
        $xml = new SimpleXMLElement($xmlStr);
        return array(
            'id' => (string)$id,
            'desc' => (string)$xml->desc,
            'type' => (string)$xml['type'],
            'nom'  => (string)$xml['name'],
            'lieu' => (string)$xml['lieu'],
            'date' => (string)$xml->date);
    }

    public static function saveData($id, $data)
    {
        extract($data);

        $fn = 'app/cache/event-' .  $id . '.xml';
        if(file_exists($fn))
        {
            $xmlStr = simplexml_load_file($fn);
            $xmlStr->desc = $desc;
            $xmlStr->date = $date;
            $xmlStr['lieu'] = $place;
            $xmlStr['type'] = $type;
            $xmlStr['name'] = $name;
        }
        else
        {
            $xmlStr = new SimpleXMLElement('<xml/>');
            $xmlStr->addChild('desc', $desc);
            $xmlStr->addChild('date', $date);
            $xmlStr->addAttribute('lieu', $place);
            $xmlStr->addAttribute('type', $type);
            $xmlStr->addAttribute('name', $name);
        }
        
        $xmlStr->asXML($fn);
    }

    public static function hasSubscribedFor($user, $eventId)
    {
		$query = Database::$PDO->prepare('SELECT * FROM PARTICIPEVENT WHERE IDEVENT = ? AND IDUSER = ?');
        $query->execute([$eventId, Users::idOf($user)]);
        return $query->columnCount() == 1;
    }

    public static function usersParticipatingTo($eventId)
    {
		$query = Database::$PDO->prepare('SELECT IDUSER FROM PARTICIPEVENT WHERE IDEVENT = ?');
        $query->execute([$eventId]);
        $res = $query->fetchAll();
        $data = array();
        foreach($res as $row)
            $data[] = Users::getUserName($row['IDUSER']);
        return $data;
    }

    public static function eventParticipating($user)
    {
		$query = Database::$PDO->prepare('SELECT IDEVENT FROM PARTICIPEVENT WHERE IDUSER = ?');
        $query->execute([Users::idOf($user)]);
        $res = $query->fetchAll();
        $data = array();
        foreach($res as $row)
            $data[] = self::getData($row['IDEVENT']);
        return $data;
    }

    public static function eventOrganizing($user)
    {
		$query = Database::$PDO->prepare('SELECT IDEVENT FROM EVENT WHERE ORGANISATEUR = ?');
        $query->execute([Users::idOf($user)]);
        $res = $query->fetchAll();
        $data = array();
        foreach($res as $row)
            $data[] = self::getData($row['IDEVENT']);
        return $data;
    }

    public static function allStartingWith($prefix)
    {
        $data = array();
        $query =  Database::$PDO->prepare("SELECT IDEVENT FROM EVENT");
        $query->execute();
        foreach($query->fetchAll() as $row)
        {
            $name = self::getData($row['IDEVENT'])['nom'];
            if(substr($name, 0, strlen($prefix)) == $prefix)
                $data[$name] = $row['IDEVENT'];
        }
        asort($data);
        return $data;
    }
}
