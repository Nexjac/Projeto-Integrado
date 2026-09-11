<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status da Alteração</title>
    
    <!-- Fonte Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #4f46e5;
            --primary-hover: #4338ca;
            --bg-color: #f3f4f6;
            --card-bg: #ffffff;
            --text-color: #1f2937;
            --subtitle-color: #6b7280;
            --border-color: #e5e7eb;
            --success-color: #16a34a;
            --success-bg: #f0fdf4;
            --error-color: #dc2626;
            --error-bg: #fef2f2;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-color);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            background-color: var(--card-bg);
            border-radius: 12px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
            padding: 32px;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 8px 16px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 20px;
        }

        .status-badge.success {
            background-color: var(--success-bg);
            color: var(--success-color);
            border: 1px solid #bbf7d0;
        }

        .status-badge.error {
            background-color: var(--error-bg);
            color: var(--error-color);
            border: 1px solid #fecaca;
        }

        h2 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 8px;
        }

        p.subtitle {
            font-size: 0.9rem;
            color: var(--subtitle-color);
            margin-bottom: 24px;
        }

        /* Grid de Resumo dos Dados */
        .data-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
            background-color: #f9fafb;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            margin-bottom: 28px;
        }

        .data-item {
            display: flex;
            flex-direction: column;
        }

        .data-item.full-width {
            grid-column: span 2;
        }

        .data-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--subtitle-color);
            font-weight: 600;
            margin-bottom: 2px;
        }

        .data-value {
            font-size: 0.95rem;
            font-weight: 500;
            color: var(--text-color);
            word-break: break-word;
        }

        /* Botões de Ação */
        .actions {
            display: flex;
            gap: 12px;
        }

        .btn {
            flex: 1;
            padding: 12px;
            text-align: center;
            text-decoration: none;
            border-radius: 6px;
            font-size: 0.95rem;
            font-weight: 600;
            transition: all 0.2s ease-in-out;
            cursor: pointer;
            border: none;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: #ffffff;
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
        }

        .btn-secondary {
            background-color: #fff;
            color: var(--text-color);
            border: 1px solid var(--border-color);
        }

        .btn-secondary:hover {
            background-color: #f9fafb;
        }

        @media (max-width: 500px) {
            .data-grid {
                grid-template-columns: 1fr;
            }
            .data-item.full-width {
                grid-column: span 1;
            }
            .actions {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Suporta tanto o CPF do form original quanto o cpf_original se disponibilizado
            $cpf_referencia = $_POST['cpf_original'] ?? $_POST['cpf'] ?? '';
            
            $cpf = $_POST['cpf'] ?? '';
            $novo_nome = $_POST['nome'] ?? '';
            $novo_matricula = $_POST['matricula'] ?? '';
            $novo_funcao = $_POST['funcao'] ?? '';
            $novo_departamento = $_POST['departamento'] ?? '';
            $novo_idade = $_POST['idade'] ?? '';
            $novo_rg = $_POST['rg'] ?? '';
            $novo_salario = $_POST['salario'] ?? '';
            $novo_endereco = $_POST['endereco'] ?? '';
            $novo_uf = $_POST['uf'] ?? '';
            $novo_pais = $_POST['pais'] ?? '';

            $conexao = new mysqli('localhost', 'root', 'Home@spSENAI2025!', 'Empresa');

            if ($conexao->connect_error) {
                $sucesso = false;
                $erro_mensagem = "Erro na conexão: " . $conexao->connect_error;
            } else {
                // Utilizando Prepared Statement para atualizar os dados com segurança
                $sql_update = "UPDATE Funcionarios SET
                    nome = ?, 
                    matricula = ?,
                    funcao = ?,
                    departamento = ?, 
                    idade = ?,
                    cpf = ?,
                    rg = ?,
                    salario = ?,
                    endereco = ?,
                    uf = ?,
                    pais = ?
                 WHERE cpf = ?";

                $stmt = $conexao->prepare($sql_update);

                if ($stmt) {
                    $stmt->bind_param(
                        "ssssisssssss", 
                        $novo_nome, 
                        $novo_matricula, 
                        $novo_funcao, 
                        $novo_departamento, 
                        $novo_idade, 
                        $cpf, 
                        $novo_rg, 
                        $novo_salario, 
                        $novo_endereco, 
                        $novo_uf, 
                        $novo_pais, 
                        $cpf_referencia
                    );

                    if ($stmt->execute()) {
                        $sucesso = true;
                    } else {
                        $sucesso = false;
                        $erro_mensagem = $stmt->error;
                    }
                    $stmt->close();
                } else {
                    $sucesso = false;
                    $erro_mensagem = $conexao->error;
                }

                $conexao->close();
            }
        } else {
            header("Location: buscar.html");
            exit();
        }
        ?>

        <?php if ($sucesso): ?>
            <div class="status-badge success">✓ Atualizado</div>
            <h2>Dados Atualizados com Sucesso!</h2>
            <p class="subtitle">Cadastro final registrado no banco de dados.</p>

            <div class="data-grid">
                <div class="data-item full-width">
                    <span class="data-label">Nome Completo</span>
                    <span class="data-value"><?php echo htmlspecialchars($novo_nome); ?></span>
                </div>
                <div class="data-item">
                    <span class="data-label">Matrícula</span>
                    <span class="data-value"><?php echo htmlspecialchars($novo_matricula); ?></span>
                </div>
                <div class="data-item">
                    <span class="data-label">Função</span>
                    <span class="data-value"><?php echo htmlspecialchars($novo_funcao); ?></span>
                </div>
                <div class="data-item">
                    <span class="data-label">Departamento</span>
                    <span class="data-value"><?php echo htmlspecialchars($novo_departamento); ?></span>
                </div>
                <div class="data-item">
                    <span class="data-label">Idade</span>
                    <span class="data-value"><?php echo htmlspecialchars($novo_idade); ?> anos</span>
                </div>
                <div class="data-item">
                    <span class="data-label">CPF</span>
                    <span class="data-value"><?php echo htmlspecialchars($cpf); ?></span>
                </div>
                <div class="data-item">
                    <span class="data-label">RG</span>
                    <span class="data-value"><?php echo htmlspecialchars($novo_rg); ?></span>
                </div>
                <div class="data-item">
                    <span class="data-label">Salário</span>
                    <span class="data-value">R$ <?php echo htmlspecialchars($novo_salario); ?></span>
                </div>
                <div class="data-item full-width">
                    <span class="data-label">Endereço</span>
                    <span class="data-value"><?php echo htmlspecialchars($novo_endereco); ?> - <?php echo htmlspecialchars($novo_uf); ?>, <?php echo htmlspecialchars($novo_pais); ?></span>
                </div>
            </div>

            <div class="actions">
                <a href="buscar.html" class="btn btn-primary">Buscar Outro</a>
                <a href="consulta.php" class="btn btn-secondary">Consultar Lista</a>
            </div>

        <?php else: ?>
            <div class="status-badge error">✕ Erro</div>
            <h2>Erro na Atualização</h2>
            <p class="subtitle">Não foi possível alterar os dados do funcionário.</p>

            <div class="data-grid" style="background-color: var(--error-bg); border-color: #fecaca;">
                <div class="data-item full-width">
                    <span class="data-label" style="color: var(--error-color);">Detalhes do Erro</span>
                    <span class="data-value" style="color: var(--error-color);"><?php echo htmlspecialchars($erro_mensagem); ?></span>
                </div>
            </div>

            <div class="actions">
                <a href="javascript:history.back()" class="btn btn-primary">Voltar e Tentar Novamente</a>
            </div>
        <?php endif; ?>

    </div>

</body>
</html>