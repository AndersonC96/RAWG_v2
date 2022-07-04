<?php
    function path(){
        $url = explode('/', $_SERVER['REQUEST_URI']);
        $path = in_array('pages', $url);
        return !$path ? '.' : '../../';
    }
    $url = path();
    include_once($url.'/services/api.php');
    $response = api('genres');
    $genres = $response->results;
    $id = $_GET['id'] ?? $genres[0]->id;
    $page = $_GET['page'] ?? 1;
    $response = api("games?genres={$id}");