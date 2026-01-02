# RAWG_v2 🎮

<div align="center">

![PHP](https://img.shields.io/badge/PHP-8.0+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)
![RAWG API](https://img.shields.io/badge/RAWG-API-667eea?style=for-the-badge)
![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)

**Uma aplicação web moderna para explorar o mundo dos games**

[Demo](#demo) • [Funcionalidades](#-funcionalidades) • [Tecnologias](#-tecnologias) • [Instalação](#-instalação) • [Screenshots](#-screenshots)

</div>

---

## 📖 Sobre

O **RAWG_v2** é uma aplicação web que consome a [API RAWG](https://rawg.io/apidocs) para fornecer informações detalhadas sobre jogos. Com uma interface moderna e responsiva, você pode:

- 🔍 **Buscar** jogos por nome
- 🏷️ **Filtrar** por gênero
- ⭐ **Salvar** seus jogos favoritos
- 📊 **Visualizar** avaliações e estatísticas
- 🖼️ **Explorar** screenshots e trailers

## ✨ Funcionalidades

| Feature | Descrição |
|---------|-----------|
| **Busca Inteligente** | Pesquise jogos com histórico de buscas recentes |
| **Sistema de Favoritos** | Salve seus jogos preferidos (localStorage) |
| **Tema Dark/Light** | Alternância de tema com persistência |
| **Design Responsivo** | Interface adaptável para todos os dispositivos |
| **Glassmorphism UI** | Design moderno com efeitos visuais premium |
| **Lazy Loading** | Carregamento otimizado de imagens |
| **PWA Ready** | Instalável como aplicativo |

## 🚀 Tecnologias

### Backend
- **PHP 8.0+** - Linguagem server-side
- **cURL** - Requisições HTTP otimizadas
- **MVC Pattern** - Arquitetura organizada

### Frontend
- **CSS Custom Properties** - Sistema de design tokens
- **Glassmorphism** - Efeitos modernos de UI
- **CSS Grid & Flexbox** - Layouts responsivos
- **Material Icons** - Iconografia consistente
- **Inter Font** - Tipografia moderna

### API
- **RAWG.io** - Base de dados com 500.000+ jogos
  - Informações detalhadas
  - Screenshots e trailers
  - Avaliações e metacritic
  - Lojas e plataformas

## 📦 Instalação

### Pré-requisitos

- PHP 8.0 ou superior
- Servidor web (Apache/Nginx)
- Extensão cURL habilitada

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
   Edite o arquivo `.env` e adicione sua chave:
   ```
   RAWG_API_KEY=sua_api_key_aqui
   ```
   
   > 💡 Obtenha sua API key em [rawg.io/apidocs](https://rawg.io/apidocs)

3. **Configure o servidor**
   - Para XAMPP: Coloque na pasta `htdocs`
   - Para Laravel Valet/Herd: Coloque na pasta de sites

4. **Acesse a aplicação**
   ```
   http://localhost/RAWG_v2
   ```

## 📁 Estrutura do Projeto

```
RAWG_v2/
├── 📂 assets/           # Imagens e recursos estáticos
│   └── js/             # JavaScript modules
├── 📂 components/       # Componentes PHP reutilizáveis
│   ├── header.php
│   ├── sidebar.php
│   └── error.php
├── 📂 config/           # Configurações
│   └── config.php      # Env loading e helpers
├── 📂 controllers/      # Lógica de controle
│   ├── homeController.php
│   ├── gameController.php
│   ├── searchController.php
│   └── genresController.php
├── 📂 pages/            # Páginas da aplicação
│   ├── game/
│   ├── search/
│   ├── genres/
│   └── favorites/
├── 📂 services/         # Serviços de API
│   └── api.php         # RAWG API client
├── 📄 index.php         # Entry point
├── 📄 style.css         # Estilos globais
├── 📄 manifest.json     # PWA manifest
└── 📄 .env.example      # Template de configuração
```

## 🎨 Screenshots

<div align="center">

### 🏠 Home Page
> Design moderno com hero section e grid de jogos

### 🔍 Busca
> Pesquisa com histórico e resultados instantâneos

### 🎮 Detalhes do Jogo
> Informações completas com screenshots, avaliações e lojas

### ⭐ Favoritos
> Seus jogos salvos com visualização rápida

</div>

## 🔧 Variáveis de Ambiente

| Variável | Descrição | Obrigatório |
|----------|-----------|-------------|
| `RAWG_API_KEY` | Chave de acesso à API RAWG | ✅ Sim |

## 🤝 Contribuindo

Contribuições são bem-vindas! Siga os passos:

1. Fork o projeto
2. Crie sua branch (`git checkout -b feature/NovaFeature`)
3. Commit suas mudanças (`git commit -m 'Add: nova feature'`)
4. Push para a branch (`git push origin feature/NovaFeature`)
5. Abra um Pull Request

## 📝 Changelog

### v2.0.0 (2026-01)
- ✨ Redesign completo com glassmorphism
- 🔒 Sistema seguro de API keys com `.env`
- ⭐ Sistema de favoritos com localStorage
- 🌙 Toggle dark/light mode
- 📱 PWA support com manifest.json
- 🚀 Otimizações de performance

### v1.0.0
- Initial release

## 📄 Licença

Este projeto está sob a licença MIT. Veja o arquivo [LICENSE](LICENSE) para mais detalhes.

---

<div align="center">

**Desenvolvido por [Anderson](https://www.linkedin.com/in/andersoncavalcante96)**

⭐ Se este projeto te ajudou, considere dar uma estrela!

</div>
