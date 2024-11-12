<?php
require_once __DIR__ . '/../db/Database.php';

class UserModel
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
    }


    public function getAllUsers()
    {
        $stmt = $this->db->query('SELECT * FROM users WHERE deleted_at IS NULL');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserByEmail($email)
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE email = :email AND deleted_at IS NULL');
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createUser($name, $last_name, $second_last_name, $phone, $email, $password)
    {
        try {
            // Comprobar si el correo ya existe y está activo
            $stmt = $this->db->prepare('SELECT id FROM users WHERE email = :email AND deleted_at IS NULL');
            $stmt->execute(['email' => $email]);
            $existingUser = $stmt->fetch();

            if ($existingUser) {
                throw new Exception('El correo electrónico ya está registrado.');
            }

            // Insertar nuevo usuario
            $stmt = $this->db->prepare('INSERT INTO users (name, last_name, second_last_name, phone, email, password, created_at) 
                                    VALUES (:name, :last_name, :second_last_name, :phone, :email, :password, NOW())');
            return $stmt->execute([
                'name' => $name,
                'last_name' => $last_name,
                'second_last_name' => $second_last_name,
                'phone' => $phone,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_BCRYPT),
            ]);
        } catch (PDOException $e) {
            throw new Exception('Error al registrar el usuario: ' . $e->getMessage());
        }
    }


    public function updateUser($data)
    {
        $query = "UPDATE users 
                  SET name = ?, last_name = ?, second_last_name = ?, phone = ?, email = ? 
                  WHERE id = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            $data['name'],
            $data['last_name'],
            $data['second_last_name'],
            $data['phone'],
            $data['email'],
            $data['id']
        ]);
    }

    public function deleteUser($id)
    {
        // Preparar la consulta para actualizar el campo deleted_at
        $stmt = $this->db->prepare('UPDATE users SET deleted_at = NOW() WHERE id = :id');
        $stmt->execute(['id' => $id]);

        // Verificar si se actualizó al menos una fila (lo que significa que el usuario fue "eliminado")
        if ($stmt->rowCount() > 0) {
            return true; 
        } else {
            return false; 
        }
    }
}
