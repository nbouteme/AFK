<?php

class Friend
{
    // Etre amis est en fait un relation a sens unique, l'un peut se considerer amis avec un autre alors qu'en realité, il n'en n'est rien
    // C'est en fait une relation follower/followed
	public static function makeFriend($follower, $followed)
	{
		$query = Database::$PDO->prepare('INSERT INTO LISTAMIS (IDA, IDB)
										  VALUES(?, ?)');
		$query->execute([Users::idOf($follower),
                         Users::idOf($followed),]);
	}

    public static function getFriendsOf($user)
    {
        $data = array();

		$query = Database::$PDO->prepare('SELECT * FROM LISTAMIS WHERE IDB = ?');
		$query->execute([Users::idOf($user)]);
        
        foreach($query->fetchAll() as $rows)
            $data['followers'][] = Users::getUserName($rows['IDA']);

        $query = Database::$PDO->prepare('SELECT * FROM LISTAMIS WHERE IDA = ?');
		$query->execute([Users::idOf($user)]);
        
        foreach($query->fetchAll() as $rows)
            $data['followed'][] = Users::getUserName($rows['IDB']);
        return $data;
    }

	public static function isFriendOf($follower, $followed)
	{
		$query = Database::$PDO->prepare('SELECT * FROM LISTAMIS WHERE IDA = ? AND IDB = ?');
		$query->execute([Users::idOf($follower),
                         Users::idOf($followed),]);
        return $query->fetch(PDO::FETCH_NUM)[0] != 0;
	}

}
