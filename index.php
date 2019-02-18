<?php
spl_autoload_register(function($clase) {
    include "$clase.php";
});

$msj = "";
$mosoc = "Mostrar";

if (isset($_POST['submit'])) {
    $bd = new BD("172.17.0.2");
    
    switch ($_POST['submit']) {
        case "Insertar":
            $user = $_POST['user'];
            $pass = $_POST['pass'];
            if(empty($user) && empty($pass)){
                $msj = "Error. Los campos de usuario y constraseña están vacíos.";
            }else if(empty($user)){
                $msj = "Error. El campo de usuario está vacío.";
            }else if(empty($pass)){
                $msj = "Error. El campo de contraseña está vacío.";
            }else{
                $pass = md5($pass);
                $sentencia = "INSERT INTO usuarios values('$user', '$pass')";
                $resultado = $bd->insert($sentencia);
                if($resultado == 0){
                    $msj = "Error. No se han podido insertar los datos en la base de datos.";
                }else{
                    $msj = "Se han insertado los datos en la base de datos. El usuario se ha registrado.";
                }
            }
            break;
        
        case $mosoc:
            $consultaGeneral = "select * from usuario";
            $usuarios = $bd->select($consultaGeneral);
            $campos = $bd->nomCol("usuario");
            $titulo1 = $campos[0];
            $titulo2 = $campos[1];
            $tabla = "<table>
                <tr>
                    <th>$titulo1</th>
                    <th> $titulo2</th>
                </tr>";
            if ($mosoc == "Ocultar") {
                $mosoc = "Mostrar";
            } else {
                $mosoc = "Ocultar";
            }
            foreach ($usuarios as $usuario) {
                $tabla .= "<tr><td>$usuario[0]</td><td>$usuario[1]</td></tr>";
            }
            $tabla .= "</table>";
            break;

        case "Acceder":
            $user = $_POST['user'];
            $pass = $_POST['pass'];
            if($bd->existe($user, $pass)){
                header("Location:sitio.php");
                exit();
            }else{
                $msj = "El usuario no existe en la base de datos";
            }
            break;
    }
} else {
    $msj = "<div style='color:blue'>Selecciona opción.</div>";
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Registro de usuarios</title>
        <style>
            input{
                margin: 5px;
            }
            fieldset{
                width:60%;
            }
            legend{
                color: darkred;
                font-size: 20px;
            }

        </style>
    </head>
    <body>
        <form method="POST" action="index.php">
            <fieldset>
                <legend>Introduce los siguientes datos</legend>
                <?php
                echo $msj;
                ?>
                <label>Usuario </label><input type="text" name="user" value="lucia"/><br/>
                <label>Contraseña </label><input type="password" name="pass"/><br/>
                <input type="submit" name="submit" value="Insertar">
                <input type="submit" name="submit" value="<?php echo $mosoc?>">
                <input type="submit" name="submit" value="Acceder">
            </fieldset>
            <?php ?>
        </form>
    </body>
</html>
