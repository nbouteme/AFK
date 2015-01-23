<?php

class Interest
{
    public static function create($data)
    {
        extract($data);
        $query = Database::$PDO->prepare('INSERT INTO INTEREST(INTERESTNAME) VALUES(?)');
        $query->execute([$data]);
    }
    
    public static function startingWith($term)
    {
        $query = Database::$PDO->prepare('SELECT * FROM INTEREST WHERE INTERESTNAME LIKE ?');
        $query->execute([$term . '%']);
        return $query->fetchAll();
    }

    public static function ofUser($user)
    {
        $query = Database::$PDO->prepare('SELECT ID FROM USERS WHERE PSEUDO = ?');
        $query->execute([$user]);
        $userId = $query->fetch()['ID'];
        $query = Database::$PDO->prepare('SELECT * FROM INTEREST JOIN USERSINTEREST  ON ID = ?');
        $query->execute([$userId]);
        return $query->fetchAll();
    }
    
    public static function getDescription($name)
    {
        $data = array();

        if(is_int($name))
            $query = Database::$PDO->prepare('SELECT * FROM INTEREST WHERE IDINTEREST = ?');
        else
            $query = Database::$PDO->prepare('SELECT * FROM INTEREST WHERE INTERESTNAME = ?');

        $query->execute([$name]);
        if($query->columnCount() !== 1)
            die('Couldn\'t find description in database');
        $iname = $query->fetch()['INTERESTNAME'];

        $fn = 'app/cache/interest-' .  md5($iname) . '.xml';
        $fd = fopen($fn, 'r');
        $xmlStr = fread($fd, filesize($fn));
        fclose($fd);
        $xml = new SimpleXMLElement($xmlStr);
        return (string)$xml->desc;
    }

    public static function saveDesc($name, $data)
    {
        extract($data);
        $xmlStr = new SimpleXMLElement('<xml/>');
        $xmlStr->addChild('desc', $desc);

        $fn = 'app/cache/interest-' .  md5($name) . '.xml';
        $xmlStr ->asXML($fn);
    }

}
