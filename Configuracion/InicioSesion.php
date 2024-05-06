<?php

session_start();
include_once('Conexion_BD.php');

if(isset($_POST['Usuario']) && isset($_POST['Contrasena'])){
    
    function validar($dato){
        $dato = trim($dato);
        $dato = stripslashes($dato);
        $dato = htmlspecialchars($dato);
        return $dato;
    }

 $Usuario = validar($_POST['Usuario']);
 $Contrasena = validar($_POST['Contrasena']);

 if(empty($Usuario)){
    header("Location: ../PHP/Iniciar_Sesion.php?error=campo_vacio");
    exit();
 }else if(empty($Contrasena)){
    header("Location: ../PHP/Iniciar_Sesion.php?error=campo_vacio");
    exit();
 }else{

     $Contrasena = md5($Contrasena);

     $Cosnulta = "SELECT Id_Usuario, Usuario, Contrasena, Status_Usuario FROM usuario WHERE Usuario = '$Usuario' AND Contrasena = '$Contrasena' AND Status_Usuario= 'Activo'";
     $Resultado = mysqli_query($Conexion, $Consulta);

     if(mysqli_num_rows($Resultado) === 1){
        $row = mysqli_fetch_assoc($Resultado);
        if($row['Usuario'] === $Usuario && $Fila['Contrasena'] === $Contrasena){
            $_SESSION['Id_Usuario'] = $Fila['Id_Usuario'];
            $_SESSION['Usuario'] = $Fila['Usuario'];
            $_SESSION['Status_Usuario'] = $Fila['Status_Usuario'];
            header("Location: ../PHP/Datos_Usuario.php");
            exit();
        }else{
            header("Location: ../PHP/Iniciar_Sesion.php?error=contrasena_incorrecta");
            exit();
        }

      }else{
        header("Location: ../PHP/Iniciar_Sesion.php?error=usuario_no_existe");
        exit();
     }
 }

}else{
    header("Location: ../PHP/Iniciar_Sesion.php");
        exit();
}

?>
