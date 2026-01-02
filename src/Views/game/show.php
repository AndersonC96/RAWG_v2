<?php
/**
 * Game Details View
 * 
 * @var object $game Game details
 * @var object|null $screenshots Screenshots response
 * @var object|null $additions Additions response
 * @var object|null $gameSeries Game series response
 * @var object|null $achievements Achievements response
 */
$basePath = '/RAWG_v2';
?>

<!-- Hero Section -->
<section class="game-hero mb-4">
    <div class="hero-background" style="background-image: url('<?= htmlspecialchars($game->background_image ?? '') ?>');">
        <div class="hero-overlay"></div>
    </div>
    <div class="hero-content container-fluid">
        <div class="row align-items-end">
            <div class="col-12">
                <nav aria-label="breadcrumb" class="mb-3">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= $basePath ?>/">Home</a></li>
                        <li class="breadcrumb-item active"><?= htmlspecialchars($game->name) ?></li>
                    </ol>
                </nav>
                
                <div class="d-flex align-items-center gap-3 mb-3">
                    <?php if (!empty($game->metacritic)): ?>
                    <span class="metacritic-badge bg-<?= $game->metacritic >= 75 ? 'success' : ($game->metacritic >= 50 ? 'warning' : 'danger') ?>">
                        <?= $game->metacritic ?>
                    </span>
                    <?php endif; ?>
                    <span class="badge bg-primary bg-opacity-75">
                        <i class="bi bi-star-fill me-1"></i>
                        #<?= $game->rating_top ?> Top <?= date('Y') ?>
                    </span>
                </div>
                
                <h1 class="game-title display-5 fw-bold mb-3"><?= htmlspecialchars($game->name) ?></h1>
                
                <div class="game-actions d-flex gap-2 flex-wrap">
                    <button class="btn btn-primary btn-lg btn-favorite-main"
                            data-game-id="<?= $game->id ?>"
                            data-game-name="<?= htmlspecialchars($game->name) ?>"
                            data-game-image="<?= htmlspecialchars($game->background_image ?? '') ?>">
                        <i class="bi bi-heart me-2"></i>
                        <span>Adicionar aos Favoritos</span>
                    </button>
                    
                    <button class="btn btn-outline-light btn-lg" data-bs-toggle="modal" data-bs-target="#shareModal">
                        <i class="bi bi-share me-2"></i>
                        Compartilhar
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<div class="container-fluid">
    <div class="row">
        <!-- Left Column -->
        <div class="col-lg-8">
            <!-- Description -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title d-flex align-items-center mb-3">
                        <i class="bi bi-file-text me-2 text-primary"></i>
                        Descrição
                    </h5>
                    <div class="game-description">
                        <?= $game->description ?>
                    </div>
                </div>
            </div>
            
            <!-- Screenshots -->
            <?php if (!empty($screenshots->results)): ?>
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title d-flex align-items-center mb-3">
                        <i class="bi bi-images me-2 text-primary"></i>
                        Screenshots (<?= count($screenshots->results) ?>)
                    </h5>
                    
                    <!-- Main Carousel -->
                    <div id="screenshotCarousel" class="carousel slide mb-3" data-bs-ride="false">
                        <div class="carousel-inner rounded overflow-hidden">
                            <?php foreach ($screenshots->results as $index => $screenshot): ?>
                            <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                <img src="<?= htmlspecialchars($screenshot->image) ?>" 
                                     class="d-block w-100 screenshot-main" 
                                     alt="Screenshot <?= $index + 1 ?>"
                                     data-bs-toggle="modal" 
                                     data-bs-target="#imageModal"
                                     data-image="<?= htmlspecialchars($screenshot->image) ?>"
                                     style="height: 400px; object-fit: cover; cursor: pointer;">
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#screenshotCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#screenshotCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    </div>
                    
                    <!-- Thumbnails -->
                    <div class="screenshot-thumbnails d-flex gap-2 overflow-auto pb-2">
                        <?php foreach ($screenshots->results as $index => $screenshot): ?>
                        <img src="<?= htmlspecialchars($screenshot->image) ?>" 
                             class="screenshot-thumb rounded <?= $index === 0 ? 'active' : '' ?>"
                             alt="Thumb <?= $index + 1 ?>"
                             data-bs-target="#screenshotCarousel"
                             data-bs-slide-to="<?= $index ?>"
                             style="height: 60px; width: 100px; object-fit: cover; cursor: pointer; opacity: 0.6; transition: opacity 0.3s;">
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            
            <style>
            .screenshot-thumbnails .screenshot-thumb:hover,
            .screenshot-thumbnails .screenshot-thumb.active { opacity: 1 !important; border: 2px solid var(--bs-primary); }
            .screenshot-main:hover { filter: brightness(1.1); }
            </style>
            
            <script>
            document.addEventListener('DOMContentLoaded', () => {
                const carousel = document.getElementById('screenshotCarousel');
                if (carousel) {
                    carousel.addEventListener('slid.bs.carousel', (e) => {
                        document.querySelectorAll('.screenshot-thumb').forEach((t, i) => {
                            t.classList.toggle('active', i === e.to);
                        });
                    });
                    // Click on main image opens modal
                    carousel.querySelectorAll('.screenshot-main').forEach(img => {
                        img.addEventListener('click', () => {
                            document.getElementById('modalImage').src = img.dataset.image;
                        });
                    });
                }
            });
            </script>
            <?php endif; ?>
            
            <!-- Trailers -->
            <?php if (!empty($trailers->results)): ?>
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title d-flex align-items-center mb-3">
                        <i class="bi bi-play-circle me-2 text-danger"></i>
                        Trailers (<?= count($trailers->results) ?>)
                    </h5>
                    
                    <!-- Main Video Carousel -->
                    <div id="trailerCarousel" class="carousel slide mb-3" data-bs-ride="false">
                        <div class="carousel-inner rounded overflow-hidden">
                            <?php foreach ($trailers->results as $index => $trailer): ?>
                            <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                <div class="ratio ratio-16x9">
                                    <video id="trailer-<?= $index ?>"
                                           src="<?= htmlspecialchars($trailer->data->max ?? $trailer->data->{'480'} ?? '') ?>" 
                                           poster="<?= htmlspecialchars($trailer->preview ?? '') ?>"
                                           controls
                                           preload="metadata"
                                           class="bg-dark trailer-video"></video>
                                </div>
                                <div class="text-center mt-2">
                                    <span class="badge bg-danger"><i class="bi bi-play-fill"></i> <?= htmlspecialchars($trailer->name ?? 'Trailer') ?></span>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#trailerCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#trailerCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    </div>
                    
                    <!-- Trailer Thumbnails -->
                    <div class="trailer-thumbnails d-flex gap-2 overflow-auto pb-2">
                        <?php foreach ($trailers->results as $index => $trailer): ?>
                        <div class="trailer-thumb-wrapper position-relative <?= $index === 0 ? 'active' : '' ?>"
                             data-bs-target="#trailerCarousel"
                             data-bs-slide-to="<?= $index ?>"
                             style="cursor: pointer; flex-shrink: 0;">
                            <img src="<?= htmlspecialchars($trailer->preview ?? '') ?>" 
                                 class="rounded"
                                 alt="<?= htmlspecialchars($trailer->name ?? 'Trailer') ?>"
                                 style="height: 60px; width: 107px; object-fit: cover; opacity: 0.6; transition: opacity 0.3s;">
                            <div class="position-absolute top-50 start-50 translate-middle">
                                <i class="bi bi-play-circle-fill text-white fs-5"></i>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            
            <style>
            .trailer-thumbnails .trailer-thumb-wrapper:hover img,
            .trailer-thumbnails .trailer-thumb-wrapper.active img { opacity: 1 !important; }
            .trailer-thumbnails .trailer-thumb-wrapper.active { outline: 2px solid var(--bs-danger); border-radius: 0.375rem; }
            </style>
            
            <script>
            document.addEventListener('DOMContentLoaded', () => {
                const trailerCarousel = document.getElementById('trailerCarousel');
                if (trailerCarousel) {
                    // Pause all videos when sliding
                    trailerCarousel.addEventListener('slide.bs.carousel', () => {
                        document.querySelectorAll('.trailer-video').forEach(v => v.pause());
                    });
                    // Update active thumbnail
                    trailerCarousel.addEventListener('slid.bs.carousel', (e) => {
                        document.querySelectorAll('.trailer-thumb-wrapper').forEach((t, i) => {
                            t.classList.toggle('active', i === e.to);
                        });
                    });
                }
            });
            </script>
            <?php endif; ?>
            
            <!-- Achievements -->
            <?php if (!empty($achievements->results)): ?>
            <?php $totalAchievements = count($achievements->results); ?>
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title d-flex align-items-center mb-3">
                        <i class="bi bi-trophy me-2 text-warning"></i>
                        Conquistas (<?= $achievements->count ?>)
                    </h5>
                    
                    <!-- Initial 8 achievements -->
                    <div class="row g-3">
                        <?php foreach (array_slice($achievements->results, 0, 8) as $achievement): ?>
                        <div class="col-md-6">
                            <div class="achievement-card d-flex gap-3 p-3 rounded bg-body-tertiary">
                                <img src="<?= htmlspecialchars($achievement->image) ?>" 
                                     alt="<?= htmlspecialchars($achievement->name) ?>"
                                     class="achievement-icon rounded"
                                     width="48" height="48">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1"><?= htmlspecialchars($achievement->name) ?></h6>
                                    <small class="text-muted d-block"><?= htmlspecialchars($achievement->description) ?></small>
                                    <small class="text-success">
                                        <i class="bi bi-percent"></i> <?= $achievement->percent ?>% desbloquearam
                                    </small>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <!-- Collapsible remaining achievements -->
                    <?php if ($totalAchievements > 8): ?>
                    <div class="collapse" id="moreAchievements">
                        <div class="row g-3 mt-0">
                            <?php foreach (array_slice($achievements->results, 8) as $achievement): ?>
                            <div class="col-md-6">
                                <div class="achievement-card d-flex gap-3 p-3 rounded bg-body-tertiary">
                                    <img src="<?= htmlspecialchars($achievement->image) ?>" 
                                         alt="<?= htmlspecialchars($achievement->name) ?>"
                                         class="achievement-icon rounded"
                                         width="48" height="48">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1"><?= htmlspecialchars($achievement->name) ?></h6>
                                        <small class="text-muted d-block"><?= htmlspecialchars($achievement->description) ?></small>
                                        <small class="text-success">
                                            <i class="bi bi-percent"></i> <?= $achievement->percent ?>% desbloquearam
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <!-- Toggle Button -->
                    <div class="text-center mt-3">
                        <button class="btn btn-outline-warning" 
                                type="button" 
                                data-bs-toggle="collapse" 
                                data-bs-target="#moreAchievements"
                                aria-expanded="false">
                            <span class="show-more">
                                <i class="bi bi-chevron-down me-1"></i> Ver mais <?= $totalAchievements - 8 ?> conquistas
                            </span>
                            <span class="show-less d-none">
                                <i class="bi bi-chevron-up me-1"></i> Ver menos
                            </span>
                        </button>
                    </div>
                    
                    <script>
                    document.addEventListener('DOMContentLoaded', () => {
                        const collapseEl = document.getElementById('moreAchievements');
                        if (collapseEl) {
                            collapseEl.addEventListener('show.bs.collapse', () => {
                                const btn = document.querySelector('[data-bs-target="#moreAchievements"]');
                                btn.querySelector('.show-more').classList.add('d-none');
                                btn.querySelector('.show-less').classList.remove('d-none');
                            });
                            collapseEl.addEventListener('hide.bs.collapse', () => {
                                const btn = document.querySelector('[data-bs-target="#moreAchievements"]');
                                btn.querySelector('.show-more').classList.remove('d-none');
                                btn.querySelector('.show-less').classList.add('d-none');
                            });
                        }
                    });
                    </script>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- Development Team -->
            <?php if (!empty($devTeam->results)): ?>
            <?php $totalDevTeam = count($devTeam->results); ?>
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title d-flex align-items-center mb-3">
                        <i class="bi bi-person-badge me-2 text-info"></i>
                        Equipe de Desenvolvimento (<?= $totalDevTeam ?>)
                    </h5>
                    
                    <!-- Initial 12 members -->
                    <div class="row g-3">
                        <?php foreach (array_slice($devTeam->results, 0, 12) as $creator): ?>
                        <div class="col-md-4 col-6">
                            <div class="creator-card d-flex align-items-center gap-2 p-2 rounded bg-body-tertiary">
                                <?php if (!empty($creator->image)): ?>
                                <img src="<?= htmlspecialchars($creator->image) ?>" 
                                     alt="<?= htmlspecialchars($creator->name) ?>"
                                     class="rounded-circle"
                                     width="40" height="40"
                                     style="object-fit: cover;">
                                <?php else: ?>
                                <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center" 
                                     style="width: 40px; height: 40px;">
                                    <i class="bi bi-person text-white"></i>
                                </div>
                                <?php endif; ?>
                                <div class="flex-grow-1 overflow-hidden">
                                    <h6 class="mb-0 text-truncate small"><?= htmlspecialchars($creator->name) ?></h6>
                                    <?php if (!empty($creator->positions)): ?>
                                    <small class="text-muted text-truncate d-block">
                                        <?= htmlspecialchars($creator->positions[0]->name ?? '') ?>
                                    </small>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <!-- Collapsible remaining members -->
                    <?php if ($totalDevTeam > 12): ?>
                    <div class="collapse" id="moreDevTeam">
                        <div class="row g-3 mt-0">
                            <?php foreach (array_slice($devTeam->results, 12) as $creator): ?>
                            <div class="col-md-4 col-6">
                                <div class="creator-card d-flex align-items-center gap-2 p-2 rounded bg-body-tertiary">
                                    <?php if (!empty($creator->image)): ?>
                                    <img src="<?= htmlspecialchars($creator->image) ?>" 
                                         alt="<?= htmlspecialchars($creator->name) ?>"
                                         class="rounded-circle"
                                         width="40" height="40"
                                         style="object-fit: cover;">
                                    <?php else: ?>
                                    <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center" 
                                         style="width: 40px; height: 40px;">
                                        <i class="bi bi-person text-white"></i>
                                    </div>
                                    <?php endif; ?>
                                    <div class="flex-grow-1 overflow-hidden">
                                        <h6 class="mb-0 text-truncate small"><?= htmlspecialchars($creator->name) ?></h6>
                                        <?php if (!empty($creator->positions)): ?>
                                        <small class="text-muted text-truncate d-block">
                                            <?= htmlspecialchars($creator->positions[0]->name ?? '') ?>
                                        </small>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <!-- Toggle Button -->
                    <div class="text-center mt-3">
                        <button class="btn btn-outline-info" 
                                type="button" 
                                data-bs-toggle="collapse" 
                                data-bs-target="#moreDevTeam"
                                aria-expanded="false">
                            <span class="show-more-dev">
                                <i class="bi bi-chevron-down me-1"></i> Ver mais <?= $totalDevTeam - 12 ?> membros
                            </span>
                            <span class="show-less-dev d-none">
                                <i class="bi bi-chevron-up me-1"></i> Ver menos
                            </span>
                        </button>
                    </div>
                    
                    <script>
                    document.addEventListener('DOMContentLoaded', () => {
                        const collapseDevEl = document.getElementById('moreDevTeam');
                        if (collapseDevEl) {
                            collapseDevEl.addEventListener('show.bs.collapse', () => {
                                const btn = document.querySelector('[data-bs-target="#moreDevTeam"]');
                                btn.querySelector('.show-more-dev').classList.add('d-none');
                                btn.querySelector('.show-less-dev').classList.remove('d-none');
                            });
                            collapseDevEl.addEventListener('hide.bs.collapse', () => {
                                const btn = document.querySelector('[data-bs-target="#moreDevTeam"]');
                                btn.querySelector('.show-more-dev').classList.remove('d-none');
                                btn.querySelector('.show-less-dev').classList.add('d-none');
                            });
                        }
                    });
                    </script>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
        
        <!-- Right Column -->
        <div class="col-lg-4">
            <!-- Game Info -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title d-flex align-items-center mb-3">
                        <i class="bi bi-info-circle me-2 text-primary"></i>
                        Informações
                    </h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">Lançamento</span>
                            <span><?= !empty($game->released) ? date('d/m/Y', strtotime($game->released)) : 'N/A' ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">Metacritic</span>
                            <span><?= $game->metacritic ?? 'N/A' ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">Duração</span>
                            <span><?= $game->playtime > 0 ? $game->playtime . 'h' : 'N/A' ?></span>
                        </li>
                        <li class="list-group-item px-0">
                            <span class="text-muted d-block mb-2">Gêneros</span>
                            <div class="d-flex flex-wrap gap-1">
                                <?php foreach ($game->genres ?? [] as $genre): ?>
                                <span class="badge bg-secondary"><?= htmlspecialchars($genre->name) ?></span>
                                <?php endforeach; ?>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <span class="text-muted d-block mb-2">Plataformas</span>
                            <div class="d-flex flex-wrap gap-1">
                                <?php foreach ($game->platforms ?? [] as $p): ?>
                                <span class="badge bg-dark"><?= htmlspecialchars($p->platform->name) ?></span>
                                <?php endforeach; ?>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <span class="text-muted d-block mb-2">Desenvolvedora</span>
                            <?php 
                            $devs = array_map(fn($d) => $d->name, $game->developers ?? []);
                            echo htmlspecialchars(implode(', ', $devs) ?: 'N/A');
                            ?>
                        </li>
                        <li class="list-group-item px-0">
                            <span class="text-muted d-block mb-2">Publisher</span>
                            <?php 
                            $pubs = array_map(fn($p) => $p->name, $game->publishers ?? []);
                            echo htmlspecialchars(implode(', ', $pubs) ?: 'N/A');
                            ?>
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Ratings -->
            <?php if (!empty($game->ratings)): ?>
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title d-flex align-items-center mb-3">
                        <i class="bi bi-bar-chart me-2 text-primary"></i>
                        Avaliações
                    </h5>
                    <?php foreach ($game->ratings as $rating): ?>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span><?= ucfirst($rating->title) ?></span>
                            <span class="text-muted"><?= number_format($rating->percent, 1) ?>%</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-<?= match($rating->title) {
                                'exceptional' => 'success',
                                'recommended' => 'primary',
                                'meh' => 'warning',
                                default => 'secondary'
                            } ?>" style="width: <?= $rating->percent ?>%;"></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- Stores -->
            <?php if (!empty($game->stores)): ?>
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title d-flex align-items-center mb-3">
                        <i class="bi bi-shop me-2 text-primary"></i>
                        Onde Comprar
                    </h5>
                    <div class="d-flex flex-wrap gap-2">
                        <?php foreach ($game->stores as $store): ?>
                        <a href="https://<?= htmlspecialchars($store->store->domain) ?>" 
                           target="_blank" 
                           rel="noopener"
                           class="btn btn-outline-secondary btn-sm">
                            <?= htmlspecialchars($store->store->name) ?>
                            <i class="bi bi-box-arrow-up-right ms-1"></i>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- Tags -->
            <?php if (!empty($game->tags)): ?>
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title d-flex align-items-center mb-3">
                        <i class="bi bi-tags me-2 text-primary"></i>
                        Tags
                    </h5>
                    <div class="d-flex flex-wrap gap-1">
                        <?php foreach (array_slice($game->tags, 0, 15) as $tag): ?>
                        <span class="badge bg-body-tertiary text-body"><?= htmlspecialchars($tag->name) ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- DLCs & Additions -->
    <?php if (!empty($additions->results)): ?>
    <?php $totalAdditions = count($additions->results); ?>
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title d-flex align-items-center mb-3">
                <i class="bi bi-plus-circle me-2 text-success"></i>
                DLCs e Expansões (<?= $totalAdditions ?>)
            </h5>
            
            <!-- Initial 6 DLCs -->
            <div class="row row-cols-2 row-cols-md-4 row-cols-lg-6 g-3">
                <?php foreach (array_slice($additions->results, 0, 6) as $dlc): ?>
                <div class="col">
                    <a href="<?= $basePath ?>/game/<?= $dlc->id ?>" class="text-decoration-none">
                        <div class="dlc-card">
                            <img src="<?= htmlspecialchars($dlc->background_image ?? '') ?>" 
                                 class="img-fluid rounded mb-2" 
                                 alt="<?= htmlspecialchars($dlc->name) ?>"
                                 style="height: 80px; width: 100%; object-fit: cover;">
                            <h6 class="text-truncate mb-0 small"><?= htmlspecialchars($dlc->name) ?></h6>
                            <?php if (!empty($dlc->released)): ?>
                            <small class="text-muted"><?= date('Y', strtotime($dlc->released)) ?></small>
                            <?php endif; ?>
                        </div>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Collapsible remaining DLCs -->
            <?php if ($totalAdditions > 6): ?>
            <div class="collapse" id="moreDLCs">
                <div class="row row-cols-2 row-cols-md-4 row-cols-lg-6 g-3 mt-0">
                    <?php foreach (array_slice($additions->results, 6) as $dlc): ?>
                    <div class="col">
                        <a href="<?= $basePath ?>/game/<?= $dlc->id ?>" class="text-decoration-none">
                            <div class="dlc-card">
                                <img src="<?= htmlspecialchars($dlc->background_image ?? '') ?>" 
                                     class="img-fluid rounded mb-2" 
                                     alt="<?= htmlspecialchars($dlc->name) ?>"
                                     style="height: 80px; width: 100%; object-fit: cover;">
                                <h6 class="text-truncate mb-0 small"><?= htmlspecialchars($dlc->name) ?></h6>
                                <?php if (!empty($dlc->released)): ?>
                                <small class="text-muted"><?= date('Y', strtotime($dlc->released)) ?></small>
                                <?php endif; ?>
                            </div>
                        </a>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <!-- Toggle Button -->
            <div class="text-center mt-3">
                <button class="btn btn-outline-success" 
                        type="button" 
                        data-bs-toggle="collapse" 
                        data-bs-target="#moreDLCs"
                        aria-expanded="false">
                    <span class="show-more-dlc">
                        <i class="bi bi-chevron-down me-1"></i> Ver mais <?= $totalAdditions - 6 ?> DLCs
                    </span>
                    <span class="show-less-dlc d-none">
                        <i class="bi bi-chevron-up me-1"></i> Ver menos
                    </span>
                </button>
            </div>
            
            <script>
            document.addEventListener('DOMContentLoaded', () => {
                const collapseDlcEl = document.getElementById('moreDLCs');
                if (collapseDlcEl) {
                    collapseDlcEl.addEventListener('show.bs.collapse', () => {
                        const btn = document.querySelector('[data-bs-target="#moreDLCs"]');
                        btn.querySelector('.show-more-dlc').classList.add('d-none');
                        btn.querySelector('.show-less-dlc').classList.remove('d-none');
                    });
                    collapseDlcEl.addEventListener('hide.bs.collapse', () => {
                        const btn = document.querySelector('[data-bs-target="#moreDLCs"]');
                        btn.querySelector('.show-more-dlc').classList.remove('d-none');
                        btn.querySelector('.show-less-dlc').classList.add('d-none');
                    });
                }
            });
            </script>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>
    
    <!-- Related Games -->
    <?php if (!empty($gameSeries->results)): ?>
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title d-flex align-items-center mb-3">
                <i class="bi bi-collection me-2 text-primary"></i>
                Jogos da Franquia (<?= count($gameSeries->results) ?>)
            </h5>
            <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-6 g-3">
                <?php foreach ($gameSeries->results as $related): ?>
                <div class="col">
                    <a href="<?= $basePath ?>/game/<?= $related->id ?>" class="text-decoration-none">
                        <div class="related-game-card position-relative">
                            <img src="<?= htmlspecialchars($related->background_image ?? '') ?>" 
                                 class="img-fluid rounded mb-2" 
                                 alt="<?= htmlspecialchars($related->name) ?>"
                                 style="height: 100px; width: 100%; object-fit: cover;">
                            <?php if (!empty($related->metacritic)): ?>
                            <span class="position-absolute top-0 end-0 m-1 badge bg-<?= $related->metacritic >= 75 ? 'success' : ($related->metacritic >= 50 ? 'warning' : 'danger') ?>">
                                <?= $related->metacritic ?>
                            </span>
                            <?php endif; ?>
                            <h6 class="text-truncate mb-0 small"><?= htmlspecialchars($related->name) ?></h6>
                            <?php if (!empty($related->released)): ?>
                            <small class="text-muted"><?= date('Y', strtotime($related->released)) ?></small>
                            <?php endif; ?>
                        </div>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content bg-transparent border-0">
            <div class="modal-body p-0 text-center">
                <img src="" id="modalImage" class="img-fluid rounded" alt="Screenshot">
            </div>
        </div>
    </div>
