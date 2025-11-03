<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>LacNote - Primeiro Acesso</title>
    <link rel="stylesheet" href="cad.css">
</head>
<body>

    <?php
        require_once ’conexão.php ’;
        session_start ();
        if( isset ( $_POST [’btn - cadastrar ’])):
            $erros = array ();
            $emailDB = mysqli_escape_string ( $connect , $_POST [’email ’]);
            $nome = $_POST [" nome "];
            $email = $_POST [" email "];
            $senha1 = MD5( $_POST [" senha1 "]);
            $senha2 = MD5( $_POST [" senha2 "]);
            if( empty( $email ) or empty( $senha1 ) or empty( $nome ) or empty($senha2)):
                $erros [] = "<li >Os campos nome / email / senha precisam ser preenchidos . </li >";
            else :
                $sql = " SELECT email FROM usuarios WHERE email = ’$emailDB ’";
                $resultado = mysqli_query ( $connect , $sql );
                if( mysqli_num_rows ( $resultado ) > 0):
                    $erros [] = "<li > Esse email já existe . </li >";
                else if($senha1 != $senha2):
                    $erros [] = "<li > As duas senhas precisam ser iguais . </li >";
                else :
                    $sqlInsert = " INSERT INTO usuarios (nome ,email , senha ) VALUES ( ’ $nome ’,
                    ’$email ’,’ $senha ’)";
                    $insert = mysqli_query ( $connect , $sqlInsert );
                    if( $insert ){
                        echo ’<script language =" javascript " type =" text / javascript " >
                        alert (" Usuário cadastrado com sucesso !");
                        window . location . href =" login.php " </ script >’;
                    }
                    else {
                        $erros [] = "<li >Não foi possível cadastrar o usuário .
                        Tente novamente . </li >";
                    }
                    endif ;
            endif ;
        endif ;
    ?>

    <?php
        if (! empty ( $erros )):
            foreach ( $erros as $erro ):
                echo $erro ;
            endforeach ;
        endif ;
    ?>
    <div class="container">
        <div class="logo">
            <img src="../assets/images/logolac.png">
        </div>

        <h2 class="titulo">Cadastrar</h2> <!--deu erro aqui, aí eu consegui fazer umas gambiarras hehehe-->

        <form>
            <input type="text" name="nome" placeholder="Nome completo" required>
            <input type="email" name="email" placeholder="E-mail" required>
            <input type="password" name="senha1" placeholder="Senha" required>
            <input type="password" name="senha2" placeholder="Repita a senha" required>


            <button type="submit" class="botao">
                <a href="../main/index.html">SALVAR</a>
            </button>      
        </form>
    </div>
</body>

</html>
