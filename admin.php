<?php
session_start();
// Proteger la página
if (!isset($_SESSION['logueado'])) {
    header('Location: login.php');
    exit;
}

// Conexión a la Base de Datos usando dev_user
$conn = new mysqli('localhost', 'dev_user', 'User*2026', 'italikasiete');
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// -------- LÓGICA CRUD --------
// D - Delete (Eliminar)
if (isset($_GET['del'])) {
    $id = $_GET['del'];
    $conn->query("DELETE FROM refacciones WHERE id=$id");
    header("Location: admin.php");
}

// C & U - Create y Update (Guardar datos)
if (isset($_POST['guardar'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];

    if ($id != '') { // Si hay ID, es un Update
        $conn->query("UPDATE refacciones SET nombre='$nombre', precio=$precio, stock=$stock WHERE id=$id");
    } else { // Si no hay ID, es un Create
        $conn->query("INSERT INTO refacciones (nombre, precio, stock) VALUES ('$nombre', $precio, $stock)");
    }
    header("Location: admin.php");
}

// R - Cargar datos para Editar
$id_edit = ''; $nom_edit = ''; $pre_edit = ''; $stk_edit = '';
if (isset($_GET['edit'])) {
    $res = $conn->query("SELECT * FROM refacciones WHERE id=" . $_GET['edit']);
    if ($row = $res->fetch_assoc()) {
        $id_edit = $row['id'];
        $nom_edit = $row['nombre'];
        $pre_edit = $row['precio'];
        $stk_edit = $row['stock'];
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - CRUD Refacciones</title>
</head>
<body style="font-family: Arial; padding: 20px;">
    <h2>Panel de Administración - Refacciones Italika</h2>
    <a href="index.php" style="color: red;">Cerrar Sesión / Volver al Inicio</a>
    <hr>

    <!-- Formulario para Crear / Editar -->
    <div style="background: #e3f2fd; padding: 15px; margin-bottom: 20px; border-radius: 5px;">
        <h3><?php echo ($id_edit != '') ? 'Editar Registro' : 'Agregar Nueva Refacción'; ?></h3>
        <form method="POST" action="">
            <input type="hidden" name="id" value="<?php echo $id_edit; ?>">
            Nombre: <input type="text" name="nombre" value="<?php echo $nom_edit; ?>" required>
            Precio: <input type="number" step="0.01" name="precio" value="<?php echo $pre_edit; ?>" required>
            Stock: <input type="number" name="stock" value="<?php echo $stk_edit; ?>" required>
            <button type="submit" name="guardar" style="background: green; color: white;">Guardar Datos</button>
        </form>
    </div>

    <!-- Tabla para Leer (Read) -->
    <table border="1" style="width: 100%; border-collapse: collapse; text-align: left;">
        <tr style="background: #333; color: white;">
            <th>ID</th><th>Nombre</th><th>Precio</th><th>Stock</th><th>Acciones</th>
        </tr>
        <?php
        $result = $conn->query("SELECT * FROM refacciones ORDER BY id DESC");
        while ($fila = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $fila['id'] . "</td>";
            echo "<td>" . $fila['nombre'] . "</td>";
            echo "<td>$" . $fila['precio'] . "</td>";
            echo "<td>" . $fila['stock'] . "</td>";
            echo "<td>
                    <a href='admin.php?edit=" . $fila['id'] . "' style='color: blue;'>Editar</a> | 
                    <a href='admin.php?del=" . $fila['id'] . "' onclick=\"return confirm('¿Estás seguro de eliminar este registro de la base de datos?');\" style='color: red;'>Eliminar</a>
                  </td>";
            echo "</tr>";
        }
        ?>
    </table>
</body>
</html>
