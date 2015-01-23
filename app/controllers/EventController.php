<?php

class EventController
{
    public function getInterest()
    {
        Database::connect();
        $term = $_GET['term'];
        $data = Interests::startingWith($term);
        
        header('Content-Type: application/json');
        echo json_encode($cities);
        die();
    }
}
