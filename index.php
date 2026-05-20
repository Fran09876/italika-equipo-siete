<?php
// Conexión de solo lectura para la vista pública usando al usuario auditor
$conn = new mysqli('localhost', 'audit_user', 'auditor123', 'italikasiete');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Refaccionaria Italika | El motor de tu vida</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .bg-italika { background-color: #002654; }
        .text-italika { color: #002654; }
    </style>
</head>
<body class="bg-gray-100 font-sans text-gray-800 antialiased flex flex-col min-h-screen">
    
    <header class="bg-italika text-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-black italic tracking-wider flex items-center gap-2">
                ITALIKA<span class="text-sm font-normal not-italic text-gray-300">® Refacciones</span>
            </h1>
            <nav class="hidden md:flex space-x-8 items-center text-sm font-medium">
                <a href="index.php" class="hover:text-blue-200 transition pb-1 border-b-2 border-transparent hover:border-white">Motocicletas</a>
                <a href="#productos" class="hover:text-blue-200 transition pb-1 border-b-2 border-transparent hover:border-white">Refacciones</a>
                <a href="login.php" class="bg-white text-italika px-5 py-2 rounded-full font-bold hover:bg-gray-100 transition shadow flex items-center gap-2">
                    👤 Iniciar sesión
                </a>
            </nav>
        </div>
    </header>

    <main class="flex-grow">
        <section class="bg-white border-b border-gray-200 overflow-hidden">
            <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between px-4 py-12 md:py-16">
                <div class="md:w-1/2 text-center md:text-left mb-8 md:mb-0">
                    <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4 leading-tight">MANTÉN TU ITALIKA <br><span class="text-italika">SIEMPRE AL 100%</span></h2>
                    <p class="text-lg text-gray-600 mb-8 max-w-lg mx-auto md:mx-0">Refacciones originales, accesorios y todo lo que necesitas para que tu motor nunca se detenga. Calidad garantizada en cada pieza.</p>
                    <a href="#productos" class="bg-italika text-white px-8 py-3 rounded-full font-bold hover:bg-blue-900 transition shadow-lg inline-block">Ver Catálogo</a>
                </div>
                <div class="md:w-1/2 flex justify-center md:justify-end">
                    <img src="https://images.unsplash.com/photo-1558981403-c5f9899a28bc?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Motocicleta Italika" class="rounded-xl shadow-2xl border-4 border-white object-cover h-72 w-full max-w-md transform hover:scale-105 transition duration-500">
                </div>
            </div>
        </section>

        <section id="productos" class="max-w-7xl mx-auto py-16 px-4">
            <div class="mb-10 border-l-4 border-italika pl-4">
                <h2 class="text-2xl font-bold text-gray-900 uppercase">Productos Destacados</h2>
                <p class="text-gray-500">Encuentra las piezas más buscadas por nuestra comunidad.</p>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <?php
                if (!$conn->connect_error) {
                    $result = $conn->query("SELECT nombre, precio FROM refacciones LIMIT 12");
                    while ($fila = $result->fetch_assoc()) {
                        echo "
                        <div class='bg-white p-5 rounded-lg shadow hover:shadow-xl transform hover:-translate-y-1 transition duration-300 border border-gray-100 flex flex-col justify-between'>
                            
                            <div class='h-32 bg-gray-50 rounded mb-4 flex flex-col items-center justify-center text-italika opacity-60'>
                                <svg class='w-10 h-10 mb-2' fill='none' stroke='currentColor' viewBox='0 0 24 24'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z'></path><path stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M15 12a3 3 0 11-6 0 3 3 0 016 0z'></path></svg>
                                <span class='text-xs font-bold tracking-wider uppercase'>Original</span>
                            </div>

                            <h4 class='text-sm font-semibold text-gray-700 mb-3 leading-tight h-10 overflow-hidden'>" . htmlspecialchars($fila['nombre']) . "</h4>
                            <div class='flex justify-between items-center mt-auto'>
                                <p class='text-xl font-black text-italika'>$" . number_format($fila['precio'], 2) . "</p>
                                <span class='text-xs font-bold text-green-600 bg-green-100 px-2 py-1 rounded'>En stock</span>
                            </div>
                        </div>";
                    }
                } else {
                    echo "<div class='col-span-full text-center p-8 bg-red-50 text-red-600 rounded-lg'>Catálogo no disponible en este momento.</div>";
                }
                ?>
            </div>
        </section>
    </main>

    <footer class="bg-gray-900 text-gray-400 py-10 border-t-4 border-italika mt-auto">
        <div class="max-w-7xl mx-auto text-center px-4">
            <p class="text-sm font-bold text-white mb-2">Refaccionaria Italika - Equipo 7</p>
            <p class="text-xs">Taller de Sistemas Operativos &copy; 2026. Todos los derechos reservados.</p>
        </div>
    </footer>
</body>
</html>