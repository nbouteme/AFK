<?php

class InterestController
{
    public function getInterest()
    {
        Database::connect();
        if(!isset($_GET['term'])) die('nop');
        $term = ucwords(strtolower($_GET['term']));
        $data = Interest::startingWith($term);
        $ret = array();
        foreach($data as $interest)
            $ret[] = array($interest[1] => $interest[0]);
        header('Content-Type: application/json');
        echo json_encode($ret);
        die();
    }

    public static function showNew()
    {
        if(!isset($_SESSION['user']))
                        Url::redirectTo('/');
        View::render('interest/new');
    }

    public static function createInterest()
    {
        if(!isset($_SESSION['user']))
                        Url::redirectTo('/');
        $data['name'] = ucwords(strtolower($_POST['name']));
        $data['desc'] = $_POST['desc'];

        Interest::create($data);
        if(is_set($_POST['addMe']))
            Users::addInterest($data);

        if(file_exists($_FILES['ipic']['tmp_name']))
        {
            $info = pathinfo($_FILES['ipic']['name']);
            if($info['extension'] == 'png' || $info['extension'] == 'jpg')
                move_uploaded_file( $_FILES['ppic']['tmp_name'], 'app/cache/interest-ipic-' . md5($data['name']));
        }
    }

    public function getInterestForUser($user)
    {
        if(!isset($_SESSION['user']))
            die;
        if(!Users::isFriendOf($_SESSION['user'], $user))
            die;
        Database::connect();
        $data = Interest::ofUser($_SESSION['user'], $user);
        $ret = array();
        foreach($data as $interest)
            $ret[] = array($interest[1] => $interest[0]);
        header('Content-Type: application/json');
        echo json_encode($ret);
        die();
    }
}
