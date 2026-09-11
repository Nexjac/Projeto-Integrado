<?php
$conexao = new mysqli('localhost', 'root', 'senha123', 'sistema_db');
$cpf = $_POST['cpf'];

$sql = "SELECT * FROM clientes WHERE cpf = '$cpf'";
$resultado = $conexao->query($sql);

if ($resultado->num_rows > 0) {
    $cliente = $resultado->fetch_assoc();
?>

<form action="salvar_alteracao.php" method="POST">
  <input type="hidden" name="cpf" value="<?php echo $cliente['cpf']; ?>">

  <label>Nome Atual:</label>
  <input type="text" name="nome" value="<?php echo $cliente['nome']; ?>" required>

  <label>E-mail Atual:</label>
  <input type="email" name="email" value="<?php echo $cliente['email']; ?>" required>

  <button type="submit">Gravar Alterações</button>
</form>
<?php } else { echo "Cliente não localizado."; } ?>