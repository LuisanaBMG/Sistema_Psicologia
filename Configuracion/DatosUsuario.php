<?php
session_start();
include_once('Conexion_BD.php');

// Inicio Sesion de usuario
if (!isset($_SESSION['Id_Usuario'])) {
    header("Location: ../PHP/Iniciar_Sesion.php?error=error_acceso");
    exit();
}

if (isset($_POST['Tipo_Documento']) && isset($_POST['Documento_Id']) && isset($_POST['Primer_Nombre']) && isset($_POST['Segundo_Nombre']) && isset($_POST['Primer_Apellido']) && isset($_POST['Segundo_Apellido']) && isset($_POST['Fecha_Nacimiento']) && isset($_POST['Telefono']) && isset($_POST['Correo']) && isset($_POST['Sexo'])) {
    function validar($dato)
    {
        $dato = trim($dato);
        $dato = stripslashes($dato);
        $dato = htmlspecialchars($dato);
        return $dato;
    }

    $Tipo_Documento = validar($_POST['Tipo_Documento']);
    $Documento_Id = validar($_POST['Documento_Id']);
    $Primer_Nombre = validar($_POST['Primer_Nombre']);
    $Segundo_Nombre = empty($Segundo_Nombre) ? "Vacío" : $Segundo_Nombre;
    $Primer_Apellido = validar($_POST['Primer_Apellido']);
    $Segundo_Apellido = empty($Segundo_Apellido) ? "Vacío" : $Segundo_Apellido;
    $Fecha_Nacimiento = validar($_POST['Fecha_Nacimiento']);
    $Telefono = validar($_POST['Telefono']);
    $Correo = validar($_POST['Correo']);
    $Sexo = validar($_POST['Sexo']);

    // Validar que el teléfono y la cédula sean mayores que cero
    if ($Telefono <= 0 || $Documento_Id <= 0) {
        header("Location: ../PHP/Datos_Usuario.php?error=valor_invalido");
        exit();
    }

    // Validar que la fecha de nacimiento sea mayor a 18 años
    $fechaNacimiento = DateTime::createFromFormat('Y-m-d', $Fecha_Nacimiento);
    $hoy = new DateTime();
    $edad = $hoy->diff($fechaNacimiento)->y;

    if ($edad < 18) {
        header("Location: ../PHP/Datos_Usuario.php?error=menor_de_edad");
        exit();
    }

    if (empty($Tipo_Documento) ||  empty($Documento_Id) || empty($Primer_Nombre) || empty($Segundo_Nombre) || empty($Primer_Apellido) || empty($Segundo_Apellido) || empty($Fecha_Nacimiento) || empty($Telefono) || empty($Correo) || empty($Sexo)) {
        header("Location: ../PHP/Datos_Usuario.php?error=campos_vacios");
        exit();
    } else {

        $Consulta1 = "SELECT Documento_Id FROM datos_usuario WHERE Documento_Id = '$Documento_Id'";
        $Resultado1 = $Conexion->query($Consulta1);

        if (mysqli_num_rows($Resultado1) > 0) {
            header("Location: ../PHP/Datos_Usuario.php?error=usuario_existente");
            exit();
        } else {

            $Id_Usuario = $_SESSION['Id_Usuario'];

            $Consulta2 = "INSERT INTO datos_usuario (Id_Usuario, Tipo_Documento, Documento_Id, Primer_Nombre, Segundo_Nombre, Primer_Apellido, Segundo_Apellido, Fecha_Nacimiento, Telefono, Correo, Sexo, Fecha_Registro) VALUES ('$Id_Usuario', '$Tipo_Documento', '$Documento_Id', '$Primer_Nombre', '$Segundo_Nombre', '$Primer_Apellido', '$Segundo_Apellido', '$Fecha_Nacimiento', '$Telefono', '$Correo', '$Sexo', NOW())";
            $Resultado2 = $Conexion->query($Consulta2);

            if ($Resultado2) {
                header("Location: ../PHP/Menu_Paciente.php?success=registro_exitoso");
                exit();
            } else {
                header("Location: ../PHP/Datos_Usuario.php?error=error_registro");
                exit();
            }
        }
    }
} else {
    header("Location: ../PHP/Datos_Usuario.php");
    exit();
}
