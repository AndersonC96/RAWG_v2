<?php
    $baseURL = "https://api.rawg.io/api/";//url base da api
    $apiKey = "b6341c222fbd4b2182fc441c2be19751";//chave da api
    function api(String $route = 'games'): object{//função para pegar o json da api
        global $baseURL;//pega a url base da api
        global $apiKey;//pega a chave da api
        global $url;//pega o caminho da url
        /*echo "{$baseURL}{$route}?key={$apiKey}";//mostra o json da api
        exit();*/
        $response = @file_get_contents("{$baseURL}{$route}?key={$apiKey}");//pega o json da api
        //var_dump($response);//mostra o json da api
        if(empty($response)){//se não houver resposta
            header("Location: {$url}/pages/errors/404");//redireciona para a página de erro 404
        }
        return json_decode($response);//retorna o json da api
    };
    function apiSearch(String $route = 'games?key=b6341c222fbd4b2182fc441c2be19751'): object{//função para pegar o json da api
        global $baseURL;//pega a url base da api
        global $apiKey;//pega a chave da api
        global $url;//pega o caminho da url
        /*echo "{$baseURL}{$route}?key={$apiKey}";//mostra o json da api
        exit();*/
        $response = @file_get_contents("{$baseURL}{$route}");//pega o json da api
        //var_dump($response);//mostra o json da api
        if(empty($response)){//se não houver resposta
            header("Location: {$url}/pages/errors/404");//redireciona para a página de erro 404
        }
        return json_decode($response);//retorna o json da api
    };
    function apiGenres(String $route = 'genres'): object{//função para pegar o json da api
        global $baseURL;//pega a url base da api
        global $apiKey;//pega a chave da api
        global $url;//pega o caminho da url
        /*echo "{$baseURL}{$route}?key={$apiKey}";//mostra o json da api
        exit();*/
        $response = @file_get_contents("{$baseURL}{$route}?key={$apiKey}");//pega o json da api
        //var_dump($response);//mostra o json da api
        if(empty($response)){//se não houver resposta
            header("Location: {$url}/pages/errors/404");//redireciona para a página de erro 404
        }
        return json_decode($response);//retorna o json da api
    };