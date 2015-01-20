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
        return $query->columnCount() === 1;
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
        $xmlStr = new SimpleXMLElement('<xml/>');
        $xmlStr->addChild('desc', $desc);
        $query = self::getQueryAttribute($id, 'PSEUDO');
        $query->execute([$id]);
        if($query->columnCount() !== 1)
            die('Couldn\'t find description in database');
        $username = $query->fetch()['PSEUDO'];

        $fn = 'app/cache/user-' .  md5($username) . '.xml';
        $xmlStr ->asXML($fn);
    }

}
