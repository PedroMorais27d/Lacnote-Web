<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>LacNote</title>
  <link rel="stylesheet" href="conlac.css">
</head>

<body>

  <?php
  include('conexão.php'); // Conexão com o banco

  $animal = $_Post['animal'];
  $diaria = ['manha' => 0, 'tarde' => 0, 'noite' => 0];
  $semanal = 0;
  $mensal = 0;
  $anual = 0;



  $sql = "SELECT idAnimal from animal where nome = '$animal' ";
          $idMatriz = mysqli_query($conn,$sql);

    if(mysqli_num_rows($idMatriz)>0){

      $idMatrizFetch = mysqli_fetch_array($idMatriz);

      $result=$idMatrizFetch['idAnimal'];
      if (!empty($result)) {
          // --- PRODUÇÃO DIÁRIA ---
          $sql_diaria = "
              SELECT 
                  SUM(CASE WHEN turno = 'manha' THEN litros ELSE 0 END) AS manha,
                  SUM(CASE WHEN turno = 'tarde' THEN litros ELSE 0 END) AS tarde,
                  SUM(CASE WHEN turno = 'noite' THEN litros ELSE 0 END) AS noite
              FROM lactacao
              WHERE idMatriz = '$result'
              AND data = CURDATE();
          ";
          $res_diaria = $conn->query($sql_diaria);
          if ($res_diaria && $res_diaria->num_rows > 0) {
              $diaria = $res_diaria->fetch_assoc();
          }

          // --- PRODUÇÃO SEMANAL ---
          $sql_semanal = "
              SELECT SUM(litros) AS total
              FROM lactacao
              WHERE idMatriz = '$result'
              AND data >= CURDATE() - INTERVAL 7 DAY;
          ";
          $res_semanal = $conn->query($sql_semanal);
          $semanal = $res_semanal->fetch_assoc()['total'] ?? 0;

          // --- PRODUÇÃO MENSAL ---
          $sql_mensal = "
              SELECT SUM(litros) AS total
              FROM lactacao
              WHERE idMatriz = '$result'
              AND data >= CURDATE() - INTERVAL 30 DAY;
          ";
          $res_mensal = $conn->query($sql_mensal);
          $mensal = $res_mensal->fetch_assoc()['total'] ?? 0;

          // --- PRODUÇÃO ANUAL ---
          $sql_anual = "
              SELECT SUM(litros) AS total
              FROM lactacao
              WHERE idMatriz = '$result'
              AND data >= CURDATE() - INTERVAL 365 DAY;
          ";
          $res_anual = $conn->query($sql_anual);
          $anual = $res_anual->fetch_assoc()['total'] ?? 0;
      }
  }
  ?>

  <!-- CONSULTAS -->
  <div id="producao-consultas" class="container ativo">
    <div class="topo">
      <div class="logo-container">
        <img src="../../assets/images/logolac.png" alt="Logo LacNote" class="logo">
      </div>
    </div>

    <h2 class="subtitulo">Produção de Leite - Consultas</h2>

    <form method="POST" action="">
      <input id="animal" name="animal" type="search" placeholder="Buscar animal..." value="<?= htmlspecialchars($animal) ?>" required />
      <button class="btn" type="submit">Buscar</button>
    </form>

    <?php if (!empty($animal)): ?>
    <h3>Resultados para: <strong><?= htmlspecialchars($animal) ?></strong></h3>
    <?php endif; ?>

    <div>
      <button class="btn" onclick="mostrarTela('producao-diaria')">Diário</button>
      <button class="btn" onclick="mostrarTela('producao-semanal')">Semanal</button>
      <button class="btn" onclick="mostrarTela('producao-mensal')">Mensal</button>
      <button class="btn" onclick="mostrarTela('producao-anual')">Anual</button>   
    </div>

    <center> 
      <button class="btn"><a href="../main/index.html">Voltar</a></button>
    </center> 
  </div>

  <!-- DIÁRIA -->
  <div id="producao-diaria" class="container">
    <h2 class="subtitulo">Produção de Leite - Por Turno</h2>
    <label>Manhã:</label>
    <input type="text" value="<?= $diaria['manha'] ?> Litros"><br>
    <label>Tarde:</label>
    <input type="text" value="<?= $diaria['tarde'] ?> Litros"><br>
    <label>Noite:</label>
    <input type="text" value="<?= $diaria['noite'] ?> Litros"><br><br>
    <button class="btn" onclick="mostrarTela('producao-consultas')">Voltar</button>
  </div>

  <!-- SEMANAL -->
  <div id="producao-semanal" class="container">
    <h2 class="subtitulo">Produção de Leite - Semanal</h2>
    <label>Total (últimos 7 dias):</label>
    <input type="text" value="<?= $semanal ?> Litros"><br><br>
    <button class="btn" onclick="mostrarTela('producao-consultas')">Voltar</button>
  </div>

  <!-- MENSAL -->
  <div id="producao-mensal" class="container">
    <h2 class="subtitulo">Produção de Leite - Mensal</h2>
    <label>Total (últimos 30 dias):</label>
    <input type="text" value="<?= $mensal ?> Litros"><br><br>
    <button class="btn" onclick="mostrarTela('producao-consultas')">Voltar</button>
  </div>

  <!-- ANUAL -->
  <div id="producao-anual" class="container">
    <h2 class="subtitulo">Produção de Leite - Anual</h2>
    <label>Total (últimos 365 dias):</label>
    <input type="text" value="<?= $anual ?> Litros"><br><br>
    <button class="btn" onclick="mostrarTela('producao-consultas')">Voltar</button>
  </div>

  <!-- SCRIPT -->
  <script>
    function mostrarTela(id) {
      document.querySelectorAll('.container').forEach(div => {
        div.classList.remove('ativo');
      });
      document.getElementById(id).classList.add('ativo');
    }
  </script>
</body>
</html>