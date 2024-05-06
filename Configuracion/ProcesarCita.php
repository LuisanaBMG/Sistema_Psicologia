<?php
if (!isset($_SESSION)) {
    session_start();
}

include_once('Conexion_BD.php');

if (!isset($_SESSION['Id_Usuario'])) {
    header("Location: ../PHP/Iniciar_Sesion.php?error=error_acceso");
    exit();
}

$idPaciente = $idCita = $idCalendario = $tipoCita = null;

if (isset($_POST['seleccionar'])) {
    foreach ($_POST['seleccionar'] as $Fila) {
        $datos = explode("|", $Fila);
        if (count($datos) == 4) {
            $idPaciente = $datos[0];
            $idCita = $datos[1];
            $idCalendario = $datos[2];
            $tipoCita = $datos[3];
        }
    }
}

// Acción para Modificar Cita
if (isset($_POST['accion_modificar'])) {
    if (isset($_POST['seleccionar']) && count($_POST['seleccionar']) > 1) {
        header("Location: ../PHP/Citas_Agendadas.php?error=Mas_de_dos_citas");
        exit();
    } elseif (isset($_POST['seleccionar']) && count($_POST['seleccionar']) > 0) {
        header("Location: ModificarCita.php?idPaciente=" . $idPaciente . "&idCita=" . $idCita . "&idCalendario=" . $idCalendario . "&tipoCita=" . $tipoCita);
        exit();
    } else {
        header("Location: ../PHP/Citas_Agendadas.php?error=Seleccione_Cita");
        exit();
    }
}

// Acción para eliminar de forma lógica la cita
if (isset($_POST['accion_eliminar'])) {
    if (empty($idPaciente) || empty($idCita) || empty($idCalendario)) {
        header("Location: ../PHP/Citas_Agendadas.php?error=No_Seleccionado");
        exit();
    }

    try {
        // Estado del paciente
        $ConsultaPac = "UPDATE paciente SET Status = 'Inactivo' WHERE Id_Paciente = ?";
        $Declaracion1 = $Conexion->prepare($ConsultaPac);
        $Declaracion1->bind_param("i", $idPaciente);
        $Declaracion1->execute();

        // Estado de la cita
        $ConsultaCit = "UPDATE cita SET Status_Cita = 'Suspendido', Status = 'Cancelado' WHERE Id_Cita = ?";
        $Declaracion2 = $Conexion->prepare($ConsultaCit);
        $Declaracion2->bind_param("i", $idCita);
        $Declaracion2->execute();

        // Estado del calendario
        $ConsultaCal = "UPDATE calendario SET Status = 'Inactivo' WHERE Id_Calendario = ?";
        $Declaracion3 = $Conexion->prepare($ConsultaCal);
        $Declaracion3->bind_param("i", $idCalendario);
        $Declaracion3->execute();

        header("Location: ../PHP/Citas_Agendadas.php?success=Cita_Inactiva");
        exit();
    } catch (Exception $e) {
        header("Location: ../PHP/Citas_Agendadas.php?error=Error_Actualizar_Cita");
        exit();
    }
}
