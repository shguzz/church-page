<?php
// Verificar si se han enviado datos por el método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si los campos obligatorios no están vacíos
    if (!empty($_POST['cName']) && !empty($_POST['cEmail']) && !empty($_POST['cTelefono']) && !empty($_POST['cMessage'])) {
        // Conexión a la base de datos
        $servername = "sql105.infinityfree.com";
        $username = "if0_36465135";
        $password = "LFh3Y9ORaC84G";
        $dbname = "if0_36465135_form";

        $conn = new mysqli($servername, $username, $password, $dbname);

        // Verificar la conexión
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        // Obtener los datos del formulario y realizar una limpieza básica
        $nombre = htmlspecialchars($_POST['cName']);
        $email = htmlspecialchars($_POST['cEmail']);
        $telefono = htmlspecialchars($_POST['cTelefono']);
        $mensaje = htmlspecialchars($_POST['cMessage']);

        // Validar el formato del correo electrónico
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo '<script>alert("Formato de correo electrónico inválido");</script>';
        } else {
            // Preparar la consulta SQL utilizando un prepared statement
            $sql = "INSERT INTO datos (nombre, email, telefono, comentario) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $nombre, $email, $telefono, $mensaje);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                // Mostrar mensaje de confirmación usando JavaScript
                echo '<script>alert("Mensaje enviado correctamente");</script>';
                // Redireccionar a otra página HTML después de unos segundos
                echo '<script>
                        setTimeout(function() {
                            window.location.href = "contact.html";
                        }, 3000);
                      </script>';
                exit; // Es importante salir del script después de redireccionar
            } else {
                // Mostrar mensaje de error usando JavaScript
                echo '<script>alert("Error al enviar el mensaje");</script>';
                // También podrías mostrar el error en el cuerpo de la página si lo prefieres
                echo "Error al ejecutar la consulta";
            }

            // Cerrar la sentencia preparada
            $stmt->close();
        }

        // Cerrar la conexión
        $conn->close();
    } else {
        // Mostrar mensaje de error si los campos obligatorios están vacíos
        echo '<script>alert("Todos los campos obligatorios deben estar completos");</script>';
    }
}
?>