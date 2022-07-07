<?php
    error_reporting(-1);
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
    include_once('../../controllers/gameController.php');
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/png" href="../../assets/redoc-logo.png" />
        <title><?= $data->name ?></title>
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
                <section class="flyer-game">
                    <div class="background" style="background: url(<?= $data->background_image ?>), #000;"></div>
                    <div class="flyer-game-description">
                        <h1><?= $data->name ?></h1>
                        <span>#<?= $data->rating_top ?> Top <?= getdate()['year'] ?></span>
                        <!--<span><?php if($data->metacritic == 0 && 19){
                            echo "$data->metacritic - Desgosto";
                            }else if($data->metacritic == 20 && 49){
                                echo "$data->metacritic - Ruim";
                            }else if($data->metacritic == 50 && 74){
                                echo "$data->metacritic - Regular";
                            }else if($data->metacritic == 75 && 89){
                                echo "$data->metacritic - Bom";
                            }else{
                                echo "$data->metacritic - Ótimo";
                            }?> | #<?= $data->rating_top ?> Top <?= getdate()['year'] ?>
                        </span>-->
                    </div>
                </section>
                <main>
                    <article class="container">
                        <p><?= $data->description ?></p>
                        <div class="store">
                            <h3>Dados</h3>
                        </div>
                        <!--<b>Lançamento:</b> <?= $data->released ?>-->
                        <li><b>Lançamento:</b> <?php $rel = date('d/m/Y', strtotime($data->released)); echo $rel?></li>
                        <!--<li><b>Metacritic:</b> <?php if($data->metacritic == 0 && 19){
                            echo $data->metacritic;
                            }else if($data->metacritic == 20 && 49){
                                echo $data->metacritic;
                            }else if($data->metacritic == 50 && 74){
                                echo $data->metacritic;
                            }else if($data->metacritic == 75 && 89){
                                echo $data->metacritic;
                            }else{
                                echo $data->metacritic;
                            }?>
                        </li>-->
                        <li><b>Metacritic:</b> <?= $data->metacritic ?></li>
                        <li><b>Plataformas:</b> 
                            <?php
                                foreach($data->platforms as $platform){
                                    echo $platform->platform->name . ', ';
                                }
                            ?>
                        </li>
                        <li><b>Desenvolvedora:</b> 
                            <?php
                                foreach($data->developers as $developer){
                                    echo $developer->name . ', ';
                                }
                            ?>
                        </li>
                        <li><b>Publisher:</b> 
                            <?php
                                foreach($data->publishers as $publisher){
                                    echo $publisher->name . ', ';
                                }
                            ?>
                        </li>
                        <li><b>Duração média:</b> <?= $data->playtime ?> Horas</li>
                        <div class="store">
                            <h3>DLC's e Edições especiais</h3>
                        </div>
                        <div class="tags">
                            <?php
                                if($additions->results == null){
                                    echo '<li>' . "Nenhum DLC ou Edição especial" . '</li>';
                                }else{
                                    foreach($additions->results as $additions){
                            ?>
                            <a href="#">
                                <img src="<?= $additions->background_image ?>" alt="<?= $additions->name ?>">
                                <span><?= $additions->name ?></span>
                            </a>
                            <?php
                                    }
                                }
                            ?>
                        </div>
                        <div class="store">
                            <h3>Jogos da Franquia</h3>
                        </div>
                        <div class="tags">
                            <?php
                                if($gameSeries->results == null){
                                    echo '<li>' . "Este jogo não é uma franquia" . '</li>';
                                }else{
                                    foreach($gameSeries->results as $gameSeries){
                                        if($gameSeries->name == null){
                                            echo '<li>' . "Não possui" . '</li>';
                                        }else{
                            ?>
                            <a href="#">
                                <img src="<?= $gameSeries->background_image ?>" alt="<?= $gameSeries->name ?>">
                                <span><?= $gameSeries->name ?></span>
                            </a>
                            <?php
                                        }
                                    }
                                }
                            ?>
                        </div>
                        <div class="game-expecification">
                            <div>
                                <video src="<?= $data->clip->clip ?>" controls muted loop></video>
                            </div>
                            <div>
                                <ul>
                                    <h4>Avaliações</h4>
                                    <li>
                                        <div class="ratings">
                                            <?php
                                                foreach($data->ratings as $rating){//foreach para mostrar as avaliações
                                                    //echo '<span class="rating">'.$rating->title.'</span>';
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
                                <div class="game-genres">
                                    <h4>Gêneros</h4>
                                    <div>
                                        <?php
                                            foreach($data->genres as $genre){//foreach para mostrar os gêneros
                                                //echo '<span class="genre">'.$genre.'</span>';
                                        ?>
                                        <a href="#"><?= $genre->name ?></a>
                                        <?php
                                                //echo substr($genre->name, 0, -2);
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="store">
                            <h3>Screenshots</h3>
                        </div>
                        <div class="grid-screenshot">
                            <?php
                                foreach($screenshots->results as $screenshot){
                            ?>
                            <div class="card-screenshot">
                                <img src="<?= $screenshot->image ?>" alt="<?= $screenshot->id ?>" />
                            </div>
                            <?php
                                }
                            ?>
                        </div>
                        <div class="store">
                            <h3>Tags</h3>
                        </div>
                        <div class="tags">
                            <?php
                                foreach($data->tags as $tag){//foreach para mostrar as tags
                                    //echo '<span class="tag">'.$tag.'</span>';
                            ?>
                            <a href="#">
                                <img src="<?= $tag->image_background ?>" alt="<?= $tag->slug ?>">
                                <span><?= $tag->name ?></span>
                            </a>
                            <?php
                                }
                            ?>
                        </div>
                        <div class="store">
                            <h3>Conquistas</h3>
                        </div>
                        <div class="tags">
                            <?php
                                if($achievements->results == null){
                                    echo '<li>' . "Este jogo não tem conquistas" . '</li>';
                                }else{
                                    foreach($achievements->results as $achievements){//foreach para mostrar as conquistas
                            ?>
                            <a href="#">
                                <img src="<?= $achievements->image ?>" alt="<?= $achievements->name ?>">
                                <span><?= $achievements->name ?></span>
                            </a>
                            <?php
                                    }
                                }
                            ?>
                        </div>
                        <div class="store">
                            <h3>Lojas</h3>
                            <div>
                                <?php
                                    if($data->stores == null){
                                        echo '<li>' . "Este jogo não está disponível em nenhuma loja" . '</li>';
                                    }else{
                                        foreach($data->stores as $store){//foreach para mostrar as lojas
                                            //echo '<span class="store">'.$store.'</span>';
                                ?>
                                <a href="<?= $store->store->domain ?>" target="blank">
                                    <img src="<?= $store->store->image_background ?>" alt="<?= $store->store->slug ?>">
                                    <span><?= $store->store->name ?></span>
                                </a>
                                <?php
                                        }
                                    }
                                ?>
                            </div>
                        </div>
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