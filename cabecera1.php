<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <title>Venta de yates</title>
</head>

<body>
    <?php include_once 'conexionDB.php';

    //Variable que contiene la consulta a realizar, en este caso para las secciones
    $consultasSQLsecciones = "SELECT seccion FROM yates GROUP BY seccion";

    // Realizo la consulta a la base de datos, la columna seccion de la tabla yates
    // EL primer parametro es la variable que contiene el resultado de la conexion a la base de datos.
    // EL segundo parametro es la consulta a realizar, es decir la query, en este caso $consultasSQLsecciones
    $consulta = mysqli_query($conn, $consultasSQLsecciones);

    // Query para consultar todo de la tabla
    $consultasSQLtotal = "SELECT * FROM yates";

    // Se realiza la consulta de todos los datos
    $consultaTodo = mysqli_query($conn, $consultasSQLtotal);

    // Verifica si hubo un error al establecer la conexion a la base de datos
    if (mysqli_errno($conn)) {
        echo "ha ocurrido un error en la consulta a la base de datos";
    } else {
        echo '<header>';
        echo '<nav class="navegacion">';

        // Aqui uso la función mysql_num_rows para saber el numero de filas que contiene
        $numeroFilas = mysqli_num_rows($consulta);

        // Si el numero de filas es mayor a 0, iniciamos el bucle while
        if ($numeroFilas > 0) {

            // $contenidosSitio = $consulta; <-- no hace nada

            // Me devuelve un array asociativo de la fila, cuando hago la query $consulta
            // Se usa el while porque solo devuelve la ultima fila, para que devuelva todas es necesario el bucle. Luego ingresamos a sus valores mediante la key 'seccion'
            while ($fila = mysqli_fetch_assoc($consulta)) {
                echo '<a href="index.php?seccion=' . $fila['seccion'] . '">' . $fila['seccion'] . '</a>';
                echo '<br/>';
            }
        }
        echo '</nav>';
    }
    ?>
</body>

</html>