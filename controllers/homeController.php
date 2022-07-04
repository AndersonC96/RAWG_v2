<?php
    function path(){
        $url = explode('/', $_SERVER['REQUEST_URI']);
        $path = in_array('pages', $url);
        return !$path ? '.' : '../../';
    }
    $url = path();
    include_once($url.'/services/api.php');
    $page = $_GET['page'] ?? 1;
    $response = api("games");
    $data = $response->results;
    $sorty = json_decode(array_rand($data, 1));
    $next = $response->next ? explode('=', $response->next) : null;
    $previous = $response->previous ? explode('=', $response->previous) : null;