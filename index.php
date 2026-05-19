<?php
// Conexión de solo lectura para la vista pública usando al usuario auditor
$conn = new mysqli('localhost', 'audit_user', 'Audit*2026', 'italikasiete');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Refaccionaria Italika - Equipo 7</title>
</head>
<body style="font-family: Arial, sans-serif; text-align: center; background-color: #f4f4f4; margin: 0;">
    <header style="background: #d32f2f; color: white; padding: 20px;">
        <h1>Refaccionaria Italika</h1>
        <nav>
            <a href="index.php" style="color: white; margin: 10px; text-decoration: none;">Inicio</a>
            <a href="#productos" style="color: white; margin: 10px; text-decoration: none;">Productos</a>
            <a href="login.php" style="color: white; margin: 10px; text-decoration: none;">Acceso Administrador</a>
        </nav>
    </header>

    <main style="padding: 40px;">
        <section id="inicio">
            <h2>Nuestra Misión</h2>
            <p>Proveer las mejores refacciones originales para mantener tu motocicleta siempre en movimiento con la máxima seguridad y rendimiento.</p>
            
            <h2>Nuestra Visión</h2>
            <p>Ser la refaccionaria líder en el mercado nacional, reconocida por nuestra calidad y servicio al cliente.</p>
        </section>

        <hr style="margin: 40px 0; border: 1px solid #ddd;">

        <section id="productos">
            <h2>Catálogo de Productos Destacados</h2>
            <p>Explora algunas de nuestras refacciones disponibles:</p>
            
            <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 20px; margin-top: 20px;">
                <?php
                if (!$conn->connect_error) {
                    // Consulta segura de solo lectura
                    $result = $conn->query("SELECT nombre, precio FROM refacciones LIMIT 10");
                    while ($fila = $result->fetch_assoc()) {
                        echo "<div style='background: white; padding: 15px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); width: 200px;'>";
                        echo "<h4 style='color: #d32f2f; margin-bottom: 10px;'>" . $fila['nombre'] . "</h4>";
                        echo "<p style='font-weight: bold; font-size: 1.2em; margin: 0;'>$" . $fila['precio'] . "</p>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>Catálogo no disponible en este momento.</p>";
                }
                ?>
            </div>
        </section>
    </main>

    <footer style="background: #333; color: white; padding: 15px; margin-top: 50px;">
        <p>Taller de Sistemas Operativos - Proyecto Final &copy; 2026</p>
    </footer>
</body>
</html>
