<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuarios</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>

<body>
    <!-- Tabla de usuarios -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Usuarios Registrados</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Primer apellido</th>
                            <th>Segundo apellido</th>
                            <th>Télefono</th>
                            <th>Email</th>
                            <th>Fecha de Creación</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal para editar usuario -->
    <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Editar Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editUserForm" action="update_user.php" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="edit-id">
                        <div class="form-group">
                            <label for="edit-name">Nombre</label>
                            <input type="text" class="form-control" name="name" id="edit-name" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-last-name">Primer Apellido</label>
                            <input type="text" class="form-control" name="last_name" id="edit-last-name" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-second-last-name">Segundo Apellido</label>
                            <input type="text" class="form-control" name="second_last_name" id="edit-second-last-name" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-phone">Teléfono</label>
                            <input type="text" class="form-control" name="phone" id="edit-phone" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-email">Correo Electrónico</label>
                            <input type="email" class="form-control" name="email" id="edit-email" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de confirmación de eliminación -->
    <div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteUserModalLabel">Confirmar Eliminación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que deseas eliminar este usuario? Esta acción no se puede deshacer.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <form id="deleteUserForm">
                        <input type="hidden" name="id" id="delete-id">
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="messageModal" tabindex="-1" role="dialog" aria-labelledby="messageModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="messageModalLabel">Mensaje</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="messageText">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>


    <script>
        // Cargar los usuarios
        const loadUsers = async () => {
            try {
                const response = await fetch('../routes/api.php?action=getAllUsers');
                if (!response.ok) {
                    throw new Error('Error al obtener los usuarios');
                }
                const users = await response.json();

                const tableBody = document.querySelector('tbody');
                tableBody.innerHTML = '';
                users.forEach(user => {
                    const row = `
                        <tr>
                            <td>${user.id}</td>
                            <td>${user.name}</td>
                            <td>${user.last_name}</td>
                            <td>${user.second_last_name}</td>
                            <td>${user.phone}</td>
                            <td>${user.email}</td>
                            <td>${user.created_at}</td>
                            <td>
                                <button class="btn btn-sm btn-primary edit-btn" 
                                    data-id="${user.id}" 
                                    data-name="${user.name}" 
                                    data-last_name="${user.last_name}" 
                                    data-second_last_name="${user.second_last_name}" 
                                    data-phone="${user.phone}" 
                                    data-email="${user.email}" 
                                    data-toggle="modal" 
                                    data-target="#editUserModal">Editar</button>
                                <button class="btn btn-sm btn-danger delete-btn" 
                                    data-id="${user.id}" 
                                    data-toggle="modal" 
                                    data-target="#deleteUserModal">Eliminar</button>
                            </td>
                        </tr>
                    `;
                    tableBody.innerHTML += row;
                });

                document.querySelectorAll('.edit-btn').forEach(button => {
                    button.addEventListener('click', () => {
                        document.getElementById('edit-id').value = button.dataset.id;
                        document.getElementById('edit-name').value = button.dataset.name;
                        document.getElementById('edit-last-name').value = button.dataset.last_name;
                        document.getElementById('edit-second-last-name').value = button.dataset.second_last_name;
                        document.getElementById('edit-phone').value = button.dataset.phone;
                        document.getElementById('edit-email').value = button.dataset.email;
                    });
                });
            } catch (error) {
                console.error('Error:', error);
            }
        };

        document.addEventListener('DOMContentLoaded', () => {
            loadUsers();
        });

        $(document).ready(function() {
            // Función para convertir a mayúsculas automáticamente
            function convertToUppercase(input) {
                input.value = input.value.toUpperCase();
            }

            $('#edit-name, #edit-last-name, #edit-second-last-name').on('input', function() {
                convertToUppercase(this);
            });

            // Validación para solo números y limitar a 10 caracteres
            $('#edit-phone').on('input', function() {
                // Remueve caracteres no numéricos
                this.value = this.value.replace(/[^0-9]/g, '');

                // Limita a 10 caracteres
                if (this.value.length > 10) {
                    this.value = this.value.slice(0, 10);
                }
            });

            // Enviar la actualización de un usuario
            $('#editUserForm').submit(function(e) {
                e.preventDefault(); // Evita el envío tradicional del formulario

                const formData = {
                    id: $('#edit-id').val(),
                    name: $('#edit-name').val(),
                    last_name: $('#edit-last-name').val(),
                    second_last_name: $('#edit-second-last-name').val(),
                    phone: $('#edit-phone').val(),
                    email: $('#edit-email').val(),
                };

                $.ajax({
                    url: '../routes/api.php?action=updateUser',
                    type: 'PUT',
                    contentType: 'application/json',
                    data: JSON.stringify(formData),
                    success: function(response) {
                        showMessage('Usuario actualizado correctamente', 'success');
                        $('#editUserModal').modal('hide');
                        loadUsers(); 
                    },
                    error: function(xhr) {
                        showMessage('Error al actualizar el usuario: ' + xhr.responseText, 'error');
                    },
                });
            });

            // Eliminar usuario
            $(document).on('click', '.delete-btn', function() {
                const userId = $(this).data('id'); 
                $('#delete-id').val(userId); 
            });

            $('#deleteUserForm').submit(function(e) {
                e.preventDefault();

                const userId = $('#delete-id').val();

                $.ajax({
                    url: '../routes/api.php?action=deleteUser',
                    type: 'DELETE',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        id: userId
                    }),
                    success: function(response) {
                        showMessage('Usuario eliminado correctamente', 'success');
                        $('#deleteUserModal').modal('hide');
                        loadUsers();
                    },
                    error: function(xhr) {
                        showMessage('Error al eliminar el usuario: ' + xhr.responseText, 'error');
                    },
                });
            });
        });

        // Función para mostrar los mensajes en el modal
        function showMessage(message, type) {
            const messageText = $('#messageText');
            messageText.text(message);
            $('#messageModal').modal('show'); 
        }
    </script>
</body>

</html>