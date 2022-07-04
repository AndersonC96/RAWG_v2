<?php
    $url = explode('/', $_SERVER['REQUEST_URI']);//explode para separar a url em partes
    function active(String $getRoute){//função para verificar se a url é a mesma que a requisição
        //return $getRoute == $url[1] ? 'active' : '';
        global $url;//global para acessar a variável global $url
        $path = in_array($getRoute, $url);//in_array para verificar se a rota existe na url
        if($path){//se existir
            return 'active';
        }
        if($getRoute === 'home' && !in_array('pages', $url)){//se a rota for home e não existir a pasta pages na url
            return 'active';
        }
        return  '';//se não existir, retorna vazio
    }
?>
<aside class="left-menu" id="sidebar">
    <div class="logo-menu">
        <div>
            <img src="<?= in_array('pages', $url) ? '../..' : '.' ?>/assets/redoc-logo.png" alt="Rawg Api logo">
            <h3>Rawg API</h3>
        </div>
    </div>
    <nav class="menu">
        <ul class="menu-group">
            <li class="menu-item <?= active('home') ?>">
                <a href="<?= in_array('pages', $url) ? '../..' : '.' ?>/index.php">
                    <span class="material-icons">home</span>
                    Home
                </a>
            </li>
            <li class="menu-item <?= active('search') ?>">
                <a href="<?= in_array('pages', $url) ? '../..' : '.' ?>/pages/search/index.php">
                    <span class="material-icons">search</span>
                    Procurar
                </a>
            </li>
            <li class="menu-item <?= active('genres') ?>">
                <a href="<?= in_array('pages', $url) ? '../..' : '.' ?>/pages/genres/index.php">
                    <span class="material-icons">view_module</span>
                    Gêneros
                </a>
            </li>
        </ul>
    </nav>
    <div class="menu-footer">
        <strong>api@rawg.io</strong>
    </div>
</aside>