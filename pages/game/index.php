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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
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
                            <h3>Informações</h3>
                        </div>
                        <li><b>Lançamento:</b> <?php $rel = date('d/m/Y', strtotime($data->released)); echo $rel?></li>
                        <li><b>Metacritic:</b> <?= $data->metacritic ?></li>
                        <li><b>Gênero:</b> 
                        <?php
                            $genres_names = array();
                            foreach($data->genres as $genre){
                                $genres_names[] = $genre->name;
                            }
                            echo implode(', ', $genres_names);
                        ?>
                        </li>
                        <li><b>Plataformas:</b> 
                            <?php
                                foreach($data->parent_platforms as $parent_platforms){
                                    $parent_platforms_names[] = $parent_platforms->platform->name;
                                }
                                echo implode(', ', $parent_platforms_names);
                            ?>
                        </li>
                        <li><b>Consoles:</b> 
                            <?php
                                foreach($data->platforms as $platform){
                                    $platform_names[] = $platform->platform->name;
                                }
                                echo implode(', ', $platform_names);
                            ?>
                        </li>
                        <li><b>Desenvolvedora:</b> 
                            <?php
                                foreach($data->developers as $developer){
                                    $developer_names[] = $developer->name;
                                }
                                echo implode(', ', $developer_names);
                            ?>
                        </li>
                        <li><b>Publisher:</b> 
                            <?php
                                foreach($data->publishers as $publisher){
                                    $publisher_names[] = $publisher->name;
                                }
                                echo implode(', ', $publisher_names);
                            ?>
                        </li>
                        <li><b>Duração média:</b> 
                            <?php
                                if($data->playtime == 0){
                                    echo "Não informado";
                                }else{
                                    if($data->playtime == 1){
                                        echo $data->playtime . " Hora";
                                    }else{
                                        echo $data->playtime . " Horas";
                                    }
                                }
                            ?>
                        </li>
                        <div class="store">
                            <h3>DLC's e Edições especiais</h3>
                        </div>
                        <div class="tags">
                            <?php
                                if($additions->results == null){
                                    echo '<li>' . "Nenhuma DLC ou Edição especial" . '</li>';
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
                            <!--<div>
                                <video src="<?= $data->clip->clip ?>" controls muted loop></video>
                            </div>-->
                            <div>
                                <ul class="ratings-container">
                                    <h4>Avaliações</h4>
                                    <li>
                                        <center>
                                            <div class="ratings">
                                                <?php
                                                    foreach($data->ratings as $rating){//foreach para mostrar as avaliações
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
                                        </center>
                                    </li>
                                </ul>
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
                                ?>
                                <a href="<?= $store->store->domain ?>" target="blank">
                                    <?php
                                        if($store->store->name == 'Steam'){
                                            echo '<img src="/RAWG_v2/img/steam.png" alt="' . $store->store->slug . '">';
                                        }elseif($store->store->name == 'Epic Games'){
                                            echo '<img src="/RAWG_v2/img/epic.jpg" alt="' . $store->store->slug . '">';
                                        }elseif($store->store->name == 'PlayStation Store'){
                                            echo '<img src="/RAWG_v2/img/ps.png" alt="' . $store->store->slug . '">';
                                        }elseif($store->store->name == 'Nintendo Store'){
                                            echo '<img src="/RAWG_v2/img/nintendo.jpg" alt="' . $store->store->slug . '">';
                                        }elseif($store->store->name == 'Xbox Store'){
                                            echo '<img src="/RAWG_v2/img/xbox.png" alt="' . $store->store->slug . '">';
                                        }elseif($store->store->name == 'App Store'){
                                            echo '<img src="/RAWG_v2/img/apple.png" alt="' . $store->store->slug . '">';
                                        }elseif($store->store->name == 'GOG'){
                                            echo '<img src="/RAWG_v2/img/gog.jpg" alt="' . $store->store->slug . '">';
                                        }elseif($store->store->name == 'Google Play'){
                                            echo '<img src="/RAWG_v2/img/google.jpg" alt="' . $store->store->slug . '">';
                                        }elseif($store->store->name == 'Xbox 360 Store'){
                                            echo '<img src="/RAWG_v2/img/xbox.png" alt="' . $store->store->slug . '">';
                                        }else{
                                            echo '<img src="' . $store->store->image_background . '" alt="' . $store->store->slug . '">';
                                        }
                                    ?>
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function(){
                $('.owl-carousel').owlCarousel({
                    loop: true,
                    margin: 10,
                    nav: true,
                    responsive:{
                        0: {
                            items: 1
                        },
                        600: {
                            items: 3
                        },
                        1000: {
                            items: 5
                        }
                    }
                });
            });
        </script>
    </body>
</html>