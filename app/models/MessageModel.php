<?php

class Message
{
    public static function sendFromTo($from, $to, $content)
    {
        if(file_exists('app/cache/message-' . $from . '-' . $to))
        {
            $fn = 'app/cache/message-' . $from . '-' . $to;
            $xml = simplexml_load_file($fn);
        }
        else if(file_exists('app/cache/message-' . $to . '-' . $from))
        {
            $fn = 'app/cache/message-' . $to . '-' . $from;
            $xml = simplexml_load_file($fn);
        }
        else
        {
            $fn = 'app/cache/message-' . $from . '-' . $to;
            $xml = new SimpleXMLElement('<xml/>');
            $xml->addChild('from', $from);
            $xml->addChild('to', $to);
        }

        $message = $xml->addChild('message');
        $message->addAttribute('time', time());
        $message->addAttribute('read', 0);
        $message->addChild('from', $from);
        $message->addChild('to', $from);
        $message->addChild('content', $content);
        $xml->asXML($fn);
    }

    public static function getLastOfAll($user)
    {
        $convs = glob("app/cache/message-*$user*");

        //        print_r($convs);
        //die;
        $lastMessages = array();
        foreach($convs as $fn)
        {
            $xml = simplexml_load_file($fn);
            $data = array();
            $data['user'] = $xml->from == $user ? $xml->to : $xml->from;
            $data['lastsend'] = $xml->from;
            $last = $xml->xpath("/xml/message[last()]")[0];
            $data['lasttime'] = $last['time'];
            $data['content'] = $last->content;
            $lastMessages[] = $data;
        }
        return $lastMessages;
    }

    public static function getAllOf($from, $to)
    {
        if(file_exists('app/cache/message-' . $from . '-' . $to))
        {
            $fn = 'app/cache/message-' . $from . '-' . $to;
            $xml = simplexml_load_file($fn);
        }
        else if(file_exists('app/cache/message-' . $to . '-' . $from))
        {
            $fn = 'app/cache/message-' . $to . '-' . $from;
            $xml = simplexml_load_file($fn);
        }
        else
            return array();
        $data = array();

        foreach($xml->message as $mess)
        {
            $data[] = array(
                'from'    => $mess->from,
                'to'      => $mess->to,
                'content' => $mess->content,
                'time'    => $mess['time'],
            );
        }

        return $data;
    }
}
