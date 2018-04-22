<?php
	function getFileType($file){
		$path_chunks = explode("/", $file);
		$thefile = $path_chunks[count($path_chunks) - 1];
		$dotpos = strrpos($thefile, ".");
		return strtolower(substr($thefile, $dotpos + 1));
	}
	function now(){
		$query = "SELECT now()::timestamp";
		$resultados = pg_exec($query);
		$dato = pg_fetch_row($resultados,0);
		return $dato[0];
	}
	function ahora(){
		return date('Y-m-d H:i:s', time());
	}
	function cogeIp(){
		$ip = getenv('HTTP_X_FORWARDED_FOR');
		if($ip==''){
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return($ip);
	}
	function fechaLegible($fecha){
		$fecha = explode ("-", $fecha);
		$anyo = $fecha[0];
		$mes = $fecha[1];
		$dia = $fecha[2];
		$fecha = $dia."/".$mes."/".$anyo;
		return $fecha;
	}
	function fechaHoraLegible($fecha){
		$fecha2 = explode (" ", $fecha);
		$fecha = $fecha2[0];
		$hora = $fecha2[1];

		$fecha = explode("-", $fecha);
		$anyo = substr($fecha[0], -2);
		$mes = $fecha[1];
		$dia = $fecha[2];
		$fecha = $dia."/".$mes."/".$anyo;

		$hora1 = explode(":", $hora);
		$hora = $hora1[0];
		$min = $hora1[1];
		$hora = $hora.":".$min;

		$fecha = $fecha." ".$hora;
		return $fecha;
	}
	function fechaHoraCorta($fecha){
		//Recibe 2017-01-22 22:30:00 - Devuelve 22/01 22:30
		$fecha2 = explode (" ", $fecha);
		$fecha = $fecha2[0];
		$hora = $fecha2[1];

		$fecha = explode("-", $fecha);
		$mes = $fecha[1];
		$dia = $fecha[2];
		$fecha = $dia."/".$mes;

		$hora1 = explode(":", $hora);
		$hora = $hora1[0];
		$min = $hora1[1];
		$hora = $hora.":".$min;
		$fecha = $fecha." ".$hora;

		return $fecha;
	}
	function difHs($inicio, $fin){
		$datetime1 = new DateTime($inicio);
		$datetime2 = new DateTime($fin);
		$interval = $datetime1->diff($datetime2);
		$elapsed = $interval->format('%H:%i');
		return $elapsed;
	}
	function difHsEntera($inicio, $fin){
		$datetime1 = new DateTime($inicio);
		$datetime2 = new DateTime($fin);
		$interval = $datetime1->diff($datetime2);
		$elapsed = $interval->format('%H:%i');
		$elapsed = explode(":", $elapsed);
		$hs = $elapsed[0];
		$min = $elapsed[1];
		//paso minutos a fracción de hs
		$min = $min/60;
		$horaFraccion = floatval($hs+$min);
		return $horaFraccion;
	}
	function difLegible($hora){
		$hora = explode(":", $hora);
		$horas = $hora[0];
		$minutos = $hora[1];
		//Regla de 3 para saber la fracción de hora
		$minutos = ($minutos * 100)/60;
		if($minutos < 10){
			$minutos = '0'.$minutos;
		}
		$hora = number_format(floatval($horas.".".$minutos), 2);
		return $hora;
	}
	function difDias($inicio, $fin){
		$datetime1 = new DateTime($inicio);
		$datetime2 = new DateTime($fin);
		$interval = $datetime1->diff($datetime2);
		$elapsed = $interval->format('%a');
		return $elapsed;
	}
	function sumaDias($inicio, $diasSuma){
		return date('Y-m-d', strtotime($inicio. ' + '.$diasSuma.' days'));
	}
	function escribeFechaCabecera($fecha){
		$meses = array("Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic");
		$fecha = explode("-", $fecha);
		$mes = $fecha[1];
		$dia = $fecha[2];
		$fecha = $dia."-".$meses[$mes-1];
		return $fecha;
	}
	function limitaChars($txtMensaje){
		if(strlen($txtMensaje) > 200){
			return substr($txtMensaje, 0, 200)." ...";
		}else{
			return $txtMensaje;
		}
	}
	function nombreElemento($id_elemento){
		global $conn;
		$selElemento = pg_exec("SELECT nombre FROM elementos WHERE id_elemento='".$id_elemento."' AND id_idioma='1'");
		$elemento = pg_fetch_row($selElemento);
		return $elemento[0];
	}
	function devuelveCurso(){
		//del 01/01 al 31/12 de 2018 será el curso 20182019
		//del 01/01 al 31/12 de 2019 será el curso 20192020
		return (date('Y', time())*10000)+date('Y', time())+1;
	}
	function calculaListaEspera(){
		$exceso = 0;
		$curso = devuelveCurso();
		$selModalidadesSel = pg_exec("SELECT id_tipo_educativo, id_idioma, plazas
																	FROM usuarios_a_tipos
																	WHERE id_usuario=".$_SESSION['user_id']."
																	AND curso = ".$curso);
		while($modalidadSel = pg_fetch_row($selModalidadesSel)){
			$id_tipo_educativo = $modalidadSel[0];
			$id_idioma = $modalidadSel[1];
			$plazas = $modalidadSel[2];
			$plazasTot += $plazas;
			$selAlumnosMod = pg_exec("SELECT count(*)
																		FROM alumnos AS al
																		INNER join alumnos_a_centros
																		ON alumnos_a_centros.id_alumno = al.id_alumno
																		WHERE al.estado = 42
																		AND al.id_tipo_educativo=".$id_tipo_educativo."
																		AND al.id_idioma=".$id_idioma."
																		AND curso = ".$curso);
			$alumnosMod = pg_fetch_row($selAlumnosMod);
			$alumnosMod = $alumnosMod[0];
			if($alumnosMod > $plazas){
				$exceso += ($alumnosMod-$plazas);
			}
		}
		return $exceso;
	}
	function obtienePtos($idElemento){
		//Recibe el id de la opcion elegida, devuelve los puntos desde la tabla calculo_opciones
		$selPtos = pg_exec("SELECT puntos FROM calculo_opciones WHERE id_opcion = ".$idElemento);
		$puntos = pg_fetch_row($selPtos);
		$puntos = $puntos[0];
		return $puntos;
	}
	function calculaPuntaje($pt_zona, $hnos, $padres, $renta, $fliaNum, $fliaMonop, $discAl,
	$discFlia33, $discFlia65, $nivel, $nota){
		//puntos por zona = $pt_zona
		//puntos por hermanos en el centro
		$pt_hnos = obtienePtos($hnos);
		//ptos por padres en el centro
		$pt_padres = obtienePtos($padres);
		//ptos por nivel de renta
		$pt_renta = obtienePtos($renta);
		//ptos por familia numerosa
		$pt_flia_num = obtienePtos($fliaNum);
		//ptos por familia monoparental --> si suma por flia_numerosa no aplica
		if($pt_flia_num > 0){
			$pt_flia_mono = 0;
		}else{
			$pt_flia_mono = obtienePtos($fliaMonop);
		}
		//ptos por discapacidad del alumno
		$pt_discAl = obtienePtos($discAl);
		//ptos por discapacidad de familiares de 33% a 65%
		$pt_discFl33 = obtienePtos($discFlia33);
		//ptos por discapacidad de familiares superior a 65%
		$pt_discFl65 = obtienePtos($discFlia65);
		//ptos por media de ESO o FP --> solo si el nivel es bachiller
		if($nivel == 4){
			$pt_nota = $nota;
		}else{
			$pt_nota = 0;
		}
		$puntaje_total= $pt_zona + $pt_hnos + $pt_padres + $pt_renta + $pt_flia_num + $pt_flia_mono +
										$pt_discAl + $pt_discFl33 + $pt_discFl65 + $pt_nota;
		return $puntaje_total;
	}
	function calculaPorcentajeCubierto(){
		$plazasTot=0;
		$asignadas=0;
		$curso = devuelveCurso();
		$selModalidadesSel = pg_exec("SELECT id_tipo_educativo, id_idioma, plazas
																	FROM usuarios_a_tipos
																	WHERE id_usuario=".$_SESSION['user_id']."
																	AND curso = ".$curso);
		while($modalidadSel = pg_fetch_row($selModalidadesSel)){
			$id_tipo_educativo = $modalidadSel[0];
			$id_idioma = $modalidadSel[1];
			$plazas = $modalidadSel[2];
			$plazasTot += $plazas;
			$selAlumnosMod = pg_exec("SELECT count(*)
																		FROM alumnos AS al
																		INNER join alumnos_a_centros
																		ON alumnos_a_centros.id_alumno = al.id_alumno
																		WHERE al.estado = 42
																		AND al.id_tipo_educativo=".$id_tipo_educativo."
																		AND al.id_idioma=".$id_idioma."
																		AND curso = ".$curso);
			$alumnosMod = pg_fetch_row($selAlumnosMod);
			$alumnosMod = $alumnosMod[0];
			if($alumnosMod > $plazas){
				$alumnosMod = $plazas;
			}
			$asignadas += $alumnosMod;
		}
		if($plazasTot==0){
			return 0;
		}else{
			return number_format(($asignadas*100)/$plazasTot, 2, ',', '.');
		}

	}
	function vcGrafMod($vble){
		$curso = devuelveCurso();
		$selDatos = pg_exec("select te.id_tipo, te.id_idioma, te.nombre, idi.nombre AS idioma, ut.plazas, te.descripcion
												from usuarios_a_tipos AS ut
												inner join tipos_educativos AS te
												on (ut.id_tipo_educativo=te.id_tipo AND ut.id_idioma=te.id_idioma)
												inner join idiomas AS idi
												ON ut.id_idioma=idi.id_idioma
												where ut.id_usuario=".$_SESSION['user_id']."
												and ut.curso=".$curso."
												group by
												te.id_tipo, te.id_idioma, te.nombre, idi.nombre, ut.plazas
												order by 1, 2");
	$txtRes = '';
	switch($vble){
		case "nombreModalidad":
			while($datos = pg_fetch_row($selDatos)){
				if($txtRes == ''){
    			$txtAgrega = '';
    		}else{
    			$txtAgrega = ', ';
    		}
				$txtRes .= $txtAgrega."'".$datos[5]." en ".strtolower($datos[3])."'";
			}
			break;
		case "plazas":
			while($datos = pg_fetch_row($selDatos)){
				if($txtRes == ''){
					$txtAgrega = '';
				}else{
					$txtAgrega = ', ';
				}
				$txtRes .= $txtAgrega.$datos[4];
			}
			break;
		case "solicitudes":
			while($datos = pg_fetch_row($selDatos)){
				$selSolicitudes = pg_exec("select count(*)
														from alumnos AS al
														inner join alumnos_a_centros AS ac
														ON al.id_alumno = ac.id_alumno
														where ac.id_centro=".$_SESSION['user_id']."
														and al.curso=".$curso."
														and al.estado != 6
														and al.id_idioma=".$datos[1]."
														and al.id_tipo_educativo=".$datos[0]);
				$solicitudes = pg_fetch_row($selSolicitudes);
				if($txtRes == ''){
					$txtAgrega = '';
				}else{
					$txtAgrega = ', ';
				}
				$txtRes .= $txtAgrega.$solicitudes[0];
			}
			break;
	}
	return $txtRes;
	}
    function vectorUltimoAnyo(){
    	//A partir de un array de meses, lo ordena poniendo el mes actual como ultimo, asi tengo el ultimo periodo de 12 meses
    	$array = array('Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic');
    	$mes_actual = date('n');
    	//Si es Diciembre, el primer mes del array será enero
    	if($mes_actual == 12){
    		$primer_mes = 0;
    	}else{
    		$primer_mes = $mes_actual;
    	}
    	$array_resultado = array();
    	//bucle para reordenar el array
    	for($i = 0; $i < 12; $i++){
    		//Si llego al ultimo mes, hago que empiece de nuevo
    		if($primer_mes == 12){
    			$primer_mes = 0;
    		}
    		array_push($array_resultado, $array[$primer_mes]);
    		$primer_mes++;
    	}

    	$txtRes = '';
    	//Tengo el array ordenado, lo escribo como lo necesito
    	for($i = 0; $i < sizeof($array_resultado); $i++){
    		if($txtRes == ''){
    			$txtAgrega = '';
    		}else{
    			$txtAgrega = ', ';
    		}
    		$txtRes .= $txtAgrega."'".$array_resultado[$i]."'";
    	}
    	return $txtRes;
    }
	function vcUltimosValores($variable){
		$mes_actual = date('n');
		$anyo_actual = date('Y');
		if($mes_actual == 12){
			$mes_inicial = 01;
			$anyo_inicial = $anyo_actual;
		}else{
			$mes_inicial = $mes_actual + 1;
			$anyo_inicial = $anyo_actual - 1;
		}
		$txt = '';
		for($i = 0; $i < 12; $i++){
			switch ($variable) {
				case 'pedidos':
					$valor = devuelvePedidos($mes_inicial, $anyo_inicial);
					break;
				case 'mapas':
					$valor = devuelveMapas($mes_inicial, $anyo_inicial);
					break;
				case 'ingresos':
					$valor = devuelveIngresos($mes_inicial, $anyo_inicial);
					break;
			}

			if($txt == ''){
				$agrega = '';
			}else{
				$agrega = ', ';
			}

			$txt .= $agrega.$valor;

			//Suma contadores
			if($mes_inicial == 12){
				$mes_inicial = 1;
				$anyo_inicial++;
			}else{
				$mes_inicial++;
			}
		}
		return $txt;
	}

?>
