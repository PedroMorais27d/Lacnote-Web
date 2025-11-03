<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LacNote - Novo Cadastro</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php
include('conexão.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = $_POST['nome'];
    $data = $_POST['dataNascimento'];
    $tipo = $_POST["tipoAnimal"];
    $nomePai = $_POST['nomePai'];
    $nomeMae = $_POST['nomeMae'];
    $idPai = $_POST['idPai'];
    $idMae = $_POST['idMae'];

    $sql = "SELECT nome from animal where nome = '$nomeMae' ";
    $Matriz = mysqli_query($conn,$sql);
    $sql = "SELECT nome from animal where nome = '$nomePai' ";
    $Macho = mysqli_query($conn,$sql);
    $sql = "SELECT idAnimal from animal where nome = '$Matriz' ";
    $idMatriz = mysqli_query($conn,$sql);
    $sql = "SELECT idAnimal from animal where nome = '$Macho' ";
    $idMacho = mysqli_query($conn,$sql);
    $hoje = date('Y-m-d');

    if ($data > $hoje) {
        echo "A data de nascimento não pode ser no futuro!";
        exit;
    }

    else:
        if(mysqli_num_rows($Matriz)>0 && mysqli_num_rows($Macho)>0){

            $MatrizFetch = mysqli_fetch_array($Matriz);
            $MachoFetch = mysqli_fetch_array($Macho);
            $idMatrizFetch = mysqli_fetch_array($idMatriz);
            $idMachoFetch = mysqli_fetch_array($idMacho);

            $resultFid=$idMatrizFetch['idAnimal'];
            $resultMid=$idMachoFetch['idAnimal'];
            $resultF=$MatrizFetch['nome'];
            $resultM=$MachoFetch['nome'];

            $sql = "INSERT INTO animal (nome, tipo, dataNascimento, nomePai, nomeMae, idPai, idMae)
            VALUES ('$nome', '$tipo', '$data', '$ResultM', '$ResultF', " .
            ($idPai ? $idPai : "NULL") . ", " . ($idMae ? $idMae : "NULL") . ")";

            if ($conn->query($sql) === TRUE) {
                echo "Animal cadastrado com sucesso!";
            } else {
                echo "Erro ao cadastrar: " . $conn->error;
            }

        }

    else if(mysqli_num_rows($idMatriz)==NULL && mysqli_num_rows($idMacho)==NULL){
         $sql = "INSERT INTO animal (nome, tipo, dataNascimento, nomePai, nomeMae, idPai, idMae)
        VALUES ('$nome', '$tipo', '$dataNascimento', null, null, null, null);

        if ($conn->query($sql) === TRUE) {
            echo "Animal cadastrado com sucesso!";
        } else {
            echo "Erro ao cadastrar: " . $conn->error;
        }
    }
}

$conn->close();
?>



    <div class="container">

        <div class="topo">
            <div class="logo-container">
                <img src="../../assets/images/logolac.png" class="logo">
            </div>
        </div>

        <h2 class="subtitulo">Novo Cadastro</h2>

        <form>
            <p class="label">Sexo do animal</p>
            <div>
                <label for="tipoAnimal">Tipo do animal:</label>
                <select name="tipoAnimal" required>
                    <option value="">Selecione...</option>
                    <option value="macho">Macho</option>
                    <option value="femea">Fêmea</option>
                    <option value="cria">Cria</option>
                </select>
            </div>

            <input type="text" name="nome" placeholder="Nome" required>
            <input type="date" name="data" placeholder="Data" required>
            <input type="text" name="nomePai" name="idMatriz" placeholder="Nome do Pai">
            <input type="text" name="nomeMae" placeholder="Nome da Mãe">

            <button type="submit" class="botao">
                SALVAR
            </button>
            
            <button class="botoesVoltar"><a href="../main/index.html">Voltar</a></button>
        </form>
    </div>
</body>
</html>
