<?php

class Users
{
	public static function create($data)
	{
		extract($data);
		$query = Database::$PDO->prepare('INSERT INTO USERS (CIVILITE, EMAIL, NOM, PRENOM, PASSWORD, PSEUDO)
										  VALUES(?, ?, ?, ?, ?, ?)');
		$query->execute([
			$civilite,
			$email,
			$nom,
			$prenom,
			$password,
			$pseudo,]);

        self::saveDesc($pseudo, '');
	}

    private static function getQueryAttribute($id, $attribute)
    {
        if(filter_var($id, FILTER_VALIDATE_EMAIL))
            return Database::$PDO->prepare("SELECT $attribute FROM USERS WHERE EMAIL = ?");
        else if(filter_var($id, FILTER_VALIDATE_INT))
            return Database::$PDO->prepare("SELECT $attribute FROM USERS WHERE ID = ?");            
        else
            return Database::$PDO->prepare("SELECT $attribute FROM USERS WHERE PSEUDO = ?");
    }

    public static function getPassword($id)
    {
        $query = self::getQueryAttribute($id, 'PASSWORD');
		$query->execute([$id]);
        return $query->fetch()['PASSWORD'];
    }

    public static function getUserName($id)
    {
        $query = self::getQueryAttribute($id, 'PSEUDO');
		$query->execute([$id]);
        return $query->fetch()['PSEUDO'];
    }

	public static function exists($id)
	{
        $query = self::getQueryAttribute($id, 'COUNT(*)');
		$query->execute([$id]);
        return $query->fetch(PDO::FETCH_NUM)[0] != 0;
	}

    public static function getDescription($id)
    {
        $data = array();
        $query = self::getQueryAttribute($id, 'PSEUDO');
        $query->execute([$id]);
        if($query->columnCount() !== 1)
            die('Couldn\'t find description in database');
        $username = $query->fetch()['PSEUDO'];

        $fn = 'app/cache/user-' .  md5($username) . '.xml';
        $fd = fopen($fn, 'r');
        $xmlStr = fread($fd, filesize($fn));
        fclose($fd);
        $xml = new SimpleXMLElement($xmlStr);
        return (string)$xml->desc;
    }

    public static function saveDesc($id, $data)
    {
        extract($data);

        $query = self::getQueryAttribute($id, 'PSEUDO');
        $query->execute([$id]);
        if($query->columnCount() !== 1)
            die('Couldn\'t find description in database');
        $username = $query->fetch()['PSEUDO'];

        if(file_exists('app/cache/user-' .  md5($username) . '.xml'))
        {
            $xmlStr = simplexml_load_file('app/cache/user-' .  md5($username) . '.xml');
            $xmlStr->desc = $desc;
        }
        else
        {
            $xmlStr = new SimpleXMLElement('<xml/>');
            $xmlStr->addChild('desc', $desc);
        }
        
        $fn = 'app/cache/user-' .  md5($username) . '.xml';
        $xml->asXML($fn);
    }

    public static function idOf($id)
    {
        $query = self::getQueryAttribute($id, 'ID');
        $query->execute([$id]);
        return $query->fetch()['ID'];
    }
    
    public static function isFriendOf($a, $b)
    {
        $query =  Database::$PDO->prepare("SELECT * FROM LISTAMIS WHERE IDA = ? AND IDB = ?");
        $query->execute([self::idOf($a), self::idOf($b)]);
        return $query->columnCount() === 1;        
    }

    public static function allStartingWith($prefix)
    {
        $data = array();
        $query =  Database::$PDO->prepare("SELECT * FROM USERS WHERE PSEUDO LIKE ? ORDER BY PSEUDO");
        $query->execute([$prefix . '%']);
        foreach($query->fetchAll() as $row)
            $data[] = array('id' => $row['ID'], 'name' => $row['PSEUDO']);
        return $data;
    }

    // 0-9 pour evenement, 10-19 pour amis
    public static function addActivity($code, $id, $param)
    {
        $query = self::getQueryAttribute($id, 'PSEUDO');
        $query->execute([$id]);
        if($query->columnCount() !== 1)
            die('Couldn\'t find description in database');
        $username = $query->fetch()['PSEUDO'];

        $fn = 'app/cache/user-' .  md5($username) . '.xml';
        $fd = fopen($fn, 'r');
        $xmlStr = fread($fd, filesize($fn));
        fclose($fd);
        $xml = new SimpleXMLElement($xmlStr);

        $exists = false;
        foreach ($xml->children() as $ch)
            if($ch->getName() == 'activities')
                $exists = true;

        if(!$exists)
            $activities = $xml->addChild('activities');
        else
            $activities = $xml->activities;

        $a = $xml->activities->addChild('activity');
        $a->addAttribute('type', $code);
        $a->addAttribute('from', $id);
        $a->addAttribute('time', time());
        $a->addAttribute('action', $param);
        $xml->asXML($fn);
    }

    public static function getActivities($id)
    {
        $query = self::getQueryAttribute($id, 'PSEUDO');
        $query->execute([$id]);
        if($query->columnCount() !== 1)
            die('Couldn\'t find description in database');
        $username = $query->fetch()['PSEUDO'];

        $fn = 'app/cache/user-' .  md5($username) . '.xml';
        $fd = fopen($fn, 'r');
        $xmlStr = fread($fd, filesize($fn));
        fclose($fd);
        $xml = new SimpleXMLElement($xmlStr);

        $data = array();
        $exists = false;
        foreach ($xml->children() as $ch)
            if($ch->getName() == 'activities')
                $exists = true;

        if(!$exists) return array();

        $data[] = array();
        foreach($xml->activities->activity as $act)
            $data[] = array('type'   => (string)$act['type'],
                            'from'   => (string)$act['from'],
                            'time'   => (string)$act['time'],
                            'action' => (string)$act['action']);
        return $data;
    }

    public static function addPublication($id, $content)
    {
        $query = self::getQueryAttribute($id, 'PSEUDO');
        $query->execute([$id]);
        if($query->columnCount() !== 1)
            die('Couldn\'t find description in database');
        $username = $query->fetch()['PSEUDO'];

        $fn = 'app/cache/user-' .  md5($username) . '.xml';
        $fd = fopen($fn, 'r');
        $xmlStr = fread($fd, filesize($fn));
        fclose($fd);
        $xml = new SimpleXMLElement($xmlStr);

        $exists = false;
        foreach ($xml->children() as $ch)
            if($ch->getName() == 'publications')
                $exists = true;

        if(!$exists)
            $publis = $xml->addChild('publications');
        else
            $publis = $xml->publications;


        $p = $publis->addChild('publication');
        $p->addAttribute('from', $id);
        $p->addAttribute('time', time());
        $p->addChild('content', $content);
        $xml->asXML($fn);
    }

    public static function getPublications($id)
    {
        $query = self::getQueryAttribute($id, 'PSEUDO');
        $query->execute([$id]);
        if($query->columnCount() !== 1)
            die('Couldn\'t find description in database');
        $username = $query->fetch()['PSEUDO'];

        $fn = 'app/cache/user-' .  md5($username) . '.xml';
        $fd = fopen($fn, 'r');
        $xmlStr = fread($fd, filesize($fn));
        fclose($fd);
        $xml = new SimpleXMLElement($xmlStr);

        $data = array();
        $exists = false;
        foreach ($xml->children() as $ch)
            if($ch->getName() == 'publications')
                $exists = true;

        if(!$exists) return array();
        foreach($xml->publications->publication as $act)
            $data[] = array('content' => (string)$act->content,
                            'from' => (string)$act['from'],
                            'time' => (string)$act['time']);
        return $data;
    }

}
