<?php
try {
    // Conecta ou cria o banco de dados "links.db"
    $db = new PDO('sqlite:links.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Cria a tabela de seções (agrupamentos de links)
    $db->exec("CREATE TABLE IF NOT EXISTS sections (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        description TEXT,
        type TEXT,         -- por exemplo, 'mv' ou 'complemento'
        position INTEGER    -- para definir a ordem de exibição
    )");

    // Cria a tabela de links
    $db->exec("CREATE TABLE IF NOT EXISTS links (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        section_id INTEGER,  -- referência à seção a qual o link pertence
        name TEXT NOT NULL,
        url TEXT NOT NULL,
        target TEXT DEFAULT '_blank',
        active INTEGER DEFAULT 1,
        position INTEGER,    -- para definir a ordem de exibição dentro da seção
        FOREIGN KEY (section_id) REFERENCES sections(id)
    )");

    // Insere dados de exemplo nas seções (os grupos de links)
    $db->exec("INSERT INTO sections (name, description, type, position) VALUES
        ('Ambiente Produção', '*Cuidado com os dados', 'mv', 1),
        ('Ambiente Simulação', '*Dados para simulação', 'mv', 2),
        ('Ambiente Treinamento', '*Dados genéricos', 'mv', 3),
        ('Vivace', '*Diagnostico por Imagem', 'complemento', 1),
        ('VALID', '*Assinatura eletrônica', 'complemento', 2),
        ('Painel de Indicadores', '*Paineis de Informações', 'complemento', 3),
        ('Grifols', '*Ocorrências', 'complemento', 4)
    ");

    // Insere dados de exemplo na tabela de links
    // -- Exemplo para "Ambiente Produção" (section_id = 1)
    $db->exec("INSERT INTO links (section_id, name, url, position) VALUES
        (1, 'Soul MV', 'http://soulprd.inovasaudesa.com.br', 1),
        (1, 'Soul MV Integração', 'http://soulprd.inovasaudesa.com.br/integracao', 2),
        (1, 'MV Pep 2.0', 'http://soulprd.inovasaudesa.com.br/mvpep', 3)
    ");
    // Você pode inserir os demais links (para outras seções) conforme necessário...

    echo "Banco de dados criado e dados de exemplo inseridos com sucesso!";
} catch(PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>
