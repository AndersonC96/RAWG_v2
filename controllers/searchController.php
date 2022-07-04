<?php
    function path(){
        $url = explode('/', $_SERVER['REQUEST_URI']);//separa a url em array
        $path = in_array('pages', $url);//se as páginas estiverem na url
        return !$path ? '.' : '../../';//se não estiver, retorna para o diretório raiz
    }
    $url = path();//função para pegar o caminho da url
    include_once($url.'/services/api.php');//inclui o arquivo de conexão com a api
    if(isset($_POST['search'])){//se o botão de busca for clicado
        $search = str_replace(' ', '%20', $_POST['search']);//substitui os espaços por %20
        $response = api("games?search={$search}");//pega o json da api
        $data = $response->results;//pega o array de resultados
    }