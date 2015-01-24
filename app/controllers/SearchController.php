<?php

class SearchController
{
    public function showSearch()
    {
        View::render('search');
    }

    private function searchType($type, $term = '')
    {
        $data = array();
        if($type == 1 || $type == 0)
        {
            foreach(Users::allStartingWith($term) as $user)
                $data['users'][] = array(
                    'pic'   => '/profile/' . $user['name'] . '/ppic',
                    'link'  => '/profile/' . $user['name'],
                    'title' => 'Utilisateur: ' . $user['name']
                    );
        }
        if($type == 2 || $type == 0)
        {
            foreach(Event::allStartingWith($term) as $name => $ide)
                $data['events'][] = array(
                    'pic'   => '/event/' . $ide . '/ppic',
                    'link'  => '/event/' . $ide,
                    'title' => 'Évenement: ' . $name
                    );
        }
        return $data;
    }

    public function search()
    {
        if(!isset($_POST['type']) ||
           !isset($_POST['term']))
            Url::redirectTo('/search');

        $data = array();
        Database::connect();
        $i = 0;

        $i +=        $_POST['type']  === 0 ? 0 : 1;
        $i += strlen($_POST['term']) != 0 ? 2 : 0;

        
        switch($i)
        {
        case 1:// tous du type
            $data['results'] = $this->searchType($_POST['type']);
            break;
        case 2:// tous ayant x dans le nom, tout type
            $data['results'] = $this->searchType(0, $_POST['term']);
        case 3:// tous ayant x dans le nom, tout type
            $data['results'] = $this->searchType($_POST['type'], $_POST['term']);
        }
        View::render('search', $data);
    }
}
