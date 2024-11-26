<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Citas Veterinarias</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css">
    <link rel="stylesheet" href="../../../assets/css/style.css">

    <style>
        .appointment-form {
            background-color: #e8e8e8;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.3);
        }
        .required-field::after {
            content: " *";
            color: red;
        }
        .back-arrow {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1000;
        }
        .back-arrow a {
            color: #0d6efd;
            text-decoration: none;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
            padding: 10px;
        }
        .back-arrow a:hover {
            color: #0b5ed7;
            transform: translateX(-5px);
        }
        .back-arrow i {
            font-size: 24px;
            margin-right: 8px;
        }
        .back-arrow span {
            font-size: 16px;
        }
    </style>

</head>
<body>


<!-- Flecha de regreso -->
<div class="back-arrow">
    <a href="../index.php">
        <i class="ri-arrow-left-line"></i>
        <span>Volver al inicio</span>
    </a>
</div>

<!-- Formulario -->
<section>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="appointment-form">
                    <h2 class="text-center mb-4">Agenda tu Cita Veterinaria</h2>
                    <form action="procesar_cita.php" method="POST">
                        <!-- Datos del Cliente -->
                        <div class="mb-4">
                            <h4>Información del Cliente</h4>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nombre_cliente" class="form-label required-field">Nombre completo</label>
                                    <input type="text" class="form-control" id="nombre_cliente" name="nombre_cliente" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="telefono" class="form-label required-field">Teléfono</label>
                                    <input type="tel" class="form-control" id="telefono" name="telefono" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="email" class="form-label required-field">Correo electrónico</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                            </div>
                        </div>

                        <!-- Datos de la Mascota -->
                        <div class="mb-4">
                            <h4>Información de la Mascota</h4>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nombre_mascota" class="form-label required-field">Nombre de la mascota</label>
                                    <input type="text" class="form-control" id="nombre_mascota" name="nombre_mascota" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="tipo_mascota" class="form-label required-field">Tipo de mascota</label>
                                    <select class="form-select" id="tipo_mascota" name="tipo_mascota" required>
                                        <option value="">Seleccione...</option>
                                        <option value="perro">Perro</option>
                                        <option value="gato">Gato</option>
                                        <option value="ave">Ave</option>
                                        <option value="otro">Otro</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="raza" class="form-label">Raza</label>
                                    <input type="text" class="form-control" id="raza" name="raza">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="peso" class="form-label">Peso (kg)</label>
                                    <input type="number" step="0.1" class="form-control" id="peso" name="peso">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="edad" class="form-label">Edad</label>
                                    <input type="number" class="form-control" id="edad" name="edad">
                                </div>
                            </div>
                        </div>

                        <!-- Datos de la Cita -->
                        <div class="mb-4">
                            <h4>Detalles de la Cita</h4>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="servicio" class="form-label required-field">Tipo de servicio</label>
                                    <select class="form-select" id="servicio" name="servicio" required>
                                        <option value="">Seleccione el servicio...</option>
                                        <option value="consulta_general">Consulta General</option>
                                        <option value="cirugia">Cirugía</option>
                                        <option value="analisis">Análisis Clínico</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="fecha" class="form-label required-field">Fecha preferida</label>
                                    <input type="date" class="form-control" id="fecha" name="fecha" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="hora" class="form-label required-field">Hora preferida</label>
                                    <input type="time" class="form-control" id="hora" name="hora" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="sintomas" class="form-label">Síntomas o razón de la visita</label>
                                    <textarea class="form-control" id="sintomas" name="sintomas" rows="3"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg">Agendar Cita</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>