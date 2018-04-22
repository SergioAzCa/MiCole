<?php
	include("../php/seguridad.php");
    include("../php/config.php");
    include("../php/funciones.php");
	
	if(isset($_POST['opciones']) && $_POST['opciones'] == 'carga'){
		$tipo = $_POST['tipo'];
		if($tipo == 'inicio'){
			$selFacturas = pg_exec("SELECT id_factura, fecha_emision FROM facturas ORDER BY id_factura ASC");
    		$resultados = array();
    		while($factura = pg_fetch_row($selFacturas)){
    			$f_id = $factura[0];
    			$f_fecha = explode("-", $factura[1]);
    			$f_fecha = $f_fecha[0]."/";
    			$longFactura = strlen($f_id);
				$cantCeros = 7 - $longFactura;
				$imprimeCeros = '';
				for( $i = 0 ; $i < $cantCeros; $i++ ){
					$imprimeCeros .= '0';
				}
				$f_fecha .= $imprimeCeros.$f_id;
    			$resultado = array();

				$resultado['id'] = $f_id;
				$resultado['fecha'] = $f_fecha;
				array_push($resultados, $resultado);
    		}
    		echo json_encode($resultados);			
		}else if($tipo == 'fin'){
			$inicio = $_POST['inicio'];
			$selFacturas = pg_exec("SELECT id_factura, fecha_emision FROM facturas WHERE id_factura > '$inicio'");
    		$resultados = array();
    		while($factura = pg_fetch_row($selFacturas)){
    			$f_id = $factura[0];
    			$f_fecha = explode("-", $factura[1]);
    			$f_fecha = $f_fecha[0]."/";
    			$longFactura = strlen($f_id);
				$cantCeros = 7 - $longFactura;
				$imprimeCeros = '';
				for( $i = 0 ; $i < $cantCeros; $i++ ){
					$imprimeCeros .= '0';
				}
				$f_fecha .= $imprimeCeros.$f_id;
    			$resultado = array();

				$resultado['id'] = $f_id;
				$resultado['fecha'] = $f_fecha;
				array_push($resultados, $resultado);
    		}
			echo json_encode($resultados);
		}
	}else if(isset($_GET['opciones']) && $_GET['opciones'] == 'imprime'){
		switch ($_GET['tipo']) {
			case 1:
				$fechaIni = explode("/", $_GET['inicio']);
				$anyoIni = $fechaIni[2];
				$mesIni = $fechaIni[1];
				$diaIni = $fechaIni[0];
				
				$fechaFin = explode("/", $_GET['fin']);
				$anyoFin = $fechaFin[2];
				$mesFin = $fechaFin[1];
				$diaFin = $fechaFin[0];
				
				$fechaInicio = date("Y-m-d", strtotime($anyoIni."-".$mesIni."-".$diaIni));
				$fechaFin = date("Y-m-d", strtotime($anyoFin."-".$mesFin."-".$diaFin));
				
				$selFacturas = pg_exec("SELECT facturas.id_factura, facturas.id_pedido, facturas.fecha_emision,
									   facturas.subtotal, facturas.iva, facturas.total, clientes.nombre, clientes.apellidos
									   FROM facturas 
									   INNER JOIN clientes
									   ON facturas.id_cliente = clientes.id_cliente
									   WHERE facturas.fecha_emision >= '".$fechaInicio."' 
									   AND facturas.fecha_emision <= '".$fechaFin."'
									   ORDER BY facturas.id_factura ASC");
				break;
			case 2:
				$selFacturas = pg_exec("SELECT facturas.id_factura, facturas.id_pedido, facturas.fecha_emision,
										facturas.subtotal, facturas.iva, facturas.total, clientes.nombre, clientes.apellidos
										FROM facturas 
										INNER JOIN clientes
										ON facturas.id_cliente = clientes.id_cliente
									    WHERE facturas.id_factura >= '".$_GET['inicio']."'
									    AND facturas.id_factura <= '".$_GET['fin']."'
									    ORDER BY facturas.id_factura ASC");
				break;
			case 3:
				$selFacturas = pg_exec("SELECT facturas.id_factura, facturas.id_pedido, facturas.fecha_emision,
										facturas.subtotal, facturas.iva, facturas.total, clientes.nombre, clientes.apellidos
										FROM facturas 
										INNER JOIN clientes
										ON facturas.id_cliente = clientes.id_cliente
										ORDER BY facturas.id_factura ASC");
				break;
		}
		$resultados = array();
		while($factura = pg_fetch_row($selFacturas)){
			$f_id = $factura[0];
			$f_pedido = $factura[1];
			$f_fecha = fechaHoraLegible($factura[2]);
			$f_subtotal = $factura[3];
			$f_iva = $factura[4];
			$f_total = $factura[5];
			$f_cliente = $factura[6]." ".$factura[7];
			
			$resultado = array(
					'id' => $f_id, 
					'pedido' => $f_pedido, 
					'fecha' => $f_fecha,
					'cliente' => $f_cliente,
					'subtotal' => $f_subtotal, 
					'iva' => $f_iva, 
					'total' => $f_total
				);
			array_push($resultados, $resultado);
		}
		echo json_encode($resultados);
	}
?>