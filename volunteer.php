<?php
// Verificar si se han enviado datos por el método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si los campos obligatorios no están vacíos
    if (!empty($_POST['cName']) && !empty($_POST['cEmail']) && !empty($_POST['cTelefono']) && !empty($_POST['cMinistry']) && !empty($_POST['cFirstTime'])) {
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
    
        // Recuperar los datos del formulario y realizar una limpieza básica
        $nombre = htmlspecialchars($_POST['cName']);
        $email = htmlspecialchars($_POST['cEmail']);
        $telefono = htmlspecialchars($_POST['cTelefono']);
        $facebook = htmlspecialchars($_POST['cFacebook']);
        $ministerio = htmlspecialchars($_POST['cMinistry']);
        $primera_vez = htmlspecialchars($_POST['cFirstTime']);
        $comentarios = htmlspecialchars($_POST['cComments']);

        // Validar el formato del correo electrónico
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "La dirección de correo electrónico proporcionada no es válida.";
            exit;
        }

        // Preparar la consulta SQL para la inserción
        $sql = "INSERT INTO voluntarios (nombre, email, telefono, facebook, ministerio, first_time, comentarios) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssss", $nombre, $email, $telefono, $facebook, $ministerio, $primera_vez, $comentarios);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Mostrar mensaje de confirmación usando JavaScript
            echo '<script>alert("¡Gracias por enviar el formulario, Su solicitud ha sido recibida correctamente.");</script>';
            // Redireccionar a otra página HTML después de unos segundos
            echo '<script>
                    setTimeout(function() {
                        window.location.href = "index.html";
                    }, 3000);
                  </script>';
            exit; // Es importante salir del script después de redireccionar
        } else {
            // Mostrar mensaje de error usando JavaScript
            echo '<script>alert("Error al enviar el mensaje");</script>';
            // También podrías mostrar el error en el cuerpo de la página si lo prefieres
            echo "Error al ejecutar la consulta";
        }

        // Cerrar la conexión y liberar los recursos
        $stmt->close();
        $conn->close();
    } else {
        // Mostrar mensaje de error si los campos obligatorios están vacíos
        echo "Por favor, complete todos los campos obligatorios.";
    }
} else {
    // Mostrar mensaje de error si no se envían datos por el método POST
    echo "Ha ocurrido un error al procesar el formulario. Por favor, inténtelo de nuevo más tarde.";
}
?>