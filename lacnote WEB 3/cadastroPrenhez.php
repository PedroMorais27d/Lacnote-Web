<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LacNote - Novo Cadastro</title>
    <link rel="stylesheet" href="prenhez.css">
</head>
<body>

<?php
    include("conexão.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nomeMatriz = $_POST["idMatriz"];
        $data = $_POST["data"];
        $nomeMacho = $_POST["idMacho"];
        $hoje = date('Y-m-d');

        if ($data > $hoje) {
            echo "A data de prenhez não pode ser no futuro!";
            exit;
        }

        if (empty($nomeMatriz) || empty($data) || empty($nomeMacho)) {
            echo "<p> Preencha todos os campos.</p>";
        } else {

            $sql = "SELECT idAnimal from animal where nome = '$nomeMatriz' ";
            $idMatriz = mysqli_query($conn,$sql);

            $sql = "SELECT nome from animal where nome = '$nomeMacho' ";
            $idMacho = mysqli_query($conn,$sql);


            if(mysqli_num_rows($idMatriz)>0 && mysqli_num_rows($idMacho)>0){

                $idMatrizFetch = mysqli_fetch_array($idMatriz);

                $idMachoFetch = mysqli_fetch_array($idMacho);

                $resultF=$idMatrizFetch['idAnimal'];

                $resultM=$idMachoFetch['idAnimal'];

                $sql = "INSERT INTO prenhez (idMatriz,data, idMacho, confirmada)
                        VALUES ( '$resultM','$data', '$resultM', 0)";

                if ($conn->query($sql) === TRUE) {
                    echo "Prenhez registrada com sucesso!";
                } else {
                    echo "<p> Erro ao registrar prenhez: " . $conn->error . "</p>";
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
                <img src="../../assets/images/logolac.png" class="logo">
            </div>
        </div>

        <h2 class="subtitulo">Prenhez - Cadastro</h2>

        <form>
            <input type="text" name='idMatriz'placeholder="Nome da Vaca" required>
            <input type="text" name='data'placeholder="Data de Cobertura ou Inseminação" required>
            <input type="text" name='idMacho' placeholder="Nome do touro" required>
            <center> 
                <button type="submit" class="botoesVoltar">
                    SALVAR
                </button>   
                
                <button class="botoesVoltar"><a href="../main/index.html">Voltar</a></button>
            </center>

        </form>
    </div>
</body>
</html>