<?php

class Group
{
	public static function showDesc ($IDGROUP)
	{
		
		$request = Database::$pdo->prepare('SELECT DESC FROM GROUP WHERE IDGROUP = ?');
		$result = $request->execute($IDGROUP);
		$rows = $request->fetchAll();
		return $rows[0]["DESC"];

	}
	public static function admin ($IDADMIN)
	{
		$request = Database::$pdo->prepare('SELECT DESC FROM GROUP WHERE IDADMIN = ?');
		$result = $request->execute($IDADMIN);
		$rows = $request->fetchAll();
		return $rows[0]["IDADMIN"];
	}
	public static function add($IDADMIN,$DESC,$NAME)
	{
		$request = Database::$pdo->prepare('INSERT INTO GROUP (IDADMIN,DESC) VALUES (?,?)');
		$result = $request->execute($IDADMIN,$DESC,$NAME);
		return $result;
	}
	public static function remove ($IDGROUP)
	{
		$request = Database::$pdo->prepare ('DELETE * FROM GROUP WHERE IDGROUP = ?');
		$result = $request->execute($IDGROUP);
		$request = Database::$pdo->prepare('DELETE * FROM INSCRITGROUPE WHERE IDGROUP = ? ');
		$result = $request->execute($IDGROUP);
		return $result;
	}
	public static function addMessage ($IDGROUP,$MESSAGE)
	{
		$hash = hash($MESSAGE);
		$fic = fopen($hash . '.txt', 'w');
		fwrite($fic,$MESSAGE);
		$request = Database::$pdo->prepare('INSERT INTO MESSAGEGROUPE (IDGROUP,IDMESSAGE,IDGROUP) VALUES (?,?,?)';
		$result = $request->execute($IDGROUP,$hash,time());
		return $result;
	}
	public static function removeMessage ($IDGROUP,$MESSAGE)
	{
	 	unlink($MESSAGE . ".txt");
	 	$request = Database::$pdo->prepate('DELETE * FROM MESSAGEGROUPE WHERE IDGROUP = ?');
	 	$result = ;
	}
	public static readMessage()
}
?>