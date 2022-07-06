<?php
    function path(){
        $url = explode('/', $_SERVER['REQUEST_URI']);
        $path = in_array('pages', $url);//se as páginas estiverem na url
        return !$path ? '.' : '../../';//se não estiver, retorna para o diretório raiz
    }
    $url = path();//função para pegar o caminho da url
    $id = $_GET['id'] ?? '-';//pega o id da url
    if($id === '-'){//se não tiver id, retorna para a página inicial
        header('Location: '.$url.'pages/index.php');
        //header("Location: {$url}pages/errors/404");
    }
    include_once($url.'/services/api.php');//inclui o arquivo de conexão com a api
    $response = api("games/{$id}");//pega o json da api
    if(empty($response)){//se não tiver resposta, retorna para a página inicial
        header('Location: '.$url.'pages/index.php');
        //header("Location: {$url}pages/errors/404");
    }
    $screenshots = api("games/{$id}/screenshots");
    $additions = api("games/{$id}/additions");
    $gameSeries = api("games/{$id}/game-series");
    $achievements = api("games/{$id}/achievements");
    $data = $response;