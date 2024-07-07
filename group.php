<?php
// Verificar si se han enviado datos por el método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si los campos obligatorios no están vacíos
    if (!empty($_POST['cName']) && !empty($_POST['cEmail']) && !empty($_POST['cTelefono']) && !empty($_POST['cAge']) && !empty($_POST['cAvailability'])) {
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
        $nombre = $_POST['cName']; // No se sanitiza aquí porque se utilizarán sentencias preparadas
        $email = $_POST['cEmail']; // No se sanitiza aquí porque se utilizarán sentencias preparadas
        $telefono = $_POST['cTelefono']; // No se sanitiza aquí porque se utilizarán sentencias preparadas
        $facebook = htmlspecialchars($_POST['cFacebook']); // Se utiliza htmlspecialchars para evitar XSS
        $edad = $_POST['cAge']; // No se sanitiza aquí porque se utilizarán sentencias preparadas
        $disponibilidad = $_POST['cAvailability']; // No se sanitiza aquí porque se utilizarán sentencias preparadas
        $comentarios = htmlspecialchars($_POST['cComments']); // Se utiliza htmlspecialchars para evitar XSS

        // Validar el formato del correo electrónico
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "Por favor, proporcione una dirección de correo electrónico válida.";
            exit; // Salir del script si el correo electrónico no es válido
        }

        // Preparar la consulta SQL para la inserción
        $sql = "INSERT INTO conexiones (nombre, email, telefono, facebook, edad, disponibilidad, comentarios) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        // Verificar si la preparación de la consulta fue exitosa
        if ($stmt) {
            // Asociar parámetros y ejecutar la consulta
            $stmt->bind_param("sssssss", $nombre, $email, $telefono, $facebook, $edad, $disponibilidad, $comentarios);
            if ($stmt->execute()) {
                // Mostrar mensaje de confirmación usando JavaScript
                echo '<script>alert("¡Gracias por conectarte! Tus datos han sido enviados correctamente.");</script>';
                // Redireccionar a otra página HTML después de unos segundos
                echo '<script>
                        setTimeout(function() {
                            window.location.href = "index.html";
                        }, 3000);
                      </script>';
                exit; // Es importante salir del script después de redireccionar
            } else {
                // Mostrar mensaje de error usando JavaScript
                echo '<script>alert("Error al enviar los datos. Por favor, inténtelo de nuevo más tarde.");</script>';
            }
        } else {
            // Mostrar mensaje de error si la preparación de la consulta falló
            echo "Error al preparar la consulta";
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
