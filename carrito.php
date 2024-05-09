<?php

// Iniciamos session
session_start();
include_once 'cabecera1.php';

function borrar_carrito()
{
    session_unset();
    session_destroy();
    echo "Articulos eliminados 😢";
}

// Obtener datos

function obtener_datos_session($mostrar_texto)
{
    $yates = $_SESSION['seleccion'];

    $array_yates_seleccionados = explode("#", $yates);
    echo '<ul>';
    global $total;
    global $articulos_compra;
    $articulos_compra = '';
    $total = 0;

    for ($i = 0; $i < count($array_yates_seleccionados); $i++) {
        $titulo_y_precio = $array_yates_seleccionados[$i];
        $array_titulo_y_precio = explode("@", $titulo_y_precio);
        $titulo = $array_titulo_y_precio[0];
        $precio = $array_titulo_y_precio[1];
        $id = $array_titulo_y_precio[2];
        $articulos_compra .= $id . ',';
        $total += $precio;

        if ($mostrar_texto) {
            echo '<li>Titulo: ' . $titulo . ' -->Precio: ' . $precio . '€ <a href="carrito.php?borrarSeleccionado=' . $id . '">Quitar</a></li>';
        }
    }
    $articulos_compra = substr($articulos_compra, 0, -1);
}


if (isset($_POST['yates']) && count($_POST['yates']) > 0) {
    $yates_seleccionado_cadena = '';
    $yates_seleccionados = $_POST['yates'];
    foreach ($yates_seleccionados as $key => $value) {
        $yates_seleccionado_cadena .= $value . "#";
    }

    $yates_seleccionados = substr($yates_seleccionados, 0, -1);

    if (!isset($_SESSION['seleccion'])) {
        // Si es la primera vez que se elige un yate
        $_SESSION['seleccion'] = $yates_seleccionado_cadena; // Se crea la variable de sesion
    } else {
        $_SESSION['seleccion'] .= '#' . $yates_seleccionado_cadena; // Se añade un nuevo yate
    }

    echo '<h4> Yate añadido correctamente 😊</h4>';
    echo '<a href="carrito.php">Ver carrito</a>';
    echo '<br/>';
} elseif (isset($_GET['borrarTodo'])) {
    // Borra todo el carrito
    borrar_carrito();
} elseif (isset($_GET['borrarSeleccionado'])) {
    // Borrar un yate del carrito
    // Obtenemos el id
    $id_yate = $_GET['borrarSeleccionado'];
    $yate_sesion = $_SESSION['seleccion'];
    $array_yates_seleccionados = explode('#', $yate_sesion);
    $yates_seleccionados = "";

    for ($i = 0; $i < count($array_yates_seleccionados); $i++) {
        $datos_array_yates = explode('#', $array_yates_seleccionados[$i]); // El id es el identificador del yate a eliminar
        $id = $datos_array_yates[2];
        if ($id != $id_yate) {
            $yates_seleccionados .= $array_yates_seleccionados[$i] . "#";
        }
    }
    $yates_seleccionados = substr($yates_seleccionados, 0, -1);

    $_SESSION['session'] = $yates_seleccionados;
    echo '<br />';
    echo '<h3> Yate eliminado </h3>';
    echo '<br />';
    echo '<a href="carrito.php">Ver carrito</a>';
} elseif (isset($_GET['comprar'])) {
    obtener_datos_session(false);
    $precio_total = $total;
    $articulos = $articulos_compra;
    $consultaSQL = "INSERT INTO 'pedidos' ('id','aritulos','preciototal','fecha') VALUES (NULL, '$articulos', '$precio_total', NOW())";

    $consulta = mysqli_query($conn, $consultaSQL); // Se hace la consulta a la base de datos
    if (mysqli_errno($conn)) {
        echo "ha ocurrido un error en la grabación de datos 😒";
    } else {
        echo "datos grabados correctamente 😊";
        borrar_carrito();
    }
    mysqli_close($conn);
} else {
    // Mostrar yates seleeccionados y el precio total, no entraremos por yate elegido sino directamene o porque queremos ver los yates seleecionados totales

    echo '<h3>Todos los libros seleccionados</h3>';
    echo '<br />';

    if (isset($_SESSION['seleccion'])) {
        obtener_datos_session(true);
        echo '</ul>';
        echo '<br />';
        echo '<h4>Total compra: ' . $total . '$</h4>';
        echo '<br />';
        echo '<a href="carrito.php?borrarTodo=si">Borrar todo</a>';
        echo '<br />';
        echo '<a class="comprar" href="carrito.php?comprar="">Comprar</a>';
    } else {
        echo "No hay yates seleccionados";
    }
}
