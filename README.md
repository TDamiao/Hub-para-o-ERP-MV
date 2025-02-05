
# Documentação do Projeto

Este repositório contém uma série de arquivos HTML e PHP que fazem parte de um sistema de gerenciamento de conteúdo visual e de links.

## Arquivos

### paleta.html

Este arquivo HTML exibe uma paleta de cores usada em todo o sistema. Utiliza Bootstrap para estilos e Font Awesome para ícones.

**Dependências:**
- Bootstrap 5.3.0
- Font Awesome 6.4.0

**Código de exemplo:**
```html
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
        <li the="nav-item">
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
```

### gera_icons.html

Este arquivo HTML permite criar ícones personalizados com base em parâmetros definidos pelo usuário, como largura, altura, cor de texto, e mais.

**Dependências:**
- Bootstrap 5.3.0
- Font Awesome 6.0.0-beta3

**Código de exemplo:**
```html
<div class="circle" id="circle"><span style="font-family: Arial, sans-serif;">FPA</span></div>
```

### Gerenciamento Dinâmico de Links

O gerenciamento dinâmico de links envolve criar, editar e remover hyperlinks em um sistema ou website de maneira que seja fácil atualizá-los sem a necessidade de alterar manualmente o código HTML. Esse gerenciamento é feito através de uma interface, geralmente um painel de administração, onde os usuários podem inserir novos links, modificar os existentes e excluir os que não são mais necessários.

Esse tipo de sistema é especialmente útil em sites que têm muitos conteúdos ou páginas que precisam frequentemente atualizar suas referências e links externos. Com um gerenciador de links dinâmico, você pode garantir que todos os links estão corretos e atuais, melhorando a experiência do usuário e a eficiência da manutenção do site.

**Dependências:**
- PHP 7.4 ou superior
