<?php

class ProfileController
{
    public function profile($user)
    {
        Database::connect();
        $data = array();
        $data['name'] = $user;
        $data['userdesc'] = Users::getDescription($user);
        // A completer
        View::render('profile/user', $data);
    }
    
    public function showEdit($user)
    {
        if($user != $_SESSION['user'])
            Url::redirectTo('/profile/' . $_SESSION['user']);
        Database::connect();

        $data = array();
        $data['name'] = $user;
        $data['userData'] = Users::getDescription($user);
        //        $data['tastes'] = Users::getInterests($user);

        View::render('profile/edit', $data);        
    }

    public function saveEdit($user)
    {
        if($user != $_SESSION['user'])
            Url::redirectTo('/profile/' . $_SESSION['user']);
        Database::connect();

        $data = array();
        $data['up_error'] = 0;
        $data['desc'] = $_POST['desc'];
        if(file_exists($_FILES['ppic']['tmp_name']))
        {
            $info = pathinfo($_FILES['ppic']['name']);
            if($info['extension'] == 'png' || $info['extension'] == 'jpg')
                move_uploaded_file( $_FILES['ppic']['tmp_name'], 'app/cache/user-ppic-' . md5($user));
        }

        if(file_exists($_FILES['bpic']['tmp_name']))
        {
            $info = pathinfo($_FILES['bpic']['name']);
            if($info['extension'] == 'png' || $info['extension'] == 'jpg')
                move_uploaded_file( $_FILES['bpic']['tmp_name'], 'app/cache/user-bpic-' . md5($user));
        }

        Users::saveDesc($user, $data);
        Url::redirectTo('/profile/' . $_SESSION['user']);
    }

    private function getpicture($user, $type)
    {
        $fn = 'app/cache/user-' . $type . 'pic-' . md5($user);
        $finfo = finfo_open(FILEINFO_MIME_TYPE);

        if(!file_exists($fn))
            $fn = 'assets/img/' . $type . '-default';

        $fd = fopen($fn, 'rb');
        $ct = finfo_file($finfo, $fn);
        header("Content-Type: " . $ct);
        header("Content-Length: " . filesize($fn));
        fpassthru($fd);
    }

    public function getBpicture($user)
    {
        $this->getpicture($user, 'b');
    }

    public function getPpicture($user)
    {
        $this->getpicture($user, 'p');
    }

    public function getSelfPpicture()
    {
        $this->getpicture($_SESSION['user'], 'p');
    }

    public function generateStyle($user)
    {
        header('Content-Type: text/css');
        echo
".user-image
{
	background-image: url('/profile/$user/ppic');
}

.nav-user-image
{
	background-image: url('/profile/" . $_SESSION['user'] . "/ppic');
}

.user-cover
{
	background-image: url('/profile/$user/bpic');
}
";
    }
}