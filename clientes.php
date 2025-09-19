<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Clientes</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background-color: #f8f9fa;
            color: #212529;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            /* Para que el radio del borde afecte a la tabla */
        }

        h1 {
            text-align: center;
            color: #343a40;
            padding: 20px 0;
            border-bottom: 1px solid #dee2e6;
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            /* Elimina el espacio entre bordes */
        }

        th,
        td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }

        thead th {
            background-color: #007bff;
            color: #ffffff;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tbody tr:hover {
            background-color: #e9ecef;
            /* Un color suave para el efecto hover */
        }

        .error-message {
            text-align: center;
            padding: 20px;
            color: #721c24;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            margin: 20px;
            border-radius: 5px;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>Listado de Clientes</h1>

        <?php
        // --- 1. Parámetros de conexión a la base de datos ---
        $db_host = "localhost";      // Servidor, usualmente "localhost" o "127.0.0.1"
        $db_user = "root";           // Usuario de la base de datos (por defecto 'root' en XAMPP)
        $db_pass = "";               // Contraseña (por defecto vacía en XAMPP)
        $db_name = "empresa_db";     // El nombre de tu base de datos

        // --- 2. Establecer la conexión usando MySQLi ---
        $conexion = new mysqli($db_host, $db_user, $db_pass, $db_name);

        // --- 3. Verificar si la conexión fue exitosa ---
        if ($conexion->connect_error) {
            // die() detiene la ejecución del script y muestra un mensaje
            die("<div class='error-message'>Error de conexión: " . $conexion->connect_error . "</div>");
        }

        // Para asegurar que los caracteres (acentos, ñ) se muestren correctamente
        $conexion->set_charset("utf8");

        // --- 4. Preparar la consulta SQL ---
        $sql = "SELECT nombre, apellido, empresa, domicilio, ciudad, pais, telefono, email FROM clientes";
        $resultado = $conexion->query($sql);

        // --- 5. Generar la tabla HTML dinámicamente ---
        if ($resultado->num_rows > 0) {
            echo "<table>";
            // Cabecera de la tabla
            echo "<thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Empresa</th>
                        <th>Domicilio</th>
                        <th>Ciudad</th>
                        <th>País</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                    </tr>
                  </thead>";
            // Cuerpo de la tabla
            echo "<tbody>";
            // fetch_assoc() obtiene una fila de resultados como un array asociativo
            while ($fila = $resultado->fetch_assoc()) {
                echo "<tr>";
                // Usamos htmlspecialchars() por seguridad para evitar inyección de código HTML/JS
                echo "<td>" . htmlspecialchars($fila["nombre"]) . "</td>";
                echo "<td>" . htmlspecialchars($fila["apellido"]) . "</td>";
                echo "<td>" . htmlspecialchars($fila["empresa"]) . "</td>";
                echo "<td>" . htmlspecialchars($fila["domicilio"]) . "</td>";
                echo "<td>" . htmlspecialchars($fila["ciudad"]) . "</td>";
                echo "<td>" . htmlspecialchars($fila["pais"]) . "</td>";
                echo "<td>" . htmlspecialchars($fila["telefono"]) . "</td>";
                echo "<td>" . htmlspecialchars($fila["email"]) . "</td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
        } else {
            echo "<div class='error-message'>No se encontraron registros en la tabla 'clientes'.</div>";
        }
        // --- 6. Cerrar la conexión a la base de datos ---
        $conexion->close();
        $resultado->free();
        ?>
    </div>
</body>

</html>