<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Dados do Funcionário</title>
    
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
            --label-color: #374151;
            --border-color: #d1d5db;
            --focus-ring: rgba(79, 70, 229, 0.25);
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
            max-width: 650px;
            padding: 32px;
        }

        h2 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-color);
            margin-bottom: 6px;
            text-align: center;
        }

        .subtitle {
            font-size: 0.875rem;
            color: var(--subtitle-color);
            text-align: center;
            margin-bottom: 24px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .col-span-2 {
            grid-column: span 2;
        }

        label {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--label-color);
            margin-bottom: 6px;
        }

        input {
            width: 100%;
            padding: 10px 14px;
            font-size: 0.95rem;
            font-family: inherit;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            outline: none;
            transition: all 0.2s ease-in-out;
            background-color: #fff;
        }

        input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px var(--focus-ring);
        }

        button, .btn {
            display: inline-block;
            width: 100%;
            padding: 12px;
            background-color: var(--primary-color);
            color: #ffffff;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            transition: background-color 0.2s ease-in-out, transform 0.1s ease;
            margin-top: 24px;
        }

        button:hover, .btn:hover {
            background-color: var(--primary-hover);
        }

        button:active, .btn:active {
            transform: scale(0.99);
        }

        .alert-error {
            background-color: var(--error-bg);
            color: var(--error-color);
            border: 1px solid #fecaca;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 16px;
        }

        @media (max-width: 600px) {
            .form-grid {
                grid-template-columns: 1fr;
            }

            .col-span-2 {
                grid-column: span 1;
            }

            .container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <?php
        $conexao = new mysqli('localhost', 'root', 'Home@spSENAI2025!', 'Empresa');

        if ($conexao->connect_error) {
            die("<div class='alert-error'>Erro ao conectar com o banco de dados.</div>");
        }

        $cpf = $_POST['cpf'] ?? '';

        // Utilizando Prepared Statement para maior segurança
        $stmt = $conexao->prepare("SELECT * FROM Funcionarios WHERE cpf = ?");
        $stmt->bind_param("s", $cpf);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado && $resultado->num_rows > 0) {
            $Funcionarios = $resultado->fetch_assoc();
        ?>

            <h2>Alterar Dados</h2>
            <p class="subtitle">Altere as informações necessárias e grave as alterações.</p>

            <form action="salvar_alteracao.php" method="POST">
                <!-- Mantém o CPF original como referência para a query de UPDATE -->
                <input type="hidden" name="cpf_original" value="<?php echo htmlspecialchars($Funcionarios['cpf']); ?>">

                <div class="form-grid">
                    <div class="form-group col-span-2">
                        <label for="nome">Nome</label>
                        <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($Funcionarios['nome']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="matricula">Matrícula</label>
                        <input type="text" id="matricula" name="matricula" value="<?php echo htmlspecialchars($Funcionarios['matricula']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="funcao">Função</label>
                        <input type="text" id="funcao" name="funcao" value="<?php echo htmlspecialchars($Funcionarios['funcao']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="departamento">Departamento</label>
                        <input type="text" id="departamento" name="departamento" value="<?php echo htmlspecialchars($Funcionarios['departamento']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="idade">Idade</label>
                        <input type="number" id="idade" name="idade" value="<?php echo htmlspecialchars($Funcionarios['idade']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="cpf">CPF</label>
                        <input type="text" id="cpf" name="cpf" value="<?php echo htmlspecialchars($Funcionarios['cpf']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="rg">RG</label>
                        <input type="text" id="rg" name="rg" value="<?php echo htmlspecialchars($Funcionarios['rg']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="salario">Salário</label>
                        <input type="text" id="salario" name="salario" value="<?php echo htmlspecialchars($Funcionarios['salario']); ?>" required>
                    </div>

                    <div class="form-group col-span-2">
                        <label for="endereco">Endereço</label>
                        <input type="text" id="endereco" name="endereco" value="<?php echo htmlspecialchars($Funcionarios['endereco']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="uf">UF</label>
                        <input type="text" id="uf" name="uf" value="<?php echo htmlspecialchars($Funcionarios['uf']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="pais">País</label>
                        <input type="text" id="pais" name="pais" value="<?php echo htmlspecialchars($Funcionarios['pais']); ?>" required>
                    </div>
                </div>

                <button type="submit">Gravar Alterações</button>
            </form>

        <?php 
        } else { 
        ?>
            <h2>Atenção</h2>
            <div class="alert-error">
                Funcionário não localizado com o CPF informado.
            </div>
            <a href="buscar.html" class="btn">Voltar à Busca</a>
        <?php 
        } 
        
        $stmt->close();
        $conexao->close();
        ?>
    </div>

</body>
</html>