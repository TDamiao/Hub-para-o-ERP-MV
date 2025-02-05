<?php
// edit_section.php

// Conecta ao banco de dados SQLite
try {
    $db = new PDO('sqlite:links.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}

// Verifica se o parâmetro 'id' foi passado na URL
if (!isset($_GET['id'])) {
    die("ID não informado.");
}

$id = intval($_GET['id']);

// Busca a seção com o ID informado
$stmt = $db->prepare("SELECT * FROM sections WHERE id = ?");
$stmt->execute([$id]);
$section = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$section) {
    die("Seção não encontrada.");
}

// Processa o formulário de edição
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recupera os dados enviados pelo formulário
    $name        = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';
    $type        = $_POST['type'] ?? '';
    $position    = $_POST['position'] ?? '';

    // Validação básica: nome, tipo e posição são obrigatórios
    if (empty($name) || empty($type) || empty($position)) {
        $error = "Por favor, preencha todos os campos obrigatórios.";
    } else {
        // Atualiza a seção na tabela 'sections'
        $stmt = $db->prepare("UPDATE sections SET name = ?, description = ?, type = ?, position = ? WHERE id = ?");
        $stmt->execute([$name, $description, $type, $position, $id]);

        // Após a atualização, redireciona para a página de gerenciamento
        header("Location: manage_sections.php");
        exit;
    }
} else {
    // Se o formulário não foi enviado, utiliza os dados atuais da seção para preencher os campos
    $name        = $section['name'];
    $description = $section['description'];
    $type        = $section['type'];
    $position    = $section['position'];
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Seção</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome 6 CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
  <!-- Navbar simples -->
  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
      <a class="navbar-brand" href="index.php">HUBMV</a>
      <div class="collapse navbar-collapse">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="manage_sections.php">
              <i class="fa-solid fa-arrow-left"></i> Voltar
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Conteúdo principal -->
  <div class="container my-5">
    <div class="card">
      <div class="card-header">
        <h2>Editar Seção</h2>
      </div>
      <div class="card-body">
        <?php if (isset($error)): ?>
          <div class="alert alert-danger">
            <?php echo $error; ?>
          </div>
        <?php endif; ?>
        <form method="POST" action="edit_section.php?id=<?php echo $id; ?>">
          <div class="mb-3">
            <label for="name" class="form-label">Nome <span class="text-danger">*</span></label>
            <input type="text" id="name" name="name" class="form-control" required value="<?php echo htmlspecialchars($name); ?>">
          </div>
          <div class="mb-3">
            <label for="description" class="form-label">Descrição</label>
            <textarea id="description" name="description" class="form-control" rows="3"><?php echo htmlspecialchars($description); ?></textarea>
          </div>
          <div class="mb-3">
            <label for="type" class="form-label">Tipo <span class="text-danger">*</span></label>
            <select id="type" name="type" class="form-select" required>
              <option value="">Selecione</option>
              <option value="mv" <?php echo ($type === 'mv') ? 'selected' : ''; ?>>MV</option>
              <option value="complemento" <?php echo ($type === 'complemento') ? 'selected' : ''; ?>>Complemento</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="position" class="form-label">Posição <span class="text-danger">*</span></label>
            <input type="number" id="position" name="position" class="form-control" required value="<?php echo htmlspecialchars($position); ?>">
          </div>
          <button type="submit" class="btn btn-primary">
            <i class="fa-solid fa-save"></i> Salvar Alterações
          </button>
        </form>
      </div>
    </div>
  </div>

  <!-- Bootstrap 5 JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>