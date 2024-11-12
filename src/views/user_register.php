<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
</head>

<body>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Registro de Usuario</h6>
        </div>
        <div class="card-body">
            <form id="registerForm">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="name">Nombre:</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="last_name">Primer Apellido:</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="second_last_name">Segundo Apellido:</label>
                            <input type="text" class="form-control" id="second_last_name" name="second_last_name" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="phone">Teléfono:</label>
                            <input type="text" class="form-control" id="phone" name="phone" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="email">Correo Electrónico:</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="password">Contraseña:</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Registrar</button>
                </div>
            </form>
            <div id="responseMessage" class="mt-3"></div>
        </div>
    </div>

    <div class="modal fade" id="responseModal" tabindex="-1" aria-labelledby="responseModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="responseModalLabel">Mensaje</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modalMessage">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Función para convertir a mayúsculas automáticamente
            function convertToUppercase(input) {
                input.value = input.value.toUpperCase();
            }

            $('#name, #last_name, #second_last_name').on('input', function() {
                convertToUppercase(this);
            });

            // Validación para solo números y limitar a 10 caracteres
            $('#phone').on('input', function() {
                // Remueve caracteres no numéricos
                this.value = this.value.replace(/[^0-9]/g, '');

                // Limita a 10 caracteres
                if (this.value.length > 10) {
                    this.value = this.value.slice(0, 10);
                }
            });

            $('#registerForm').submit(function(e) {
                e.preventDefault();

                const phone = $('#phone').val();
                if (phone.length !== 10) {
                    $('#responseMessage').html(
                        `<div class="alert alert-danger">El número de teléfono debe tener exactamente 10 dígitos.</div>`
                    );
                    return;
                }

                // Recopilar datos del formulario
                const formData = {
                    name: $('#name').val(),
                    last_name: $('#last_name').val(),
                    second_last_name: $('#second_last_name').val(),
                    phone: phone,
                    email: $('#email').val(),
                    password: $('#password').val(),
                };

                $.ajax({
                    url: '../routes/api.php?action=createUser',
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify(formData),
                    success: function(response) {
                        showModal('Usuario registrado correctamente.', 'Éxito');
                        $('#registerForm')[0].reset();
                    },
                    error: function(xhr) {
                        let errorMessage = 'Error desconocido al registrar usuario.';
                        try {
                            const response = JSON.parse(xhr.responseText);
                            if (response.error) {
                                errorMessage = response.error;
                            }
                        } catch (e) {
                            console.error('Error al parsear respuesta JSON:', e);
                        }
                        showModal(errorMessage, 'Error');
                    },
                });
            });

            function showModal(message, title) {
                $('#modalMessage').text(message);
                $('#responseModalLabel').text(title);
                $('#responseModal').modal('show');
            }
        });
    </script>
</body>

</html>