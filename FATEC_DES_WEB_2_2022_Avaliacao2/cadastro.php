<?php
    session_start(); // initial session
    

    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){// se não existir loggedin no session ou loggedin não estiver valido volta para index.php
        header("location: index.php");
        exit;
    }
    require_once('banco_dados.php');
    $firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "INSERT INTO authors (firstname, lastname)
VALUES ('$firstName', '$lastName')";

if (mysqli_query($conn, $sql)) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}


    if($_SERVER["REQUEST_METHOD"] == "POST"){ // se o método chamado for tipo Post
        if( $_POST['posicao'] != ""  &&   $_POST['num_partidas'] != "" && $_POST['num_expulsoes'] != "")  { // verifica se não são vázio os campos
            $posicao = $_POST['posicao'];
            $num_partidas = $_POST['num_partidas'];
            $num_expulsoes = $_POST['num_expulsoes']; 
            $filename = "cadastro.txt";
        
            // verifica se o arquivo existe. retorna bool
            if (!file_exists($filename)) {
                $handle = fopen($filename, "w");
            } else {
                
                $handle = fopen($filename, "a");
            }

            fwrite($handle,"$posicao,$num_partidas,$num_expulsoes\n");

            fflush($handle);

            fclose($handle);

           
            header("location: inicio.php");
        }
    }
      
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 450px; padding: 20px;  margin: auto; margin-top: 50px;}
        .text-black{ color: black !important; font-weight: bold; margin-bottom: 15px; }
        .btn-right{ float: right !important; margin-right: 10px; margin-top: 12px;}
    </style>
</head>
<body>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <h3><a class="text-black" href="inicio.php">Cadastro de Jogador </a></h3>
            </div>
            <div class="btn-right ">
                <a href="logout.php" class="btn btn-danger">Sair</a>
            </div>
        </div>
    </nav>
    <div class="wrapper">
        <h2>Cadastro de novo jogador</h2>
        <form action="cadastro.php" method="post">
            <div class="form-group">
                <label>Posição</label>
                <input type="text" name="name" class="form-control" value="">
                <span class="help-block"></span>
            </div>    
            <div class="form-group">
                <label>Número de partidas</label>
                <input type="text" name="posicao" class="form-control" value="">
                <span class="help-block"></span>
            </div>
            <div class="form-group">
                <label>Número de expulção</label>
                <input type="text" name="numero" class="form-control" value="">
                <span class="help-block"></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Cadastrar">
            </div>
        </form>
    </div>    
</body>
</html>