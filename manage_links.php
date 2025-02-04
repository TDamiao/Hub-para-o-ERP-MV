<?php
// manage_links.php

// Conecta ao banco de dados SQLite
try {
    $db = new PDO('sqlite:links.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}

// Consulta para buscar todos os links com o nome da seção associada
$query = "SELECT links.id, links.name, links.url, sections.name as section_name 
          FROM links 
          LEFT JOIN sections ON links.section_id = sections.id
          ORDER BY sections.name, links.position";
$stmt = $db->query($query);
$links = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gerenciar Links</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome 6 CSS (atualizado) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- CSS Personalizado -->
  <link rel="stylesheet" type="text/css" href="./src/css/estilo.css">
</head>
<body>
  <!-- Navbar com logomarca e ícone de engrenagem -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <!-- Ao clicar em "INOVA", o usuário volta para a página principal -->
      <a class="navbar-brand" href="index.php">INOVA</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
              aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <!-- Ícone de engrenagem (opcional, pois já estamos na página de gerenciamento) -->
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
                 <!-- Link para Inserir Novo Link -->
                 <li class="nav-item">
            <a class="nav-link" href="insert.php" title="Adicionar Novo Link">
              <i class="fa-solid fa-plus"></i> Adicionar
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
  
  <div class="container my-5">
    <h1 class="mb-4">Gerenciar Links</h1>
    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Seção</th>
          <th>Nome</th>
          <th>URL</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($links as $link): ?>
          <tr>
            <td><?php echo $link['id']; ?></td>
            <td><?php echo htmlspecialchars($link['section_name']); ?></td>
            <td><?php echo htmlspecialchars($link['name']); ?></td>
            <td><?php echo htmlspecialchars($link['url']); ?></td>
            <td>
              <!-- Link de edição que passa o id na URL -->
              <a href="edit.php?id=<?php echo $link['id']; ?>" class="btn btn-sm btn-primary">Editar</a>
              <!-- Você também pode adicionar um botão de exclusão, se desejar -->
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <!-- Link para inserir um novo link -->
    <a href="insert.php" class="btn btn-success">Inserir Novo Link</a>
  </div>
  
  <!-- Bootstrap 5 JS (Bundle que inclui Popper) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
