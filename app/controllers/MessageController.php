<?php

class MessageController
{
    public function home()
    {
        if(!isset($_SESSION['user']))
            Url::redirectTo('/');

        $lastMessages = Message::getLastOfAll($_SESSION['user']);
        $data['lasts'] = $lastMessages;
        View::render('message/home', $data);
    }

    public function showMessagesOf($user)
    {
        if(!isset($_SESSION['user']))
            Url::redirectTo('/');
        if($user == $_SESSION['user'])
            Url::redirectTo('/message');
        $messages = Message::getAllof($_SESSION['user'], $user);
        $messages = array_reverse($messages);
        $data['name'] = $user;
        $data['messages'] = $messages;
        View::render('message/user', $data);
    }

    public function sendMessage($user)
    {
        if(!isset($_SESSION['user']))
            Url::redirectTo('/');
        $content = $_POST['content'];

        Message::sendFromTo($_SESSION['user'], $user, $content);
        Url::redirectTo('/message/' . $user);
    }
    
}
