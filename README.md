
# Documentação do Projeto

Este repositório contém uma série de arquivos HTML e PHP que fazem parte de um sistema de gerenciamento de conteúdo visual e de links.

## Arquivos

### paleta.html

Este arquivo HTML exibe uma paleta de cores usada em todo o sistema. Utiliza Bootstrap para estilos e Font Awesome para ícones.

**Dependências:**
- Bootstrap 5.3.0
- Font Awesome 6.4.0

**Código de exemplo:**
\```html
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">HUBMV</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="gera_icons.html" title="Gerador de Icons">
            <i class="fa-solid fa-atom"></i>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="paleta.html" title="Paleta">
            <i class="fa-solid fa-palette"></i>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="manage_links.php" title="Gerenciar Links">
            <i class="fa-solid fa-gear fa-lg"></i>
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>
\```

### gera_icons.html

Este arquivo HTML permite criar ícones personalizados com base em parâmetros definidos pelo usuário, como largura, altura, cor de texto, e mais.

**Dependências:**
- Bootstrap 5.3.0
- Font Awesome 6.0.0-beta3

**Código de exemplo:**
\```html
<div class="circle" id="circle"><span style="font-family: Arial, sans-serif;">FPA</span></div>
\```

### Outros Arquivos PHP

Vários arquivos PHP, como `manage_links.php`, `create_db.php`, e `edit_section.php`, são utilizados para gerenciar conteúdo e configurações do sistema.

**Dependências:**
- PHP 7.4 ou superior
