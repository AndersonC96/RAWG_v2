<?php
    error_reporting(-1);
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
    include_once('./controllers/homeController.php');
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/png" href="./assets/redoc-logo.png" />
        <title>Rawg API</title>
        <link rel="stylesheet" href="./style.css">
        <?php
            include('./components/importsLink.php')
        ?>
    </head>
    <body>
        <div class="container-wrapper">
            <?php
                include_once('./components/sidebar.php')
            ?>
            <div>
                <?php
                    include_once('./components/header.php')
                ?>
                <section class="flyer">
                    <div class="background" style="background: url(<?= $data[$sorty]->background_image ?>), #000;"></div>
                    <div class="content">
                        <video src="<?= $data[$sorty]->clip->clip ?>" controls muted loop></video>
                        <div class="flyer-description">
                            <h2><?= $data[$sorty]->name ?></h2>
                            <div class="card-genres">
                                <?php
                                    foreach($data[$sorty]->genres as $genre){//foreach para mostrar os gêneros
                                    //echo '<span class="genre">'.$genre.'</span>';
                                ?>
                                <span><?= $genre->name ?></span>
                                <?php
                                    }
                                ?>
                            </div>
                            <ul>
                                <li>
                                    <div class="ratings">
                                        <?php
                                            foreach($data[$sorty]->ratings as $rating){//foreach para mostrar as avaliações
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
                        </div>
                        <a href="./pages/game/index.php?id=<?= $data[$sorty]->id ?>" class="open-game">
                            <span class="material-icons">open_in_new</span>
                        </a>
                    </div>
                </section>
                <article class="container">
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
                                </div>
                                <a href="./pages/game/index.php?id=<?= $game->id ?>" class="open-game">
                                    <span class="material-icons">open_in_new</span>
                                </a>
                            </div>
                        </div>
                        <?php
                            }
                        ?>
                    </div>
                    <div class="pagination">
                        <a href="./index.php?page=<?= $previous ? $previous[1] ?? 1 : 1 ?>" class="<?= $previous === null ? 'disable' : '' ?>">
                            <span class="material-icons">keyboard_arrow_left</span>
                        </a>
                        <a href="./index.php?page=<?= $next ? $next[1] ?? '' : '' ?>" class="<?= $next === null ? 'disable' : '' ?>">
                            <span class="material-icons">keyboard_arrow_right</span>
                        </a>
                    </div>
                </article>
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