<?php
// edit.php

// Conecta ao banco de dados SQLite
try {
    $db = new PDO('sqlite:links.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}

$mensagem = "";

// Verifica se o parâmetro id foi informado
if (!isset($_GET['id'])) {
    die("ID do link não especificado.");
}

$link_id = intval($_GET['id']);

// Busca os dados do link a ser editado
$stmt = $db->prepare("SELECT * FROM links WHERE id = ?");
$stmt->execute([$link_id]);
$linkData = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$linkData) {
    die("Link não encontrado.");
}

// Processa a exclusão do link, se solicitado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $stmtDelete = $db->prepare("DELETE FROM links WHERE id = ?");
    if ($stmtDelete->execute([$link_id])) {
        $mensagem = "Link excluído com sucesso!";
        header("Location: manage_links.php");
        exit;
    } else {
        $mensagem = "Erro ao excluir o link.";
    }
}

// Processa o envio do formulário de atualização
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['action'])) {
    $section_id = isset($_POST['section_id']) ? intval($_POST['section_id']) : null;
    $name       = isset($_POST['name']) ? trim($_POST['name']) : "";
    $url        = isset($_POST['url']) ? trim($_POST['url']) : "";
    $target     = isset($_POST['target']) ? trim($_POST['target']) : "_blank";
    $active     = isset($_POST['active']) ? 1 : 0;
    $position   = isset($_POST['position']) && $_POST['position'] !== "" ? intval($_POST['position']) : null;

    if ($section_id && $name && $url) {
        $stmtUpdate = $db->prepare("UPDATE links SET section_id = ?, name = ?, url = ?, target = ?, active = ?, position = ? WHERE id = ?");
        if ($stmtUpdate->execute([$section_id, $name, $url, $target, $active, $position, $link_id])) {
            $mensagem = "Link atualizado com sucesso!";
            $stmt = $db->prepare("SELECT * FROM links WHERE id = ?");
            $stmt->execute([$link_id]);
            $linkData = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $mensagem = "Erro ao atualizar o link.";
        }
    } else {
        $mensagem = "Por favor, preencha os campos obrigatórios (Seção, Nome e URL).";
    }
}

// Consulta as seções para preencher o select do formulário
$stmt_sections = $db->prepare("SELECT id, name FROM sections ORDER BY name");
$stmt_sections->execute();
$sections = $stmt_sections->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Link</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php">HUBMV</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="manage_links.php"><i class="fa-solid fa-arrow-left"></i> Voltar</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="container my-5">
    <h1 class="mb-4">Editar Link</h1>
    <?php if ($mensagem): ?>
      <div class="alert alert-info"><?php echo htmlspecialchars($mensagem); ?></div>
    <?php endif; ?>
    <form method="POST" action="edit.php?id=<?php echo $link_id; ?>">
      <div class="mb-3">
        <label for="section_id" class="form-label">Seção</label>
        <select name="section_id" id="section_id" class="form-select" required>
          <option value="">Selecione uma seção</option>
          <?php foreach ($sections as $sec): ?>
            <option value="<?php echo $sec['id']; ?>" <?php echo ($sec['id'] == $linkData['section_id']) ? 'selected' : ''; ?>>
              <?php echo htmlspecialchars($sec['name']); ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="mb-3">
        <label for="name" class="form-label">Nome do Link</label>
        <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($linkData['name']); ?>" required>
      </div>
      <div class="mb-3">
        <label for="url" class="form-label">URL</label>
        <input type="url" class="form-control" id="url" name="url" value="<?php echo htmlspecialchars($linkData['url']); ?>" required>
      </div>
      <div class="mb-3">
        <label for="target" class="form-label">Target</label>
        <select name="target" id="target" class="form-select">
          <option value="_blank" <?php echo ($linkData['target'] == '_blank') ? 'selected' : ''; ?>>_blank</option>
          <option value="_self" <?php echo ($linkData['target'] == '_self') ? 'selected' : ''; ?>>_self</option>
          <option value="_parent" <?php echo ($linkData['target'] == '_parent') ? 'selected' : ''; ?>>_parent</option>
          <option value="_top" <?php echo ($linkData['target'] == '_top') ? 'selected' : ''; ?>>_top</option>
        </select>
      </div>
      <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="active" name="active" <?php echo ($linkData['active'] == 1) ? 'checked' : ''; ?>>
        <label class="form-check-label" for="active">Ativo</label>
      </div>
      <div class="mb-3">
        <label for="position" class="form-label">Posição (opcional)</label>
        <input type="number" class="form-control" id="position" name="position" value="<?php echo htmlspecialchars($linkData['position']); ?>">
      </div>
      <button type="submit" class="btn btn-primary">Atualizar Link</button>
      <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">Excluir Link</button>
    </form>
  </div>
  <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteModalLabel">Confirmar Exclusão</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">Tem certeza de que deseja excluir este link? Esta ação não pode ser desfeita.</div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <form method="POST" action="edit.php?id=<?php echo $link_id; ?>">
            <input type="hidden" name="action" value="delete">
            <button type="submit" class="btn btn-danger">Excluir</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>