</div>

<!-- Share Modal -->
<div class="modal fade" id="shareModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Compartilhar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-center gap-3">
                    <a href="https://twitter.com/intent/tweet?text=<?= urlencode($game->name) ?>&url=<?= urlencode('http://localhost' . $basePath . '/game/' . $game->id) ?>" 
                       target="_blank" class="btn btn-outline-primary btn-lg">
                        <i class="bi bi-twitter"></i>
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode('http://localhost' . $basePath . '/game/' . $game->id) ?>" 
                       target="_blank" class="btn btn-outline-primary btn-lg">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="https://wa.me/?text=<?= urlencode($game->name . ' - http://localhost' . $basePath . '/game/' . $game->id) ?>" 
                       target="_blank" class="btn btn-outline-success btn-lg">
                        <i class="bi bi-whatsapp"></i>
                    </a>
                    <button class="btn btn-outline-secondary btn-lg" onclick="copyLink()">
                        <i class="bi bi-link-45deg"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Screenshot modal
    document.querySelectorAll('.screenshot-link').forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            document.getElementById('modalImage').src = link.dataset.image;
        });
    });
    
    // Check favorite status
    const gameId = <?= $game->id ?>;
    if (window.FavoritesManager && FavoritesManager.isFavorite(gameId)) {
        const btn = document.querySelector('.btn-favorite-main');
        if (btn) {
            btn.querySelector('i').classList.replace('bi-heart', 'bi-heart-fill');
            btn.querySelector('span').textContent = 'Remover dos Favoritos';
        }
    }
});

function copyLink() {
    navigator.clipboard.writeText(window.location.href);
    alert('Link copiado!');
}
</script>
