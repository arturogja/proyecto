<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <!-- Enlazar Bootstrap CSS y SB Admin 2 CSS -->
    <link href="sb-admin-2/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Bootstrap core JavaScript-->
    <script src="sb-admin-2/vendor/jquery/jquery.min.js"></script>
    <script src="sb-admin-2/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <link href="css/estilo.css" rel="stylesheet">
</head>

<body id="page-top">

    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
                <div class="sidebar-brand-icon">
                    <i class="fas fa-user"></i>
                </div>
                <div class="sidebar-brand-text mx-3">SB Admin 2</div>
            </a>

            <hr class="sidebar-divider my-0">

            <hr class="sidebar-divider">

            <div class="sidebar-heading">Funciones</div>

            <!-- Enlace a Usuarios -->
            <li class="nav-item">
                <a class="nav-link" href="index.php?view=users">
                    <i class="fas fa-users"></i>
                    <span>Usuarios</span>
                </a>
            </li>

            <!-- Enlace a Registro de Usuarios -->
            <li class="nav-item">
                <a class="nav-link" href="index.php?view=register">
                    <i class="fas fa-user-plus"></i>
                    <span>Registrar Usuario</span>
                </a>
            </li>

            <hr class="sidebar-divider d-none d-md-block">

            <li class="nav-item">
                <a class="nav-link text-white" href="logout.php">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Cerrar Sesión</span>
                </a>
            </li>

        </ul>
        <!-- Fin de Sidebar -->

        <!-- Contenido de la página -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">

                <!-- Encabezado -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <h1 class="h3 mb-0 text-gray-800">Panel de Administración</h1>
                </nav>
                <!-- Fin de Encabezado -->

                <!-- Contenido Principal -->
                <div class="container-fluid">
                    <?php
                    if (isset($_GET['view'])) {
                        $view = $_GET['view'];

                        switch ($view) {
                            case 'dashboard':
                                require_once __DIR__ . '/../src/views/dashboard.php';
                                break;
                            case 'users':
                                require_once __DIR__ . '/../src/views/users.php';
                                break;
                            case 'register':
                                require_once __DIR__ . '/../src/views/user_register.php';
                                break;
                            default:
                                echo '<h3 class="text-danger">Vista no encontrada</h3>';
                        }
                    } else {
                        require_once __DIR__ . '/../src/views/users.php'; // Vista predeterminada
                    }
                    ?>
                </div>
                <!-- Fin del Contenido Principal -->

            </div>
        </div>
        <!-- Fin del Contenido -->
    </div>

    <!-- Core plugin JavaScript-->
    <script src="sb-admin-2/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="sb-admin-2/js/sb-admin-2.min.js"></script>

</body>

</html>