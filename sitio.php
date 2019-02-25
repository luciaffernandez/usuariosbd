<?php 
session_start();
if(empty($_SESSION['user'])){
    header("Location:login.php?msj='Debes loguearte primero'");
    exit();
}
if(isset($_POST['enviar'])){
    echo "entra";
    header("Location:login.php?msj='Te has desconectado'");
    exit();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Sitio web</title>
    </head>
    <body>
        <span style="float:right;">Logueado como <span style="color: blueviolet"><?php echo $_SESSION['user'];?></span></span>
        <form method="POST" action="sitio.php"><input type="submit" value="Desconectar" name="enviar"/></form>
        <hr>
        <h1>Bienvenido a este sitio web</h1>
    </body>
</html>
