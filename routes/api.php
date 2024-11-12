<?php
require_once __DIR__ . '/../src/controllers/UserApiController.php';

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');

if (!isset($_SERVER['PHP_AUTH_USER'])) {
    header("WWW-Authenticate: Basic realm=\"Private Area\"");
    header('HTTP/1.0 401 Unauthorized');
    echo 'No autorizado';
    exit;
} else {
    if (($_SERVER['PHP_AUTH_USER'] == 'test' && ($_SERVER['PHP_AUTH_PW'] == 'test123'))) {
    } else {
        header("WWW-Authenticate: Basic realm=\"Private Area\"");
        header('HTTP/1.0 401 Unauthorized');
        print 'No autorizado';
        exit;
    }
}

$requestMethod = $_SERVER['REQUEST_METHOD'];
$action = $_GET['action'] ?? null;

$userApiController = new UserApiController();

try {
    switch ($action) {
        case 'getAllUsers':
            if ($requestMethod === 'GET') {
                $userApiController->getAllUsers();
            } else {
                http_response_code(405);
                echo json_encode(['error' => 'Método no permitido']);
            }
            break;

        case 'getUserByEmail':
            if ($requestMethod === 'GET') {
                $email = $_GET['email'] ?? null;
                if (!$email) {
                    http_response_code(400);
                    echo json_encode(['error' => 'El parámetro email es requerido']);
                } else {
                    $user = $userApiController->getUserByEmail($email);
                    echo json_encode($user);
                }
            } else {
                http_response_code(405);
                echo json_encode(['error' => 'Método no permitido']);
            }
            break;

        case 'createUser':
            if ($requestMethod === 'POST') {
                $input = json_decode(file_get_contents('php://input'), true);
                if (
                    isset($input['name'], $input['last_name'], $input['second_last_name'], $input['phone'], $input['email'], $input['password'])
                ) {
                    $created = $userApiController->createUser(
                        $input['name'],
                        $input['last_name'],
                        $input['second_last_name'],
                        $input['phone'],
                        $input['email'],
                        $input['password']
                    );
                    if ($created) {
                        echo json_encode(['success' => 'Usuario creado']);
                    } else {
                        http_response_code(500);
                        echo json_encode(['error' => 'No se pudo crear el usuario']);
                    }
                } else {
                    http_response_code(400);
                    echo json_encode(['error' => 'Datos incompletos']);
                }
            } else {
                http_response_code(405);
                echo json_encode(['error' => 'Método no permitido']);
            }
            break;
        case 'updateUser':
            if ($requestMethod === 'PUT') {
                $input = json_decode(file_get_contents('php://input'), true);
                if (isset($input['id'], $input['name'], $input['last_name'], $input['second_last_name'], $input['phone'], $input['email'])) {
                    $updated = $userApiController->updateUser($input);
                    if ($updated) {
                        echo json_encode(['success' => 'Usuario actualizado correctamente']);
                    } else {
                        http_response_code(500);
                        echo json_encode(['error' => 'No se pudo actualizar el usuario']);
                    }
                } else {
                    http_response_code(400);
                    echo json_encode(['error' => 'Datos incompletos']);
                }
            } else {
                http_response_code(405);
                echo json_encode(['error' => 'Método no permitido']);
            }
            break;
        case 'deleteUser':
            if ($requestMethod === 'DELETE') {
                $input = json_decode(file_get_contents('php://input'), true);
                if (isset($input['id'])) {
                    $deleted = $userApiController->deleteUser($input['id']);
                    if ($deleted) {
                        echo json_encode(['success' => 'Usuario eliminado correctamente']);
                    } else {
                        http_response_code(500);
                        echo json_encode(['error' => 'No se pudo eliminar el usuario']);
                    }
                } else {
                    http_response_code(400);
                    echo json_encode(['error' => 'El parámetro ID es requerido']);
                }
            } else {
                http_response_code(405);
                echo json_encode(['error' => 'Método no permitido']);
            }
            break;

        default:
            http_response_code(404);
            echo json_encode(['error' => 'Acción no encontrada']);
            break;
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
