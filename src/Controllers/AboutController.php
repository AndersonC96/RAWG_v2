<?php

declare(strict_types=1);

namespace App\Controllers;

class AboutController extends BaseController
{
    public function index(): void
    {
        $this->setTitle('Sobre o Projeto - RAWG API Portfolio');
        $this->render('about/index');
    }
}
