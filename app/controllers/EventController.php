<?php

class EventController
{
    public function showCreate()
    {
        if(!isset($_SESSION['user']))
            Url::redirectTo('/');

        $data['title'] = 'Créer';
        View::render('event/create', $data);
    }

    public function showEdit($id)
    {
        Database::connect();
        if(Event::getProp($id) != $_SESSION['user'])
            Url::redirectTo('/event/' . $id);

        $data['title'] = 'Modifier';
        $data['edit'] = true;
        $data['id'] = $id;
        View::render('event/create', $data);
    }

    public function showEvent($id)
    {
        Database::connect();
        $data = Event::getData($id);
        $data['eventId'] = $id;
        $data['participants'] = Event::usersParticipatingTo($id);
        View::render('event/home', $data);
    }

    public function subscribe($id)
    {
        if(!isset($_SESSION['user']))
            Url::redirectTo('/');

        Database::connect();
        Event::subscribe($_SESSION['user'], $id);
        Url::redirectTo('/event/' . $id);
    }

    public function unsubscribe($id)
    {
        if(!isset($_SESSION['user']))
            Url::redirectTo('/');
    }

    private function getpicture($id, $type)
    {
        $fn = 'app/cache/event-' . $type . 'pic-' . md5($id);
        $finfo = finfo_open(FILEINFO_MIME_TYPE);

        if(!file_exists($fn))
            $fn = 'assets/img/' . $type . '-default';

        $fd = fopen($fn, 'rb');
        $ct = finfo_file($finfo, $fn);
        header("Content-Type: " . $ct);
        header("Content-Length: " . filesize($fn));
        fpassthru($fd);
    }

    public function getBpicture($id)
    {
        $this->getpicture($id, 'b');
    }

    public function getPpicture($id)
    {
        $this->getpicture($id, 'p');
    }

    public function generateStyle($user)
    {
        header('Content-Type: text/css');
        echo
".event-image
{
	background-image: url('/event/$user/ppic');
}

.event-cover
{
	background-image: url('/event/$user/bpic');
}
";
    }

    public function createEvent()
    {
        if(!isset($_SESSION['user']))
            Url::redirectTo('/');
        Database::connect();
        $id = Event::create($_SESSION['user']);
        $this->saveEdit($id);
        Url::redirectTo('/event/' . $id);
    }

    public function saveEdit($id)
    {
        Database::connect();
        if(Event::getProp($id) != $_SESSION['user'])
            Url::redirectTo('/event/' . $id);

        $data = array();
        $data['up_error'] = 0;
        $data['name'] = $_POST['name'];
        $data['desc'] = $_POST['desc'];
        $data['place'] = $_POST['place'];
        $data['date'] = $_POST['date'];

        switch($_POST['type'])
        {
        case '1':
            $data['type'] = 'Convention';
        case '2':
            $data['type'] = 'Rencontre';
        case '3':
            $data['type'] = 'LAN Party';
        case '4':
            $data['type'] = 'Fete';
        case '5':
            $data['type'] = 'Autre';
        }
        
        if(file_exists($_FILES['imgform']['tmp_name']))
        {
            $info = pathinfo($_FILES['imgform']['name']);
            if($info['extension'] == 'png' || $info['extension'] == 'jpg')
                move_uploaded_file( $_FILES['imgform']['tmp_name'], 'app/cache/event-ppic-' . $id);
        }

        if(file_exists($_FILES['banform']['tmp_name']))
        {
            $info = pathinfo($_FILES['banform']['name']);
            if($info['extension'] == 'png' || $info['extension'] == 'jpg')
                move_uploaded_file( $_FILES['banform']['tmp_name'], 'app/cache/event-bpic-' . $id);
        }

        Event::saveData($id, $data);
        Url::redirectTo('/event/' . $id);
    }

}
