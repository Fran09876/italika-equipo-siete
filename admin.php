<?php
session_start();
if (!isset($_SESSION['logueado'])) {
    header('Location: login.php');
    exit;
}

$conn = new mysqli('localhost', 'dev_user', 'tso*25', 'italikasiete');
if ($conn->connect_error) { die("Error de conexión: " . $conn->connect_error); }

// Eliminar
if (isset($_GET['del'])) {
    $id = $_GET['del'];
    $conn->query("DELETE FROM refacciones WHERE id=$id");
    header("Location: admin.php");
}

// Guardar / Actualizar
if (isset($_POST['guardar'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];

    if ($id != '') { 
        $conn->query("UPDATE refacciones SET nombre='$nombre', precio=$precio, stock=$stock WHERE id=$id");
    } else { 
        $conn->query("INSERT INTO refacciones (nombre, precio, stock) VALUES ('$nombre', $precio, $stock)");
    }
    header("Location: admin.php");
}

// Cargar para Editar
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración | Italika</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>.bg-italika { background-color: #002654; } .text-italika { color: #002654; }</style>
</head>
<body class="bg-gray-100 font-sans antialiased text-gray-800 pb-10">

    <nav class="bg-italika text-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-3 flex flex-col md:flex-row justify-between items-center gap-4">
            <h2 class="text-xl font-bold tracking-wide">📦 Control de Inventario</h2>
            <a href="index.php" class="bg-red-600 hover:bg-red-700 px-5 py-2 rounded text-sm font-bold transition shadow flex items-center gap-2">
                Cerrar Sesión
            </a>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 py-8">
        
        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200 mb-6 flex flex-col md:flex-row justify-between items-center gap-4">
            
            <div class="flex w-full md:w-1/2 relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">🔍</span>
                <input type="text" id="buscadorEnVivo" placeholder="Buscar por nombre o ID (Ej: 15, bujía)..." 
                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 outline-none bg-gray-50 transition shadow-sm">
            </div>

            <button onclick="document.getElementById('form-container').classList.toggle('hidden')" 
                class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-bold transition shadow flex items-center gap-2 w-full md:w-auto justify-center">
                ➕ Nuevo Producto
            </button>
        </div>

        <div id="form-container" class="<?php echo ($id_edit != '') ? '' : 'hidden'; ?> bg-white p-6 rounded-lg shadow-md border-t-4 border-green-500 mb-8 transition-all">
            <h3 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b">
                <?php echo ($id_edit != '') ? '✏️ Editando Producto #'.$id_edit : '➕ Registrar Nueva Refacción'; ?>
            </h3>
            
            <form method="POST" action="admin.php" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                <input type="hidden" name="id" value="<?php echo $id_edit; ?>">
                
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-gray-700 mb-1">Nombre de la refacción</label>
                    <input type="text" name="nombre" value="<?php echo $nom_edit; ?>" required 
                        class="w-full px-3 py-2 border border-gray-300 rounded focus:ring-2 focus:ring-green-500 outline-none bg-gray-50">
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Precio ($)</label>
                    <input type="number" step="0.01" name="precio" value="<?php echo $pre_edit; ?>" required 
                        class="w-full px-3 py-2 border border-gray-300 rounded focus:ring-2 focus:ring-green-500 outline-none bg-gray-50">
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Stock disponible</label>
                    <div class="flex gap-2">
                        <input type="number" name="stock" value="<?php echo $stk_edit; ?>" required 
                            class="w-full px-3 py-2 border border-gray-300 rounded focus:ring-2 focus:ring-green-500 outline-none bg-gray-50">
                        <button type="submit" name="guardar" class="bg-italika hover:bg-blue-900 text-white px-4 py-2 rounded font-bold transition shadow w-full">
                            Guardar
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full whitespace-nowrap text-left border-collapse">
                    <thead class="bg-gray-100 border-b-2 border-gray-300 text-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-xs font-black uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-xs font-black uppercase tracking-wider">Producto</th>
                            <th class="px-6 py-3 text-xs font-black uppercase tracking-wider">Precio</th>
                            <th class="px-6 py-3 text-xs font-black uppercase tracking-wider">Stock</th>
                            <th class="px-6 py-3 text-xs font-black uppercase tracking-wider text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tablaRefacciones" class="divide-y divide-gray-200">
                        <?php
                        $result = $conn->query("SELECT * FROM refacciones ORDER BY id DESC");
                        
                        if ($result->num_rows > 0) {
                            while ($fila = $result->fetch_assoc()) {
                                echo "<tr class='hover:bg-blue-50 transition producto-row'>";
                                // Agregada la clase 'id-producto' para el buscador
                                echo "<td class='px-6 py-4 text-sm text-gray-500 font-bold id-producto'>#" . $fila['id'] . "</td>";
                                echo "<td class='px-6 py-4 text-sm text-gray-900 font-medium nombre-producto'>" . htmlspecialchars($fila['nombre']) . "</td>";
                                echo "<td class='px-6 py-4 text-sm text-italika font-black'>$" . number_format($fila['precio'], 2) . "</td>";
                                
                                $stockClass = ($fila['stock'] < 5) ? 'text-red-600 bg-red-100' : 'text-gray-700 bg-gray-100';
                                echo "<td class='px-6 py-4 text-sm'><span class='px-2 py-1 rounded font-bold $stockClass'>" . $fila['stock'] . " u.</span></td>";
                                
                                echo "<td class='px-6 py-4 text-sm text-center space-x-2'>
                                        <a href='admin.php?edit=" . $fila['id'] . "' class='inline-block bg-blue-100 text-blue-700 px-3 py-1 rounded text-xs font-bold hover:bg-blue-200 transition'>✏️ Editar</a>
                                        <a href='admin.php?del=" . $fila['id'] . "' onclick=\"return confirm('¿Seguro que deseas eliminar este producto permanentemente?');\" class='inline-block bg-red-100 text-red-700 px-3 py-1 rounded text-xs font-bold hover:bg-red-200 transition'>🗑️ Borrar</a>
                                      </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5' class='px-6 py-8 text-center text-gray-500 font-medium'>El inventario está vacío.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
                
                <div id="mensajeVacio" class="hidden p-8 text-center text-gray-500 font-medium">
                    No se encontró ninguna refacción que coincida con tu búsqueda.
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('buscadorEnVivo').addEventListener('input', function() {
            const textoBuscado = this.value.toLowerCase().trim();
            const filas = document.querySelectorAll('.producto-row');
            let filasVisibles = 0;

            filas.forEach(fila => {
                const nombre = fila.querySelector('.nombre-producto').textContent.toLowerCase();
                // Limpiamos el # del ID para que coincida si el usuario solo teclea el número
                const id = fila.querySelector('.id-producto').textContent.toLowerCase().replace('#', '');
                
                // Si el texto buscado está en el nombre o en el ID, mostramos la fila
                if (nombre.includes(textoBuscado) || id.includes(textoBuscado)) {
                    fila.style.display = '';
                    filasVisibles++;
                } else {
                    fila.style.display = 'none';
                }
            });

            // Mostrar u ocultar el mensaje de "No hay resultados"
            const mensajeVacio = document.getElementById('mensajeVacio');
            if (filasVisibles === 0 && filas.length > 0) {
                mensajeVacio.classList.remove('hidden');
            } else {
                mensajeVacio.classList.add('hidden');
            }
        });
    </script>
</body>
</html>