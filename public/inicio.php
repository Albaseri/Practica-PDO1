<?php

use App\Db\Producto;

session_start();

require_once __DIR__ . "/../vendor/autoload.php";
$productos = Producto::read();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Fontawesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>Listado de productos</title>
</head>

<body style="background-color:beige">
    <h1 class="flex justify-center font-bold text-blue-800 m-10 text-xl">LISTADO DE PRODUCTOS</h1>
    <div class="container p-12 mx-auto">
        <div class="flex flex-row-reverse mb-3">
            <a href="create.php" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-add mr-2"></i>Crear nuevo producto
            </a>
        </div>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-l text-gray-700 uppercase bg-gray-50 dark:bg-blue-200 dark:text-black-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            NOMBRE DEL PRODUCTO
                        </th>

                        <th scope="col" class="px-6 py-3">
                            PRECIO

                        </th>
                        <th scope="col" class="px-6 py-3">
                            ACCIÓN
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($productos as $producto) {

                        echo <<<TXT
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {$producto->nombre}
                    </th>
                  
                    <td class="px-6 py-4 whitespace-nowrap text-gray-300">
                        {$producto->precio} €
                    </td>
                    <td class="px-6 py-4" whitespace-nowrap>
                         <form action="delete.php" method="POST">
                            <input type="hidden" name="codigo" value="{$producto->codigo}"/>
                                <a href="detalle.php?codigo={$producto->codigo}"><i class="fas fa-info text-blue-600 mr-2"></i></a>
                                <a href="update.php?codigo={$producto->codigo}"><i class="fa-solid fa-file-pen" style="color: #b1b941; mr-2"></i></a>
                                <button type="submit"><i class="fas fa-trash text-red-600"></i></button>
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
    if (isset($_SESSION['mensajeExito'])) {
        echo <<<TXT
    <script>
    Swal.fire({
        icon: 'success',
        title: '{$_SESSION['mensajeExito']}',
        showConfirmButton: false,
        timer: 1500
    })
    </script>
    TXT;
        unset($_SESSION['mensajeExito']);
    }
    ?>
</body>

</html>