<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LacNote - Novo Cadastro</title>
    <link rel="stylesheet" href="clac.css">
</head>
<body>

<?php
include("conexão.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nomeMatriz = $_POST["idMatriz"];
    $data = $_POST["data"];
    $turno = $_POST["turno"];
    $litros = $_POST["litros"];
    $hoje = date('Y-m-d');

    if ($data > $hoje) {
        echo "A data de lactação não pode ser no futuro!";
        exit;
    }

    if (empty($nomeMatriz) || empty($data) || empty($litros)) {
        echo "<p> Preencha todos os campos obrigatórios.</p>";
    } else {

        $sql = "SELECT idAnimal from animal where nome = '$nomeMatriz' ";
        $idMatriz = mysqli_query($conn,$sql);

        if(mysqli_num_rows($idMatriz)>0){

            $idMatrizFetch = mysqli_fetch_array($idMatriz);

            $result=$idMatrizFetch['idAnimal'];

            $sql = "INSERT INTO lactacao (idMatriz,data, turno, litros)
                    VALUES ( '$result','$data', '$turno', '$litros')";

            if ($conn->query($sql) === TRUE) {
                echo "Lactação registrada com sucesso!";
            } else {
                echo "<p> Erro ao registrar lactação: " . $conn->error . "</p>";
            }

        }

        else{
             echo "Animal não encontrado!";
        }
        
    }

    $conn->close();
}

?>

<div class="container">
    <div class="topo">
        <div class="logo-container">
            <img src="imagens/logolac.png" class="logo">
        </div>
    </div>

    <h2 class="subtitulo">Produção de Leite - Cadastro</h2>

    <form method="POST" action="">
        <input type="text" name="idMatriz" placeholder="Animal" required>
        <input type="text" name="litros" placeholder="Litros" required>
        <input type="date" name="data" placeholder="Data" required>
        <div>
                <label for="turno">Turno:</label>
                <select name="turno" required>
                    <option value="">Selecione...</option>
                    <option value="manha">Manhã</option>
                    <option value="tarde">Tarde</option>
                    <option value="noite">Noite</option>
                </select>
            </div>

        <button type="submit" class="botao">SALVAR</button>

        <button class="botoesVoltar"><a href="../main/index.html">Voltar</a></button>
    </form>
</div>

</body>
</html>
