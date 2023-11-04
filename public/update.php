<?php

use App\Db\Producto;
use App\Utils\Validar;

require_once __DIR__ . "/../vendor/autoload.php";

if (!isset($_GET['codigo'])) {
    header("Location:inicio.php");
    die();
}

session_start();

$codigo = $_GET['codigo'];
$productoCod = Producto::encontrarProducto($codigo);


if (isset($_POST['btn'])) {
    //Recogemos y sanitizamos
    $nombre = ucwords(htmlspecialchars(trim($_POST['nombre'])));
    $precio = (float)(trim($_POST['precio']));

    $errores = false;
    //Validamos campos
    (Validar::errorLongitudCampo("nombre", $nombre, 5) ? $errores = true :  "");
    (Validar::errorPrecio("precio", $precio, 5, 1500) ? $errores = true : "");


    if ($errores) {
        header("Location:{$_SERVER['PHP_SELF']}?codigo=$codigo");
        die();
    }

    (new Producto)
        ->setNombre($nombre)
        ->setPrecio($precio)
        ->update($codigo); //le paso el código del producto

    $_SESSION['mensajeExisto'] = "Producto actualizado correctamente.";
    header("Location:inicio.php");
} else {
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

        <title>Crear producto</title>
    </head>

    <body style="background-color:beige">
        <h1 class="flex justify-center font-bold text-blue-800 m-5 text-xl">EDITAR PRODUCTO</h1>
        <div class="container p-12 mx-auto">
            <div class="w-3/4 mx-auto p-6 rounded-xl bg-gray-400">
                <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] . "?codigo=$codigo" ?>">
                    <div class="mb-6">
                        <label for="nombre" class="block mb-2 text-m font-bold text-gray-900 dark:text-white mb-4">
                            NOMBRE DEL PRODUCTO</label>
                        <input type="text" name="nombre" id="nombre" value="<?php echo $productoCod->nombre; ?>" placeholder="Escriba el nombre del producto" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <?php
                        Validar::mostrarError("nombre");
                        ?>
                    </div>

                    <div class="mb-6">
                        <label for="precio" class="block mb-2 text-m font-bold text-gray-900 dark:text-white mb-4">
                            PRECIO (€)</label>
                        <input type="number" id="precio" name="precio" value="<?php echo $productoCod->precio ?>" placeholder="Escriba el precio" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" step="0.01" max="9999,99" min="0">
                        <?php
                        Validar::mostrarError("precio");
                        ?>
                    </div>



                    <div class="flex flex-row-reverse">
                        <button type="submit" name="btn" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <i class="fa-solid fa-plus mr-2" style="color:white;"></i></i>EDITAR
                        </button>
                        <button type="reset" class="mr-2 text-white bg-yellow-700 hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-blue-800">
                            <i class="fas fa-paintbrush mr-2"></i>LIMPIAR
                        </button>
                        <a href="inicio.php" class="mr-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-blue-800">
                            <i class="fas fa-backward mr-2"></i>ATRÁS
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </body>

    </html>

<?php

}

?>