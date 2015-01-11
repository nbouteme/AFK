<?php
class Database
{
    public static $pdo = null;
   
    public static function connect()
    {
        $ADRESS   = Config::get("Database.Host");
        $DATABASE = Config::get("Database.Database");
        $LOGIN    = Config::get("Database.User");
        $PASSWORD = Config::get("Database.Pass");
       
        if ($pdo != null) {
            try {
                $db = new PDO("mysql:host=$ADRESS;dbname=$DATABASE", $LOGIN, $PASSWORD);
                $db->exec("SET CHARACTER SET utf8");
            }
            catch (PDOException $e) {
                die($e->getMessage());
            }
        }
        return $pdo;
    }
   
    public static function disconnect()
    {
        $pdo = null;
    }
}
?>