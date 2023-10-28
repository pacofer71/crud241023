<?php
session_start();

use App\Db\Conexion;
use App\Db\Usuario;

require_once __DIR__ . "/../vendor/autoload.php";

Usuario::datosPrueba(100);
//$datos = Usuario::read();


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Tailwind css -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Document</title>
</head>

<body style="background-color:blanchedalmond">
    <h3 class="text-2xl text-center mt-4">Listado de Usuarios</h3>
    <div class="container p-8 mx-auto">
        <div class="flex flex-row-reverse mb-1">
            <a href="create.php" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                <i class="fas fa-add mr-2"></i> Crear Usuario</a>
        </div>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Nombre Usuario
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Email
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Provincia
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Perfil
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach (Usuario::read() as $usuario) {
                        $clase = $usuario->perfil == 'Admin' ? 'text-red-500' : 'text-green-500';
                        echo <<<TXT
                    <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {$usuario->apellidos}, {$usuario->nombre}
                        </th>
                        <td class="px-6 py-4">
                            {$usuario->email}
                        </td>
                        <td class="px-6 py-4">
                            {$usuario->provincia}
                        </td>
                        <td class="px-6 py-4 $clase">
                            {$usuario->perfil}
                        </td>
                        <td class="px-6 py-4">
                            <form method="POST" action="delete.php">
                            <input name='id' type="hidden" value='{$usuario->id}' />
                            <a href="update.php?id={$usuario->id}"><i class="fas fa-edit text-white"></i></a>
                            <button type="submit" class="ml-2"><i class="fas fa-trash text-white"></i></button>
                            </form>
                        </td>
                    </tr>
                    TXT;
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </div>
    <?php
    if (isset($_SESSION['mensaje'])) {
        echo <<<TXT
        <script>
        Swal.fire({
            icon: 'success',
            title: '{$_SESSION['mensaje']}',
            showConfirmButton: false,
            timer: 1500
          })
          </script>
        TXT;
        unset($_SESSION['mensaje']);
    }
    ?>

</body>

</html>