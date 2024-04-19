<?php
session_start();
include_once('../Configuracion/Conexion_BD.php');

// Inicio Sesion de usuario
if(!isset($_SESSION['Id_Usuario'])){
    header("Location: ../PHP/Iniciar_Sesion.php?error=error_acceso");
    exit();
}

// Verificar si el usuario ya tiene un registro
$Id_Usuario = $_SESSION['Id_Usuario'];

// Preparar la consulta SQL
$stmt = $Conexion->prepare("SELECT Id_Usuario FROM datos_usuario WHERE Id_Usuario = ?");
$stmt->bind_param("i", $Id_Usuario); // Asumiendo que Id_Usuario es un entero
$stmt->execute();
$stmt->store_result();

// Verificar si el usuario ya tiene un registro
if($stmt->num_rows > 0){
    header("Location: ../PHP/Menu_Paciente.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emocion Vital</title>
     <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
  integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../CSS/Datos_Usuario.css">
</head>
<body>
<div class="contenedor-principal">
        <img src="../Imagenes/Psychology Logo blanco.png" alt="Logo Encima" class="logo-encima">

        <h2 class="subtitulo">Ingrese los siguientes datos para completar su registro</h2>
        <form action="../Configuracion/DatosUsuario.php" method="POST">
            <div class="row mb-3">
                <div class="col">
                    <label for="tipoDocumento">Tipo de Documento</label>
                    <select name="Tipo_Documento" id="tipoDocumento" class="form-select" required>
                        <option value="" disabled selected>Tipo de Documento</option>
                        <option value="V-">Venezolano</option>
                        <option value="J-">Jurídico</option>
                        <option value="E-">Extranjero</option>
                    </select>
                </div>
                <div class="col">
                    <label for="documentoId"></label>
                    <input type="text" name="Documento_Id" id="documentoId" class="form-control"
                        placeholder="Documento de Identidad" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <input type="text" name="Primer_Nombre" id="nombre" class="form-control"
                        placeholder="Primer Nombre" required>
                </div>
                <div class="col">
                    <input type="text" name="Segundo_Nombre" id="segundoNombre" class="form-control"
                        placeholder="Segundo Nombre">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <input type="text" name="Primer_Apellido" id="apellido" class="form-control"
                        placeholder="Primer Apellido" required>
                </div>
                <div class="col">
                    <input type="text" name="Segundo_Apellido" id="segundoApellido" class="form-control"
                        placeholder="Segundo Apellido">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="fechaNacimiento">Fecha de Nacimiento</label>
                    <input type="date" name="Fecha_Nacimiento" id="fechaNacimiento" class="form-control"
                        placeholder="Fecha de Nacimiento" required>
                </div>
                <div class="col">
                    <label for="sexo">Sexo</label>
                    <select name="Sexo" id="sexo" class="form-select">
                        <option value="" disabled selected>Seleccione sexo</option>
                        <option value="Femenino">Femenino</option>
                        <option value="Masculino">Masculino</option>
                    </select>
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col">
                    <input type="text" name="Telefono" id="telefono" class="form-control" placeholder="Teléfono"
                        required>
                </div>
                <div class="col">
                    <input type="email" name="Correo" id="correo" class="form-control"
                        placeholder="Correo Electrónico" required>
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary boton">Guardar</button>
                <a href="CerrarSesion.php" class="btn btn-primary boton">Cerrar Sesión</a>

            

        </form>
    </div>

     <!-- Bootstrap Bundle con Popper -->
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
  crossorigin="anonymous"></script>
    <script src="../JS/MenuNavbar.js"></script>
</body>
</html>