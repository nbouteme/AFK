<?php

class NewsController
{
    public function publish()
    {
        if(!isset($_SESSION['user']))
            Url::redirectTo('/');

        Database::connect();
        Users::addPublication($_SESSION['user'], $_POST['post']);

        Url::redirectTo('/home');
    }
    
    public function show()
    {
        if(!isset($_SESSION['user']))
            Url::redirectTo('/');

        $data = array();
        Database::connect();
        $data['pubs'] = Users::getPublications($_SESSION['user']);

        $acts = Users::getActivities($_SESSION['user']);
        
        foreach(Friend::getFriendsOf($_SESSION['user'])['followed'] as $f)
        {
            foreach(Users::getActivities(Users::getUserName($f)) as $act)
                $acts[] = $act;
            foreach(Users::getPublications(Users::getUserName($f)) as $act)
                $data['pubs'][] = $act;
        }
        $data['acts'] = array();
        foreach($acts as $act)
        {
            if(!isset($act['type'])) continue;
            switch($act['type'])
            {
            case 0:
                $text = 'participe à l\'évenement ' . Event::getData($act['action'])['nom'];
                $link = '/event/' . $act['action'];
                break;
            case 1:
                $text = 'organise l\'évenement ' . Event::getData($act['action'])['nom'];
                $link = '/event/' . $act['action'];
                break;
            case 10:
                $text = 'est devenu ami avec '  . $act['action'];
                $link = '/profile/' . $act['action'];
                break;
            }

            $data['acts'][] = array('content' => $text,
                                    'from'    => $act['from'],
                                    'time'    => $act['time'],
                                    'link'    => $link,
                                    'action'  => $act['action']);
        }

        
        $tmp = array();
        foreach($data['acts'] as $row)
            $tmp[] = $row['time'];

        array_multisort($tmp, $data['acts']);
        $data['acts'] = array_reverse($data['acts']);

        $tmp = array();
        foreach($data['pubs'] as $row)
            $tmp[] = $row['time'];


        array_multisort($tmp, $data['pubs']);
        $data['pubs'] = array_reverse($data['pubs']);
        
        View::render('news', $data);
    }
}
