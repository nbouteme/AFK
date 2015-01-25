<?php

class FriendController
{
    public function addFriend($name)
    {
        if(!isset($_SESSION['user']))
            Url::redirectTo('/profile/' . $name);
        Database::connect();

        if(!Friend::isFriendOf($_SESSION['user'], $name))
            Friend::makeFriend($_SESSION['user'], $name);
        
        Users::addActivity(10, $_SESSION['user'], $name);
        Url::redirectTo('/profile/' . $name);
    }

    public function removeFriend($name)
    {
        if(!isset($_SESSION['user']))
            Url::redirectTo('/profile/' . $name);
        Database::connect();

        if(Friend::isFriendOf($_SESSION['user'], $name))
            Friend::stopFriend($_SESSION['user'], $name);
        Url::redirectTo('/profile/' . $_SESSION['user']);
    }
}
