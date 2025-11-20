<?php
// Indicamos que la respuesta será en formato JSON para que JavaScript la entienda
header('Content-Type: application/json');

// --- CONFIGURACIÓN DE LA BASE DE DATOS ---
$db_host = 'localhost'; // Generalmente es 'localhost' en XAMPP
$db_user = 'root';      // Usuario por defecto en XAMPP
$db_pass = '';          // Contraseña por defecto en XAMPP es vacía
$db_name = 'lab12_db';  // El nombre de la base de datos que creaste

// --- CONEXIÓN A LA BASE DE DATOS ---
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Verificar si la conexión falló
if ($conn->connect_error) {
    // Si no se puede conectar, enviamos un error y terminamos el script
    echo json_encode([
        'success' => false,
        'message' => 'Error de conexión a la base de datos: ' . $conn->connect_error
    ]);
    exit; // Detiene la ejecución del script
}

// Preparamos un array para la respuesta
$response = [
    'success' => false,
    'message' => 'Error desconocido.'
];

// Verificamos que la solicitud sea por el método POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Obtenemos los datos del formulario
    $titulo = isset($_POST['titulo']) ? trim($_POST['titulo']) : '';
    $contenido = isset($_POST['contenido']) ? trim($_POST['contenido']) : '';

    // Validamos que los campos no estén vacíos
    if (!empty($titulo) && !empty($contenido)) {
        
        // Preparamos la consulta SQL para evitar inyecciones SQL (más seguro)
        $stmt = $conn->prepare("INSERT INTO notas (titulo, contenido) VALUES (?, ?)");
        $stmt->bind_param("ss", $titulo, $contenido); // "ss" significa que ambos parámetros son strings
        
        // Ejecutamos la consulta y verificamos si fue exitosa
        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = '¡Nota guardada en la base de datos con éxito!';
        } else {
            $response['message'] = 'Error del servidor: No se pudo guardar la nota. ' . $stmt->error;
        }
        $stmt->close(); // Cerramos la consulta preparada
    } else {
        $response['message'] = 'Por favor, completa el título y el contenido de la nota.';
    }
} else {
    $response['message'] = 'Método no permitido.';
}

// Cerramos la conexión a la base de datos
$conn->close();

// Devolvemos la respuesta en formato JSON
echo json_encode($response);
?>