<?php


class Epp_model extends CI_Model{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->db2 = $this->load->database("dbpayroll", true);
	} 


	function getSalidas(){

	 	//$this->db->where('Estado',1);
		$data = $this->db->get('Tbl_Epp');

		return $data->result_array();

	}



	public function getEmpleados($filtro)
	{
		$json = array();
		$i = 0;	
		$qfilter = '';
		if($filtro){

			$qfilter = "and (firstName LIKE '%".$filtro."%' or lastName LIKE '%".$filtro."%' or middleName LIKE '%".$filtro."%')";

		}else{
			$qfilter = '';
		}


		$query = "SELECT empID, firstName,lastName,middleName from SCGPL_EMPLEADOS_OHEM
		WHERE 1 = 1 ".$qfilter."";
												//echo $query;return;
		$resultado = $this->db2->query($query);

		foreach ($resultado->result_array() as $value) {
			$json[$i]["empID"] = utf8_encode($value["empID"]);
			$json[$i]["nombre"] = $value["firstName"].' '.$value["middleName"].' '.$value["lastName"];
			$i++;
		}                

		echo json_encode($json);

	}

	function getArticulos()
	{
		$this->db->where('Estado',1);
		$data = $this->db->get('Articulos_Epp');

		return $data->result_array();
	}

	function getArticulo($id)
	{
		$this->db->where('Id',$id);		
		$data = $this->db->get('Articulos_Epp');

		return $data->result_array();
	}

	function guardarCrearArticulo($descripcion)
	{
		date_default_timezone_set("America/Managua");
		$mensaje = array();

		$encabezado = array(
			"Descripcion" =>$descripcion,
			"IdUsuarioCrea" =>$this->session->userdata("id"),
			"FechaCrea" =>gmdate(date("Y-m-d H:i:s")),
			"Estado" => 1
		);

		$inserto = $this->db->insert("Articulos_Epp",$encabezado);

		if ($inserto) {
			if($inserto == true){
				$mensaje[0]["mensaje"] = "Datos guardados correctamente";
				$mensaje[0]["tipo"] = "success";
				echo json_encode($mensaje);
			}else{
				$mensaje[0]["mensaje"] = "Error al guardar los datos del articulo COD(1_articulo)";
				$mensaje[0]["tipo"] = "error";
				echo json_encode($mensaje);
			}
		}
		
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
		}
		else
		{
			$this->db->trans_commit();
		}
	}

	public function bajaArticulo($id,$estado)
	{
		$mensaje = array();
		$this->db->where("Id",$id);
		$data = array(
			"Estado" => $estado,
			"IdUsuarioEdita" =>$this->session->userdata("id"),
			"FechaEdita" =>gmdate(date("Y-m-d H:i:s"))
		);
		$baja = $this->db->update("Articulos_Epp",$data);
		if($baja)
		{
			$mensaje[0]["mensaje"] = "La operación se llevo a cabo con éxito.";
			$mensaje[0]["tipo"] = "success";
			echo json_encode($mensaje);
		}else{
			$mensaje[0]["mensaje"] = "Fallo en la operación.
			Ocurrió un error inesperado en el servidor, si el error persiste contáctece con el administrador.";
			$mensaje[0]["tipo"] = "error";
			echo json_encode($mensaje);
		}
	}

	function guardarEditarArticulo($id,$descripcion)
	{
		date_default_timezone_set("America/Managua");
		$mensaje = array();

		$encabezado = array(
			"Descripcion" =>$descripcion,
			"IdUsuarioEdita" =>$this->session->userdata("id"),
			"FechaEdita" =>gmdate(date("Y-m-d H:i:s"))			
		);

		$this->db->where("Id",$id);
		$inserto = $this->db->update("Articulos_Epp",$encabezado);

		if ($inserto) {
			if($inserto == true){
				$mensaje[0]["mensaje"] = "Datos guardados correctamente";
				$mensaje[0]["tipo"] = "success";
				echo json_encode($mensaje);
			}else{
				$mensaje[0]["mensaje"] = "Error al guardar los datos del articulo COD(1_articulo)";
				$mensaje[0]["tipo"] = "error";
				echo json_encode($mensaje);
			}
		}
		
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
		}
		else
		{
			$this->db->trans_commit();
		}
	}

	function getArticulosAjax()
	{
		$i = 0;
		$json = array();		
		$query = "SELECT t0.*,t1.Nombres,t1.Apellidos from Articulos_Epp t0 
		inner join Usuarios t1 on t1.IdUsuario = t0.IdUsuarioCrea
		where 1= 1 ";
    	//$this->db->where('Estado',1);
		$data = $this->db->query($query);
		foreach ($data->result_array() as $value) {
			$estado = '';
			$boton = '';$tipoDesc = '';
			switch ($value["Estado"]) {
				case 1:
				$estado = "<span class='text-success text-bold'>Activo</span>";
				$boton = "
					<td class='text-center'>
					<a onclick='editar(".'"'.$value["Id"].'"'.")' class='btn btn-primary btn-xs' href='javascript:void(0)'>
					<i class='fa fa-pencil'></i>
					</a>
					<a onclick='Baja(".'"'.$value["Id"].'","'.$value["Estado"].'"'.")' class='btn btn-danger btn-xs' href='javascript:void(0)'>
					<i class='fa fa-trash'></i>
					</a>
					</td>";
				break;
				default:
				$estado = "<span class='text-danger text-bold'>Inactivo</span>";
				$boton = "
					<td class='text-center'>
					<a class='btn btn-primary btn-xs disabled' href='javascript:void(0)'>
					<i class='fa fa-pencil'></i>
					</a>
					<a onclick='Baja(".'"'.$value["Id"].'","'.$value["Estado"].'"'.")' class='btn btn-danger btn-xs' href='javascript:void(0)'>
					<i class='fa fa-undo' aria-hidden='true'></i> 	
					</a>
					</td>";
				break;
			}			

			$json["data"][$i]["Id"] = $value["Id"];
			$json["data"][$i]["Descripcion"] = $value["Descripcion"];
			$json["data"][$i]["Nombre"] = $value["Nombres"].' '.$value["Apellidos"] ;
			$json["data"][$i]["FechaCrea"] = $value["FechaCrea"];
			$json["data"][$i]["FechaEdita"] = $value["FechaEdita"];
			$json["data"][$i]["Estado"] = $estado;
			$json["data"][$i]["Boton"] = $boton;
			$i++;
		}
		echo json_encode($json);
	}

	public function guardarSalida($enc,$tipo,$datos)
	{
		date_default_timezone_set("America/Managua");
		$mensaje = array();		

		$encabezado = array(			  
			"Tipo" =>$tipo,
			"IdEmpleado" =>$enc[1],
			"Nombre" =>$enc[2],
			"Fecha" =>$enc[0],
			"Firma" =>$enc[3],
			"IdUsuarioCrea" =>$this->session->userdata("id"),
			"FechaCrea" =>gmdate(date("Y-m-d H:i:s")),
			"Estado" =>1
		);

		$inserto = $this->db->insert("Tbl_Epp",$encabezado);

		if ($inserto) {
			$num = 1; $bandera = false;
			$det = json_decode($datos, true);

			foreach ($det as $obj) {					
				$myId = $this->db->query("SELECT ISNULL(MAX(Id),0) AS Id FROM Tbl_Epp");

				$rpt = array(
					"IdEpp" => $myId->result_array()[0]["Id"],		                
					"Estado" => "A",		               
					"IdArticulo" => $obj[1],
					"Cantidad" => $obj[0],
					"Estado" => 1
				);

				$num++;
				$guardarRpt = $this->db->insert("Det_Epp",$rpt);
				if($guardarRpt){
					$bandera = true;
				}
			}

			if($bandera == true){
				$mensaje[0]["mensaje"] = "Datos guardados correctamente";
				$mensaje[0]["tipo"] = "success";
				echo json_encode($mensaje);
			}else{
				$mensaje[0]["mensaje"] = "Error al guardar los datos del informe COD(2_DET)";
				$mensaje[0]["tipo"] = "error";
				echo json_encode($mensaje);
			}
		}


		//$this->db->trans_rollback();
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
		}
		else
		{
			$this->db->trans_commit();
		}
	}


	public function actualizarSalida($enc,$datos,$id)
	{
		date_default_timezone_set("America/Managua");
		$mensaje = array();		

		$encabezado = array(			  
			"Tipo" =>1,
				//"IdEmpleado" =>$enc[1],
				//"Nombre" =>$enc[2],
				//"Fecha" =>$enc[0],
			"IdUsuarioEdita" =>$this->session->userdata("id"),
			"FechaEdita" =>gmdate(date("Y-m-d H:i:s")),
			"Estado" =>1
		);
		$this->db->where("Id",$id);
		$inserto = $this->db->update("Tbl_Epp",$encabezado);

		if ($inserto) {
			$num = 1; $bandera = false;
			$det = json_decode($datos, true);

			foreach ($det as $obj) {
				$myId = $this->db->query("SELECT ISNULL(MAX(Id),0) AS Id FROM Tbl_Epp");

				$rpt = array(
					"IdEpp" => $myId->result_array()[0]["Id"],
					"Estado" => "A",
					"IdArticulo" => $obj[1],
					"Cantidad" => $obj[0],
					"Estado" => 1
				);

				$num++;
				$guardarRpt = $this->db->insert("Det_Epp",$rpt);
				if($guardarRpt){
					$bandera = true;
				}
			}

			if($bandera == true){
				$mensaje[0]["mensaje"] = "Datos guardados correctamente";
				$mensaje[0]["tipo"] = "success";
				echo json_encode($mensaje);
			}else{
				$mensaje[0]["mensaje"] = "Error al guardar los datos del informe COD(2_DET)";
				$mensaje[0]["tipo"] = "error";
				echo json_encode($mensaje);
			}
		}

		//$this->db->trans_rollback();
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
		}
		else
		{
			$this->db->trans_commit();
		}
	}

	function getDatosSalida($id)
	{

		$datos = $this->db->query('SELECT t0.*,t1.Descripcion from Det_Epp T0 INNER JOIN Articulos_Epp T1 ON t0.IdArticulo = t1.Id and t0.Estado = 1 and t0.IdEpp = '.$id);

		return $datos->result_array();
	}

	function getEncabezadoSalida($id)
	{
		$datos = $this->db->query('SELECT t0.*,t1.Nombres,t1.Apellidos from Tbl_Epp t0 
			inner join Usuarios t1 on t1.IdUsuario = t0.IdUsuarioCrea
			WHERE t0.Id = '.$id);

		return $datos->result_array();
	}

	public function darDeBaja($idreporte,$estado)
	{
		$mensaje = array();
		$this->db->where("Id",$idreporte);
		$data = array(
			"Estado" => $estado
		);
		$baja = $this->db->update("Tbl_Epp",$data);
		if($baja)
		{
			$mensaje[0]["mensaje"] = "La operación se llevo a cabo con éxito.";
			$mensaje[0]["tipo"] = "success";
			echo json_encode($mensaje);
		}else{
			$mensaje[0]["mensaje"] = "Fallo en la operación.
			Ocurrió un error inesperado en el servidor, si el error persiste contáctece con el administrador.";
			$mensaje[0]["tipo"] = "error";
			echo json_encode($mensaje);
		}
	}
	function mostrarEPP($tipo,$desde,$hasta)
	{
		$i = 0;

		$json = array();
		$and = '';
		if ($tipo !='') {
			$and .= ' And t0.Tipo = '.$tipo;
		}

		if ($desde !='' && $hasta !='') {
			$and .= ' And cast(t0.Tipo as date) >= '.$desde." and cast(t0.Tipo as date) <=".$hasta;
		}
		$query = "SELECT t0.*,t1.Nombres,t1.Apellidos from Tbl_Epp t0 
		inner join Usuarios t1 on t1.IdUsuario = t0.IdUsuarioCrea
		where 1= 1 ".$and;

    	//$this->db->where('Estado',1);
		$data = $this->db->query($query);

		foreach ($data->result_array() as $value) {
			$estado = '';
			$boton = '';$tipoDesc = '';
			switch ($value["Estado"]) {
				case 1:
				$estado = "<span class='text-success text-bold'>Activo</span>";
				$boton = "
					<td class='text-center'>
					<a onclick='editar(".'"'.$value["Id"].'"'.")' class='btn btn-primary btn-xs' href='javascript:void(0)'>
					<i class='fa fa-eye'></i>
					</a>
					<a onclick='Baja(".'"'.$value["Id"].'","'.$value["Estado"].'"'.")' class='btn btn-danger btn-xs' href='javascript:void(0)'>
					<i class='fa fa-trash'></i>
					</a>
					</td>";
				break;
				default:
				$estado = "<span class='text-danger text-bold'>Inactivo</span>";
				$boton = "
					<td class='text-center'>
					<a class='btn btn-primary btn-xs disabled' href='javascript:void(0)'>
					<i class='fa fa-eye'></i>
					</a>
					<a onclick='Baja(".'"'.$value["Id"].'","'.$value["Estado"].'"'.")' class='btn btn-danger btn-xs' href='javascript:void(0)'>
					<i class='fa fa-undo' aria-hidden='true'></i> 	
					</a>
					</td>";
				break;
			}
			$tipoDesc = 'SALIDA';
			if ($value["Tipo"] == 2) {
				$tipoDesc = 'ENTRADA';
			}
		


			$json["data"][$i]["Tipo"] = $tipoDesc;
			$json["data"][$i]["Id"] = $value["Id"];
			$json["data"][$i]["Nombre"] = $value["Nombre"];
			$json["data"][$i]["FechaCrea"] = $value["FechaCrea"];
			$json["data"][$i]["FechaEdita"] = $value["FechaEdita"];
			$json["data"][$i]["Estado"] = $estado;
			$json["data"][$i]["Boton"] = $boton;
			$i++;
		}
		echo json_encode($json);
	}

}
?>