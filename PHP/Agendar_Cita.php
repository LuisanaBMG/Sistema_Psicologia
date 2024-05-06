<?php
session_start();
include_once('../Configuracion/Conexion_BD.php');
include('../Configuracion/CargarDireccion.php');

// Inicio Sesion de usuario
if (!isset($_SESSION['Id_Usuario'])) {
    header("Location: ../PHP/Iniciar_Sesion.php?error=error_acceso");
    exit();
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emocion Vital</title>

    <!-- Enlazar hoja de estilos CSS -->
    <link href="../CSS/Agendar_Cita.css" rel="stylesheet">

</head>

<body>

    <div class="Nombre_Usuario">
        <?php
        if (isset($_SESSION['Usuario'])) {
            echo "Bienvenido, " . $_SESSION['Usuario'];
        }
        ?>
    </div>

    <div class="Menu_Lateral" id="Menu_Lateral">
        <img src="" alt="">
        <ul>
            <li><a href="Menu_Paciente.php">Inicio</a></li>
            <li><a href="Citas_Agendadas.php">Citas Agendadas</a></li>
            <li><a href="Configuracion_Paciente.php">Configuración</a></li>
            <li><a href="CerrarSesion.php">Cerrar Sesión</a></li>
        </ul>
    </div>


    <main>

        <nav class="Pasos_cita">
            <ul id="Pasos">
                <li>1</li>
                <li>2</li>
                <li>3</li>
                <li>4</li>
            </ul>
        </nav>
        <form id="Formulario_Cita" action="../Configuracion/AgendarCita.php" method="POST">

            <!-- SELECCION DE TIPO DE CITA -->
            <section id="Tipo_Cita" class="Seccion activa">


                <h2>Seleccion el tipo de cita</h2>

                <label for="Servicio">Servicio:</label>
                <select id="Servicio" name="Servicio" required>
                    <option value="" disabled selected>Seleccione un servicio</option>
                    <option value="1">Psicoterapia Individual</option>
                    <option value="2">Psicoterapia para Pareja</option>
                    <option value="3">Psicoterapia Infantil</option>
                    <option value="4">Psicoterapia para Adolescentes</option>
                </select>

                <h3>Condiciones de cita</h3>
                <ul style="list-style-type: disc;">
                    <li>Psicoterapia Individual: Se enfoca en el tratamiento de un solo individuo, generalmente mayor de 18 años.</li>
                    <li>Psicoterapia para Pareja: Dirigida a parejas, sin importar su estado civil o duración de la relación.</li>
                    <li>Psicoterapia Infantil: Especialmente diseñada para niños, generalmente entre las edades de 3 a 12 años.</li>
                    <li>Psicoterapia para Adolescentes: Diseñada para jóvenes en la etapa de la adolescencia, típicamente entre 12 y 18 años. </li>
                </ul>

                <p>
                    Cada servicio tiene una duración de 45 minutos.
                </p>


            </section>



            <!-- SELECCION DE FECHA Y HORA -->
            <section id="Fecha_Hora" class="Seccion">

                <h2>Seleccione Fecha y hora de cita</h2>

                <section>
                    <h3>Seleccione Fecha</h3>
                    <input type="date" name="Fecha" id="Fecha" required>
                </section>

                <section>
                    <h3>Seleccione Hora</h3>
                    <input type="time" name="Hora" id="Hora" required>
                </section>
            </section>


            <!-- DATOS DE PACIENTE -->
            <section id="Datos_Paciente" class="Seccion">

                <h2>Información de Paciente</h2>

                <label for="Tipo_Documento">Tipo de Documento</label>
                <select name="Tipo_Documento" id="Tipo_Documento" required>
                    <option value="" disabled selected>Tipo de Documento</option>
                    <option value="V-">Venezolano</option>
                    <option value="J-">Jurídico</option>
                    <option value="E-">Extranjero</option>
                </select>

                <label for="Documento_Id">Documento de Identidad</label>
                <input type="text" name="Documento_Id" placeholder="Documento de Identidad" required>

                <!--CAMPO DE CITA INFANTIL O ADOLESCENTE-->
                <div class="Datos_Menor" id="Datos_Menor">
                    <label for="Tiene_Documento">¿El paciente tiene documento de identificación?</label>
                    <input type="checkbox" id="Tiene_Documento" name="Tiene_Documento" onchange="mostrarDocumento()">

                    <div id="Documento_Menor_Div" style="display: none;">
                        <label for="Tipo_Documento_Menor">Tipo de Documento del Menor</label>
                        <select name="Tipo_Documento_Menor" id="Tipo_Documento_Menor">
                            <option value="" disabled selected>Tipo de Documento del Menor</option>
                            <option value="V-">Venezolano</option>
                            <option value="J-">Jurídico</option>
                            <option value="E-">Extranjero</option>
                        </select>

                        <label for="Documento_Menor">Documento de Identidad del Menor</label>
                        <input type="text" name="Documento_Menor" placeholder="Documento de Identidad">
                    </div>

                    <label for="Parentezco">Parentezco</label>
                    <input type="text" name="Parentezco" id="Parentezco">
                </div>

                <label for="Primer_Nombre">Primer Nombre</label>
                <input type="text" name="Primer_Nombre" id="Primer_Nombre" placeholder="Primer Nombre" required>

                <label for="Segundo_Nombre">Segundo Nombre</label>
                <input type="text" name="Segundo_Nombre" id="Segundo_Nombre" placeholder="Segundo Nombre">

                <label for="Primer_Apellido">Primer Apellido</label>
                <input type="text" name="Primer_Apellido" id="Primer_Apellido" placeholder="Primer Apellido" required>

                <label for="Segundo_Apellido">Segundo Apellido</label>
                <input type="text" name="Segundo_Apellido" id="Segundo_Apellido" placeholder="Segundo Apellido">

                <label for="Fecha_Nacimiento">Fecha de Nacimiento</label>
                <input type="date" name="Fecha_Nacimiento" id="Fecha_Nacimiento" placeholder="Fecha de Nacimiento" required>

                <label for="Telefono">Número de Teléfono</label>
                <input type="text" name="Telefono" id="Telefono" placeholder="Número de Teléfono" required>

                <label for="Correo">Correo Electrónico</label>
                <input type="email" name="Correo" id="Correo" required>

                <label for="Sexo">Sexo</label>
                <select name="Sexo" id="Sexo" required>
                    <option value="" disabled selected>Seleccione sexo</option>
                    <option value="Femenino">Femenino</option>
                    <option value="Masculino">Masculino</option>
                </select>

                <!--CAMPO DE CITA INDIVIDUAL O PAREJA-->
                <div class="Datos_Mayor" id="Datos_Mayor">
                    <label for="Profesion">Profesion</label>
                    <input type="text" name="Profesion" id="Profesion">


                    <label for="Num_Hijos">Cantidad de Hijos</label>
                    <input type="text" name="Num_Hijos" id="Num_Hijos">
                </div>

                <h3>Dirección</h3>

                <label for="Estado">Estado</label>
                <select id="Estado" name="Estado" required>
                    <option value="" disabled selected>Seleccione Estado</option>

                </select>

                <label for="Municipio">Municipio</label>
                <select id="Municipio" name="Municipio" required>
                    <option value="" disabled selected>Seleccione Municipio</option>
                </select>


                <label for="Parroquia">Parroquia</label>
                <select id="Parroquia" name="Parroquia" required>
                    <option value="" disabled selected>Seleccione Parroquia</option>
                </select>


                <label for="Ciudad">Ciudad</label>
                <select id="Ciudad" name="Ciudad" required>
                    <option value=" " disabled selected>Seleccione Ciudad </option>
                </select>

                <label for="Direccion_Vivienda">Dirección de vivienda</label>
                <input type="text" name="Direccion_Vivienda" id="Direccion_Vivienda" required>


                <!--CAMPO DE CITA EN PAREJA PARA SEGUNDO MIEMBRO
                <div class="Datos_Pareja" id="Datos_Pareja">

                    <h3>Datos de segundo miembro</h3>

                    <label for="Primer_Nombre">Primer Nombre</label>
                    <input type="text" name="Primer_Nombre" id="Primer_Nombre" placeholder="Primer Nombre">

                    <label for="Segundo_Nombre">Segundo Nombre</label>
                    <input type="text" name="Segundo_Nombre" id="Segundo_Nombre" placeholder="Segundo Nombre">

                    <label for="Primer_Apellido">Primer Apellido</label>
                    <input type="text" name="Primer_Apellido" id="Primer_Apellido" placeholder="Primer Apellido">

                    <label for="Segundo_Apellido">Segundo Apellido</label>
                    <input type="text" name="Segundo_Apellido" id="Segundo_Apellido" placeholder="Segundo Apellido">

                    <label for="Fecha_Nacimiento">Fecha de Nacimiento</label>
                    <input type="date" name="Fecha_Nacimiento" id="Fecha_Nacimiento" placeholder="Fecha de Nacimiento">

                    <label for="Telefono">Número de Teléfono</label>
                    <input type="text" name="Telefono" id="Telefono" placeholder="Número de Teléfono">

                    <label for="Correo">Correo Electrónico</label>
                    <input type="email" name="Correo" id="Correo">

                    <label for="sexo">Sexo</label>
                    <select name="Sexo" id="Sexo">
                        <option value="" disabled selected>Seleccione sexo</option>
                        <option value="Femenino">Femenino</option>
                        <option value="Masculino">Masculino</option>
                    </select>

                    <label for="Profesion">Profesion</label>
                    <input type="text" name="Profesion" id="Profesion">


                    <label for="Num_Hijos">Cantidad de Hijos</label>
                    <input type="text" name="Num_Hijos" id="Num_Hijos">

                    <h3>Dirección</h3>

                    <label for="Estado">Estado</label>
                    <select id="Estado" name="Estado">
                        <option value="" disabled selected>Seleccione Estado</option>

                    </select>

                    <label for="Municipio">Municipio</label>
                    <select id="Municipio" name="Municipio">
                        <option value="" disabled selected>Seleccione Municipio</option>
                    </select>


                    <label for="Parroquia">Parroquia</label>
                    <select id="Parroquia" name="Parroquia">
                        <option value="" disabled selected>Seleccione Parroquia</option>
                    </select>


                    <label for="Ciudad">Ciudad</label>
                    <select id="Ciudad" name="Ciudad">
                        <option value=" " disabled selected>Seleccione Ciudad</option>
                    </select>

                    <label for="Dirección_Vivienda">Dirección de vivienda</label>
                    <input type="text" name="Direccion_vivienda">



                </div>-->

            </section>



            <!-- CONFIRMAR CITA -->
            <section id="Confirmar_Cita" class="Seccion">

                <h2>Confirme su cita</h2>

                <h3>Paciente</h3>
                <label id="Identificacion" for="Identificacion">Documento de Identidad</label>
                <input type="text" name="Identificacion" id="Identificacion">

                <label id="Nombres" for="Nombres">Nombres</label>

                <label id="Apellidos" for="Apellidos">Apellidos</label>

                <label id="Nacimiento" for="Nacimiento">Fecha de Nacimiento</label>

                <label id="NumTelefono" for="NumTelefono">Número de Teléfono</label>

                <label id="CorreoElec" for="CorreoElec">Correo Electrónico</label>

                <label id="TipoSexo" for="TipoSexo">Sexo</label>

                <label id="TipoProfesion" for="TipoProfesion">Profesion</label>


                <h3>Psicóloga</h3>
                <b>Licenciada Daniela Mogollón<b>

                        <h3>Cita</h3>
                        <label id="Tipo_Cita" for="Tipo_Cita">Tipo de vita</label>
                        <label id="Costo_Cita" for="Costo_Cita">Costo de cita</label>
                        <label id="Tiempo_Cita" for="Tiempo_Cita">Tiempo de cita</label>


                        <button type="button">Cancelar</button>
            </section>
            <button type="submit" class="btn_Confirmar" id="btn_Confirmar">Confirmar</button>
        </form>


        <button type="button" onclick="AnteriorPaso()">Anterior</button>
        <button type="button" id="btn_Siguiente" onclick="SiguientePaso()">Siguiente</button>


    </main>

    <script src="../JS/CargarDireccion.js"></script>
    <script src="../JS/AgendarCita.js"></script>

</body>

</html>