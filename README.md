# RAWG_v2 🎮

<div align="center">

![PHP](https://img.shields.io/badge/PHP-8.0+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-ES6+-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)
![PSR-4](https://img.shields.io/badge/PSR--4-Autoload-4F5D95?style=for-the-badge)
![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)

**Aplicação web moderna para explorar jogos usando a API RAWG**

[Demo](#demo) • [Arquitetura](#-arquitetura) • [Instalação](#-instalação) • [Funcionalidades](#-funcionalidades)

</div>

---

## 📖 Sobre

O **RAWG_v2** é uma aplicação web PHP que demonstra boas práticas de desenvolvimento, incluindo:

- 🏗️ **Arquitetura MVC** com separação clara de responsabilidades
- 📦 **PSR-4 Autoloading** com namespaces organizados
- 🎨 **Bootstrap 5** com design moderno e responsivo
- 🔒 **Segurança** com variáveis de ambiente para API keys
- 📱 **PWA Ready** com Service Worker para offline

## 🏛️ Arquitetura

```
RAWG_v2/
├── 📂 src/                     # Código fonte (PSR-4)
│   ├── Config/                 # Configurações
│   │   └── Config.php          # Carrega .env e constantes
│   ├── Controllers/            # Controllers MVC
│   │   ├── BaseController.php  # Controller base abstrato
│   │   ├── HomeController.php
│   │   ├── GameController.php
│   │   ├── SearchController.php
│   │   ├── GenreController.php
│   │   └── FavoritesController.php
│   ├── Core/                   # Componentes core
│   │   └── Router.php          # Roteador simples
│   ├── Services/               # Serviços
│   │   └── RawgApiService.php  # Cliente API RAWG
│   └── Views/                  # Templates
│       ├── layouts/            # Layout principal
│       ├── partials/           # Componentes reutilizáveis
│       ├── home/               # Views da home
│       ├── game/               # Views do jogo
│       ├── search/             # Views de busca
│       ├── genre/              # Views de gêneros
│       ├── favorites/          # Views de favoritos
│       └── errors/             # Páginas de erro
├── 📂 public/                  # Assets públicos
│   └── assets/
│       ├── css/style.css       # Estilos customizados
│       ├── js/app.js           # JavaScript principal
│       └── images/             # Imagens
├── 📄 index.php                # Entry point (Front Controller)
├── 📄 composer.json            # Configuração Composer
├── 📄 manifest.json            # PWA Manifest
└── 📄 .env.example             # Template de configuração
```

## ✨ Funcionalidades

| Feature | Descrição |
|---------|-----------|
| **Catálogo de Jogos** | Navegue por milhares de jogos com paginação |
| **Detalhes Completos** | Screenshots, avaliações, conquistas, DLCs |
| **Busca Inteligente** | Pesquise com histórico de buscas |
| **Sistema de Favoritos** | Salve jogos (localStorage) |
| **Filtro por Gênero** | Explore por categoria |
| **Tema Dark/Light** | Alternância com persistência |
| **Compartilhamento** | Facebook, Twitter, WhatsApp |
| **PWA** | Instalável como app |

## 🚀 Tecnologias

### Backend
- **PHP 8.0+** com tipagem estrita
- **PSR-4** autoloading
- **PSR-12** coding style
- **cURL** para requisições HTTP
- **MVC** architecture pattern

### Frontend
- **Bootstrap 5.3** framework CSS
- **Bootstrap Icons** iconografia
- **Inter** tipografia (Google Fonts)
- **JavaScript ES6+** módulos

### PWA
- **Service Worker** para cache
- **Manifest.json** para instalação

## 📦 Instalação

### Pré-requisitos

- PHP 8.0+
- Servidor web (Apache/Nginx)
- cURL extension

### Passos

1. **Clone o repositório**
   ```bash
   git clone https://github.com/AndersonC96/RAWG_v2.git
   cd RAWG_v2
   ```

2. **Configure a API Key**
   ```bash
   cp .env.example .env
   ```
   Edite `.env`:
   ```
   RAWG_API_KEY=sua_api_key_aqui
   ```
   
   > Obtenha sua key em [rawg.io/apidocs](https://rawg.io/apidocs)

3. **Configure o servidor**
   - XAMPP: Coloque em `htdocs/RAWG_v2`
   - Ou use PHP built-in:
     ```bash
     php -S localhost:8080
     ```

4. **Acesse**
   ```
   http://localhost/RAWG_v2
   ```

## 📁 Padrões Utilizados

### PSR-4 Autoloading
```php
namespace App\Controllers;

class HomeController extends BaseController
{
    public function index(): void { }
}
```

### PSR-12 Coding Style
- `declare(strict_types=1)` em todos os arquivos
- Tipagem de parâmetros e retorno
- PHPDoc completo

### MVC Pattern
- **Model**: Representação de dados (API responses)
- **View**: Templates PHP com Bootstrap
- **Controller**: Lógica de negócio

## 🔧 Configuração

| Variável | Descrição |
|----------|-----------|
| `RAWG_API_KEY` | Chave API RAWG (obrigatório) |
| `APP_DEBUG` | Modo debug (opcional) |

## 📝 Changelog

### v2.0.0 (2026-01)
- ✨ Refatoração completa com MVC
- 📦 PSR-4 autoloading
- 🎨 Bootstrap 5 integration
- 🔒 API key em `.env`
- ⭐ Sistema de favoritos
- 🌙 Toggle dark/light mode
- 📱 PWA com Service Worker

### v1.0.0
- Release inicial

## 📄 Licença

MIT License - veja [LICENSE](LICENSE)

---

<div align="center">

**Desenvolvido por [Anderson Cavalcante](https://www.linkedin.com/in/andersoncavalcante96)**

</div>
