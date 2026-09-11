<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Funcionário</title>
    
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
            --focus-ring: rgba(79, 70, 229, 0.25);
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
            align-items: flex-start;
            min-height: 100vh;
            padding: 40px 20px;
        }

        .container {
            background-color: var(--card-bg);
            border-radius: 12px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 1100px;
            padding: 32px;
        }

        h2 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 20px;
            text-align: center;
        }

        /* Formulário de Busca Inline */
        .search-form {
            display: flex;
            gap: 12px;
            margin-bottom: 30px;
        }

        .search-form input[type="text"] {
            flex: 1;
            padding: 12px 16px;
            font-size: 0.95rem;
            font-family: inherit;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            outline: none;
            transition: all 0.2s ease-in-out;
        }

        .search-form input[type="text"]:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px var(--focus-ring);
        }

        .search-form button {
            padding: 12px 24px;
            background-color: var(--primary-color);
            color: #ffffff;
            border: none;
            border-radius: 6px;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s ease-in-out;
            white-space: nowrap;
        }

        .search-form button:hover {
            background-color: var(--primary-hover);
        }

        .results-header {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 16px;
            padding-bottom: 8px;
            border-bottom: 2px solid var(--bg-color);
        }

        /* Tabela Responsiva */
        .table-responsive {
            width: 100%;
            overflow-x: auto;
            border-radius: 8px;
            border: 1px solid var(--border-color);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 0.875rem;
        }

        th {
            background-color: #f9fafb;
            color: var(--subtitle-color);
            font-weight: 600;
            padding: 12px 16px;
            border-bottom: 1px solid var(--border-color);
            white-space: nowrap;
        }

        td {
            padding: 12px 16px;
            border-bottom: 1px solid var(--border-color);
            white-space: nowrap;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover {
            background-color: #f9fafb;
        }

        /* Alerta de Vazio */
        .alert-empty {
            padding: 16px;
            background-color: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
            border-radius: 6px;
            text-align: center;
            font-size: 0.95rem;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Consultar Funcionário</h2>

        <form method="GET" action="consulta.php" class="search-form">
            <input 
                type="text" 
                name="nome" 
                placeholder="Digite o nome do funcionário..." 
                value="<?php echo isset($_GET['nome']) ? htmlspecialchars($_GET['nome']) : ''; ?>"
                required
            >
            <button type="submit">Buscar</button>
        </form>

        <?php if (isset($_GET['nome'])): ?>
            <?php
                $busca = $_GET['nome'];
                $conexao = new mysqli('localhost', 'root', 'Home@spSENAI2025!', 'Empresa');

                if ($conexao->connect_error) {
                    die("<div class='alert-empty'>Erro na conexão com o banco de dados.</div>");
                }

                // Utilizando Prepared Statement para evitar SQL Injection
                $stmt = $conexao->prepare("SELECT * FROM Funcionarios WHERE nome LIKE ?");
                $param = "%" . $busca . "%";
                $stmt->bind_param("s", $param);
                $stmt->execute();
                $resultado = $stmt->get_result();
            ?>

            <h3 class="results-header">Resultados Encontrados</h3>

            <?php if ($resultado->num_rows > 0): ?>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Matrícula</th>
                                <th>Função</th>
                                <th>Departamento</th>
                                <th>Idade</th>
                                <th>CPF</th>
                                <th>RG</th>
                                <th>Salário</th>
                                <th>Endereço</th>
                                <th>UF</th>
                                <th>País</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($linha = $resultado->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($linha['idFunc']); ?></td>
                                    <td><strong><?php echo htmlspecialchars($linha['nome']); ?></strong></td>
                                    <td><?php echo htmlspecialchars($linha['matricula']); ?></td>
                                    <td><?php echo htmlspecialchars($linha['funcao']); ?></td>
                                    <td><?php echo htmlspecialchars($linha['departamento']); ?></td>
                                    <td><?php echo htmlspecialchars($linha['idade']); ?></td>
                                    <td><?php echo htmlspecialchars($linha['cpf']); ?></td>
                                    <td><?php echo htmlspecialchars($linha['rg']); ?></td>
                                    <td>R$ <?php echo htmlspecialchars($linha['salario']); ?></td>
                                    <td><?php echo htmlspecialchars($linha['endereco']); ?></td>
                                    <td><?php echo htmlspecialchars($linha['uf']); ?></td>
                                    <td><?php echo htmlspecialchars($linha['pais']); ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert-empty">Nenhum funcionário encontrado.</div>
            <?php endif; ?>

            <?php 
                $stmt->close();
                $conexao->close(); 
            ?>
        <?php endif; ?>
    </div>

</body>
</html>