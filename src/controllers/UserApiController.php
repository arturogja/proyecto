<?php

require_once __DIR__ . '/../models/UserModel.php';

class UserApiController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('HTTP/1.1 405 Method Not Allowed');
            exit('Método no permitido');
        }

        $email = $_POST['email'] ?? null;
        $password = $_POST['password'] ?? null;

        if (!$email || !$password) {
            $this->setSessionError('Por favor, ingrese el correo y la contraseña.');
            return;
        }

        $user = $this->userModel->getUserByEmail($email);

        if (!$user || $user['deleted_at'] !== null) {
            $this->setSessionError('El usuario no existe o está inactivo.');
            return;
        }

        if (!password_verify($password, $user['password'])) {
            $this->setSessionError('La contraseña es incorrecta.');
            return;
        }

        // Inicia sesión si las credenciales son válidas
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];

        // Redirige al dashboard
        header('Location: index.php');
        exit;
    }

    private function setSessionError($message)
    {
        session_start();
        $_SESSION['error'] = $message;
        header('Location: login.php');
        exit;
    }

    public function getAllUsers()
    {
        $users = $this->userModel->getAllUsers();
        echo json_encode($users);
    }

    public function getUserByEmail($email)
    {
        return $this->userModel->getUserByEmail($email);
    }

    public function createUser($name, $last_name, $second_last_name, $phone, $email, $password)
    {
        try {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $created = $this->userModel->createUser($name, $last_name, $second_last_name, $phone, $email, $hashedPassword);
            return $created;
        } catch (Exception $e) {
            throw new Exception('Error al crear el usuario: ' . $e->getMessage());
        }
    }

    public function updateUser($data)
    {
        $userModel = new UserModel();
        return $userModel->updateUser($data);
    }

    public function deleteUser($id)
    {
        $userModel = new UserModel();
        return $userModel->deleteUser($id);
    }
}
