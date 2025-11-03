
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>LacNote</title>
    <link rel="stylesheet" href="conan.css">
</head>
<body>
  <div class="topo">
    <div class="logo-container">
      <img src="../../assets/images/logolac.png" class="logo" alt="Logo">
    </div>
  </div>

    <?php
    include('db_connect.php');

    $layout = "busca";
    $animal = null;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nome = $_POST['nome'] ?? '';

        if (!empty($nome)) {
            $sql = "SELECT * FROM animal WHERE nome = '$nome'";
            $resultado = $conn->query($sql);

            if ($resultado->num_rows > 0) {
                $animal = $resultado->fetch_assoc();
                $layout = "resultado";
            } else {
                echo "<p style='text-align:center; color:red;'>Animal não encontrado.</p>";
            }
        }
    }
    ?>

  <?php if ($layout == "busca"): ?>
  <!-- Tela inicial -->
  <div class="container">
    <div class="conteudo">
      <form method="POST">
        <input type="search" name="nome" placeholder="Buscar animal..." required>
        <div class="botoes">
          <button type="submit" class="btn">Buscar</button>
          <a href="../main/index.html" class="btn">Voltar</a>
        </div>
      </form>
    </div>
  </div>

  <?php elseif ($layout == "resultado" && $animal): ?>
  <!-- Tela de resultado -->
  <div class="container">
    <div class="conteudo">
      <input type="text" value="<?= htmlspecialchars($animal['nome']) ?>" readonly>
      <input type="date" value="<?= htmlspecialchars($animal['dataNascimento']) ?>" readonly>
      <input type="text" value="<?= htmlspecialchars($animal['nomePai']) ?>" readonly>
      <input type="text" value="<?= htmlspecialchars($animal['nomeMae']) ?>" readonly>
      <div class="botoes">
        <a href="busca_animal.php" class="btn">Voltar</a>
      </div>
    </div>
  </div>
  <?php endif; ?>

</body>
</html>