<?php
session_start();
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    if ($usuario === '22161204@itoaxaca.edu.mx' && $password === '22161204ITO') {
        $_SESSION['logueado'] = true;
        header('Location: admin.php');
        exit;
    } else {
        $error = 'Credenciales incorrectas. Acceso denegado.';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Administración</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>.bg-italika { background-color: #002654; }</style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen font-sans bg-cover bg-center" style="background-image: url('https://www.transparenttextures.com/patterns/cubes.png');">
    
    <div class="bg-white p-8 rounded-xl shadow-2xl w-full max-w-md border-t-4 border-italika">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-black italic text-gray-900 tracking-wider">ITALIKA<span class="text-italika">®</span></h2>
            <p class="text-gray-500 text-sm mt-1 font-bold">Iniciar sesión</p>
        </div>

        <?php if ($error): ?>
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
                <p class="text-sm font-medium"><?php echo $error; ?></p>
            </div>
        <?php endif; ?>

        <form method="POST" action="" class="space-y-5">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Usuario Institucional</label>
                <input type="email" name="usuario" required 
                    class="w-full px-4 py-3 border border-gray-300 rounded focus:ring-2 focus:ring-blue-900 focus:border-blue-900 outline-none transition bg-gray-50">
            </div>
            
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Contraseña</label>
                <input type="password" name="password" required 
                    class="w-full px-4 py-3 border border-gray-300 rounded focus:ring-2 focus:ring-blue-900 focus:border-blue-900 outline-none transition bg-gray-50">
            </div>
            
            <button type="submit" 
                class="w-full bg-italika hover:bg-blue-900 text-white font-bold py-3 px-4 rounded transition duration-200 shadow-md uppercase tracking-wide mt-4">
                Ingresar al Sistema
            </button>
        </form>

        <div class="mt-8 text-center">
            <a href="index.php" class="text-sm text-gray-400 hover:text-italika transition">← Volver a la tienda pública</a>
        </div>
    </div>

</body>
</html>