<html>
<head>
    <meta name="viewport">
    <title>LacNote - Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
        require_once ’db_connect .php ’;
        session_start ();
        if( isset ( $_POST [’btn - entrar ’])):
            $erros = array ();
            $login = mysqli_escape_string ( $connect , $_POST [’login ’]);
            $senha = mysqli_escape_string ( $connect , $_POST [’senha ’]);
            if( empty ( $login ) or empty ( $senha )):
                $erros [] = "<li >O campo login / senha precisa ser preenchido . </li >";
            else :
                $sql = " SELECT login FROM usuarios WHERE login = ’$login ’";
                $resultado = mysqli_query ( $connect , $sql );
                if( mysqli_num_rows ( $resultado ) > 0):
                    // Existe um registro com o login que foi informado
                    $senha = md5( $senha );
                    $sql = " SELECT * FROM usuarios WHERE login = ’$login ’
                    AND senha = ’$senha ’";
                    $resultado = mysqli_query ( $connect , $sql );
                    mysqli_close ( $connect );
                    if( mysqli_num_rows ( $resultado ) == 1):
                        $dados = mysqli_fetch_array ( $resultado );
                        $_SESSION [’logado ’] = true ;
                        $_SESSION [’id_usuario ’] = $dados [’id ’];
                        header (’Location : home .php ’);
                    else :
                        $erros [] = "<li >Usu ário e senha não conferem . </li >";
                    endif ;
                 else :
                    // Não existe um registro com o login que foi informado
                    $erros [] = "<li >Usuário inexistente . </li >";
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
            <img src="../../assets/images/logolac.png">
        </div>

        <form>
            <label>Usuário</label>
            <input type="text" id="usuario" name="usuario">

            <label>Senha</label>
            <input type="password" id="senha" name="senha">

            <button onclick="" type="submit" class="botao"> 
                <a href="../main/index.html" class="botao1">LOGIN</a>
            </button>
        </form>
        <button class="botao">
            <a href="../cadastro-usuario/cadastro.php" class="botao1">CADASTRAR</a>
        </button>
    </div>
</body>
</html>
