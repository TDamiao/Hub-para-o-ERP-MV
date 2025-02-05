<?php
// index.php

// Conecta ao banco de dados SQLite
try {
    $db = new PDO('sqlite:links.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}

// Consulta as seções para "Links MV" (onde type = 'mv')
$stmt = $db->prepare("SELECT * FROM sections WHERE type = 'mv' ORDER BY position");
$stmt->execute();
$sections_mv = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Consulta as seções para "Complementos" (onde type = 'complemento')
$stmt = $db->prepare("SELECT * FROM sections WHERE type = 'complemento' ORDER BY position");
$stmt->execute();
$sections_complemento = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>INOVA</title>
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
      <a class="navbar-brand" href="index.php">HUBMV</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
              aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <!-- Ícone de engrenagem (opcional, pois já estamos na página de gerenciamento) -->
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
                 <!-- Link para Inserir Novo Link -->
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

  <!-- Seção de Links MV -->
  <div class="container-fluid">
    <div class="py-4">
      <section class="container">
        <header class="mb-4">
          <h2 class="text-center">Links</h2>
        </header>
        <div class="row g-4">
          <?php foreach ($sections_mv as $section): ?>
          <div class="col-sm-6 col-md-4 col-12">
            <div class="card shadow h-100">
              <div class="card-body">
                <h3 class="card-title h5"><?php echo htmlspecialchars($section['name']); ?></h3>
                <ul class="list-unstyled">
                  <?php
                  $stmt_links = $db->prepare("SELECT * FROM links WHERE section_id = ? AND active = 1 ORDER BY position");
                  $stmt_links->execute([$section['id']]);
                  $links = $stmt_links->fetchAll(PDO::FETCH_ASSOC);
                  foreach ($links as $link):
                  ?>
                  <li>
                    <a href="<?php echo htmlspecialchars($link['url']); ?>" target="<?php echo htmlspecialchars($link['target']); ?>">
                      <?php echo htmlspecialchars($link['name']); ?>
                    </a>
                  </li>
                  <?php endforeach; ?>
                </ul>
              </div>
              <div class="card-footer text-muted small">
                <?php echo htmlspecialchars($section['description']); ?>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </section>
    </div>
  </div>

  <!-- Seção de Complementos -->
  <div class="container-fluid">
    <div class="py-4">
      <section class="container">
        <header class="mb-4">
          <h2 class="text-center">Complementos</h2>
        </header>
        <div class="row g-4">
          <?php foreach ($sections_complemento as $section): ?>
          <div class="col-sm-6 col-md-3 col-12">
            <div class="card shadow h-100">
              <div class="card-body">
                <h3 class="card-title h5"><?php echo htmlspecialchars($section['name']); ?></h3>
                <ul class="list-unstyled">
                  <?php
                  $stmt_links = $db->prepare("SELECT * FROM links WHERE section_id = ? AND active = 1 ORDER BY position");
                  $stmt_links->execute([$section['id']]);
                  $links = $stmt_links->fetchAll(PDO::FETCH_ASSOC);
                  foreach ($links as $link):
                  ?>
                  <li>
                    <a href="<?php echo htmlspecialchars($link['url']); ?>" target="<?php echo htmlspecialchars($link['target']); ?>">
                      <?php echo htmlspecialchars($link['name']); ?>
                    </a>
                  </li>
                  <?php endforeach; ?>
                </ul>
              </div>
              <div class="card-footer text-muted small">
                <?php echo htmlspecialchars($section['description']); ?>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </section>
    </div>
  </div>

  <!-- Bootstrap 5 JS (inclui Popper) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Script personalizado (se necessário) -->
  <script type="text/javascript" src="./src/js/main.js"></script>
</body>
</html>
