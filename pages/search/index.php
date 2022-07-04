<?php
    error_reporting(-1);
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
    include_once('../../controllers/searchController.php');
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/png" href="../../assets/redoc-logo.png" />
        <title>Rawg API</title>
        <link rel="stylesheet" href="../../style.css">
        <link rel="stylesheet" href="./style.css">
        <?php
            include('../../components/importsLink.php')
        ?>
    </head>
    <body>
        <div class="container-wrapper">
            <?php
                include_once('../../components/sidebar.php')
            ?>
            <div>
                <?php
                    include_once('../../components/header.php')
                ?>
                <main>
                    <article class="container">
                        <form action="" method="POST" class="header-search">
                            <input type="text" name="search" value="<?= $_POST['search'] ?? '' ?>" placeholder="Digite o nome do jogo" required>
                            <button type="submit">
                                <span class="material-icons">search</span>
                            </button>
                        </form>
                        <?php
                            if(isset($_POST['search'])){//se o botão de busca for clicado
                                /*$search = str_replace(' ', '%20', $_POST['search']);//substitui os espaços por %20
                                $response = api("games?search={$search}");//pega o json da api
                                $data = $response->results;//pega o array de resultados*/
                        ?>
                        <h2 style="margin: 10px 0 20px;">Resultados da pesquisa: "<?= $_POST['search'] ?>"</h2>
                        <?php
                            if(count($data) > 0){//se existir algum resultado
                                //foreach($data as $game){//foreach para mostrar os resultados
                        ?>
                        <div class="grid">
                            <?php
                                foreach($data as $key => $game){
                            ?>
                            <div class="card">
                                <img src="<?= $game->background_image ?>" alt="<?= $game->slug ?>">
                                <div class="card-body">
                                    <div class="card-genres">
                                        <?php
                                            $i = 0;
                                            foreach($game->genres as $genre){//foreach para mostrar os gêneros
                                                /*if($i < 3){
                                                    //echo '<span class="genre">'.$genre.'</span>';
                                                    echo '<span>'.$genre->name.'</span>';
                                                    $i++;
                                                }*/
                                                if(++$i > 3) break;
                                        ?>
                                        <span><?= $genre->name ?></span>
                                        <?php
                                            }
                                        ?>
                                    </div>
                                    <strong><?= $game->name ?></strong>
                                    <div class="card-descriptions">
                                        <ul>
                                            <li>
                                                <div class="ratings">
                                                    <?php
                                                        foreach($game->ratings as $rating){//foreach para mostrar as avaliações
                                                            //echo '<span class="material-icons">star</span>';
                                                    ?>
                                                    <div>
                                                        <?= ucfirst($rating->title) ?>
                                                        <span class="porcent">
                                                            <span style="width: <?= $rating->percent ?>%;"></span>
                                                        </span>
                                                    </div>
                                                    <?php
                                                        }
                                                    ?>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <a href="../game/index.php?id=<?= $game->id ?>" class="open-game">
                                        <span class="material-icons">open_in_new</span>
                                    </a>
                                </div>
                            </div>
                            <?php
                                }
                            ?>
                        </div>
                        <?php
                            }else{//se não existir nenhum resultado
                                //echo '<h2>Nenhum resultado encontrado</h2>';
                        ?>
                        <p>Nenhum resultado encontrado</p>
                        <?php
                                }
                            }
                        ?>
                    </article>
                </main>
            </div>
        </div>
        <script>
            const sidebar = document.getElementById('sidebar');
            const handleMenu = () => {
                const open = sidebar.classList.contains('open');
                if(!open){
                    sidebar.classList.add('open');
                    sidebar.style.cssText = 'left: 0';
                }else{
                    sidebar.classList.remove('open');
                    sidebar.style.cssText = 'left: -120%';
                }
            }
        </script>
    </body>
</html>