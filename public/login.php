<?php
session_start();
require_once __DIR__ . '/../src/controllers/UserApiController.php';

$userApiController = new UserApiController();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userApiController->login($_POST); // Procesar el inicio de sesión
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link href="sb-admin-2/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="sb-admin-2/js/sb-admin-2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="bg-gradient-primary">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Formulario de inicio de sesión -->
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">¡Bienvenido!</h1>
                            </div>

                            <?php if (isset($error) && $error): ?>
                                <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                            <?php endif; ?>

                            <form action="login.php" method="POST">
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control form-control-user" placeholder="Correo Electrónico" required>
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" class="form-control form-control-user" placeholder="Contraseña" required>
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block">Iniciar Sesión</button>
                            </form>
                            
                            <?php if (isset($_SESSION['error'])): ?>
                                <div class="alert alert-danger mt-3">
                                    <?php echo htmlspecialchars($_SESSION['error']); ?>
                                </div>
                                <?php unset($_SESSION['error']); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="sb-admin-2/js/sb-admin-2.min.js"></script>
</body>

</html>
