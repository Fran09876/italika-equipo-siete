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
    <title>Login - Administración</title>
</head>
<body style="font-family: Arial, sans-serif; text-align: center; margin-top: 100px;">
    <h2>Acceso al Sistema CRUD</h2>
    <form method="POST" action="" style="display: inline-block; text-align: left; background: #eee; padding: 20px; border-radius: 8px;">
        <label>Usuario (Correo Institucional):</label><br>
        <input type="email" name="usuario" required style="width: 250px; margin-bottom: 15px;"><br>
        
        <label>Contraseña:</label><br>
        <input type="password" name="password" required style="width: 250px; margin-bottom: 15px;"><br>
        
        <button type="submit" style="padding: 10px 20px; background: #d32f2f; color: white; border: none; cursor: pointer;">Entrar</button>
    </form>
    <p style="color: red;"><?php echo $error; ?></p>
</body>
</html>
