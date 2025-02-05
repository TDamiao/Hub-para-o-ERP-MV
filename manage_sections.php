<?php
// manage_sections.php

// Conecta ao banco de dados SQLite
try {
    $db = new PDO('sqlite:links.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}

// Processa a exclusão (caso o parâmetro "delete" esteja definido na URL)
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $db->prepare("DELETE FROM sections WHERE id = ?");
    $stmt->execute([$id]);
    // Redireciona para evitar reenvio de dados
    header("Location: manage_sections.php");
    exit;
}

// Busca todas as seções ordenadas pela posição
$stmt = $db->prepare("SELECT * FROM sections ORDER BY position");
$stmt->execute();
$sections = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gerenciador de Seções</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome 6 CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- Estilos personalizados (opcional) -->
  <style>
    body {
      background-color: #f8f9fa;
    }
    .table th, .table td {
      vertical-align: middle;
    }
  </style>
</head>
<body>
  <!-- Navbar simples -->
  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
      <a class="navbar-brand" href="index.php">INOVA</a>
      <div class="collapse navbar-collapse">
        <ul class="navbar-nav ms-auto">
            <li class="nav-item">
            <a class="nav-link" href="manage_links.php">
              <i class="fa-solid fa-arrow-left"></i> Voltar
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Conteúdo principal -->
  <div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h1>Gerenciador de Seções</h1>
      <a href="insert_section.php" class="btn btn-success">
        <i class="fa-solid fa-plus"></i> Adicionar Seção
      </a>
    </div>

    <div class="table-responsive">
      <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark">
          <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Descrição</th>
            <th>Tipo</th>
            <th>Posição</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <?php if(count($sections) > 0): ?>
            <?php foreach ($sections as $section): ?>
              <tr>
                <td><?php echo htmlspecialchars($section['id']); ?></td>
                <td><?php echo htmlspecialchars($section['name']); ?></td>
                <td><?php echo htmlspecialchars($section['description']); ?></td>
                <td><?php echo htmlspecialchars($section['type']); ?></td>
                <td><?php echo htmlspecialchars($section['position']); ?></td>
                <td>
                  <a href="edit_section.php?id=<?php echo $section['id']; ?>" class="btn btn-sm btn-primary">
                    <i class="fa-solid fa-edit"></i> Editar
                  </a>
                  <a href="manage_sections.php?delete=<?php echo $section['id']; ?>" class="btn btn-sm btn-danger" 
                     onclick="return confirm('Tem certeza que deseja excluir esta seção?')">
                    <i class="fa-solid fa-trash"></i> Excluir
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="6" class="text-center">Nenhuma seção encontrada.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Bootstrap 5 JS (inclui Popper) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
