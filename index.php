<?php
include 'cabecera1.php';

echo '<div class="ventanasinopsis"> id="ventanasinopsis"></div>';

if (isset($_GET['seccion'])) {
    $nombreSeccionYates = $_GET['seccion'];
    echo '<h1>' . $nombreSeccionYates . '</h1>';
    echo '<div class="contenedorArticulos">';
    echo '<form action="carrito.php" method="post">';

    while ($fila = mysqli_fetch_assoc($consultaTodo)) {
        $seccionYates = $fila['seccion'];
        if ($seccionYates == $nombreSeccionYates) {
            $titulo = $fila['titulo'];
            $imagen = $fila['imagen'];
            $precio  = $fila['precio'];
            $id = $fila['id'];
            $sinopsis = $fila['sinopsis'];

            echo '<div class="libro">';
            echo '<h3>' . $titulo . '</h3>';
            echo '<img class="imagenLibro" src="imagenes/' . $imagen . '">';
            echo '<p>Precio: ' . $precio . 'Eur</p>';
            echo '<div class="chec"><input type="checkbox" name="libro[]" value="' . $titulo . '@' . $precio . '@' . $id . '"></div>';
            echo '<p><a class="sinopsis" id="libro' . $id . '" href="#" data-sinopsis="' . $sinopsis . '">Ver sinopsis</a></p>';
            echo '</div>';
        };
    }
    echo '<div class="libro sinborde"><input type="submit" value="añadir al carrito"></div>';
    echo '</form>';
    echo '</div>';
} else {
    echo "<h1>Página de Inicio de yates</h1>";
}
include 'pie.php';

?>

<script>
    let sinopsisGrupo = document.getElementsByClassName("sinopsis");
    let ventana = document.getElementById("ventanasinopsis");

    let sacarVentana = (id) => {
        let laVentana = document.getElementById(id);
        let sinopsistxt = laVentana.getAttribute("data-sinopsis");
        ventana.innerText = sinopsistxt;
        ventana.style.display = "block";
    }

    ventana.addEventListener("click", (evento) => {
        evento.target.style.display = "none";
    });

    for (var i = 0; i < sinopsisGrupo.length; i++) {
        sinopsisGrupo[i].addEventListener("click", (evento) => {
            let id = evento.target.getAttribute("id");
            sacarVentana(id);
        });
    };
</script>