<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>
		Paginación con PHP
	</title>

</head>
<body>
<?php
	include_once 'conexionDB.php';
	$consultaSQLtotal = "SELECT * FROM usuarios";
	$consulta = mysqli_query($conn,$consultaSQLtotal); 
	$num_total_registros = mysqli_num_rows($consulta);
	$pagina = false;

	if($num_total_registros > 0){
		$num_registros_por_pagina = 3;
		$primeraVez = false;

		if(isset($_GET['pagina'])){
			$pagina = $_GET['pagina'];
		}
		if(!$pagina){ // la primera vez que se entra en la página
			$inicio = 0;
			$pagina = 1;
		} else{
			$inicio = $pagina -1;
		}

		$num_total_paginas = ceil($num_total_registros/$num_registros_por_pagina); //redondea hacia arriba el numero total de páginas
		$nuevaConsultaSQL = "SELECT * FROM usuarios LIMIT ".$inicio.",".$num_registros_por_pagina;
		$consulta = mysqli_query($conn,$nuevaConsultaSQL);

		while ($fila = mysqli_fetch_assoc($consulta)) {
			echo '<div>'.$fila['nombre'].'</div>';
		}

		// zona de los numeros inferiores

		if($num_total_paginas > 1){
			if($pagina !=1){
			echo '<a href="index.php?pagina='.($pagina-1).'">anterior</a>';
			// para ir a la pagina anterior
			} 
		
		// nueros intermedios

		for($i = 1; $i < $num_total_paginas; $i++){
			if($pagina == $i){
				echo $pagina; // se corresponde con la pagina actual
			} else{
				echo '<a href="index.php?pagina='.$i.'">'.$i.'</a>';
			}
		}

		if($pagina != $num_total_paginas-1){// estoy en laultima pagina
			// para ir a la pagina siguiente
			echo '<a href="index.php?pagina='.($pagina+1).'">siguiente</a>';
		}
	}
}

?>
		
