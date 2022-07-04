<?php
/**
 * Created by Cesar Mejía.
 * User: Sistemas
 * Date: 23/4/2019 09:09 2019
 * FileName: Usuarios_model.php
 */
class Reportes_model extends CI_Model{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function generarReportePesoDiametro($lote,$codigo){
		
		$data = array();
        $i = 0;
        $concatCodigo = "";
        
        if ($codigo != null || $codigo != '') {
        	$concatCodigo = " and t0.CODIGOPRODUCTO = ".$codigo."";

        	
        }
        //echo $concatCodigo." ----";
        $query = $this->db->query("SELECT isnull(t0.CODIGOPRODUCTO,t1.CODIGOPRODUCTO) CODIGOPRODUCTO, isnull(t0.NOMBREPRODUCTO,t1.NOMBREPRODUCTO) NOMBREPRODUCTO,
				isnull(T0.LOTE,T1.LOTE) LOTE,ISNULL(T0.DIAMETRO_UTILIZADO,0) DIAMETRO_UTILIZADO,ISNULL(T0.DIAMETRO_ESPERADO,0)DIAMETRO_ESPERADO,
				ISNULL(T0.FUNDADIAMETRO,0) FUNDADIAMETRO,ISNULL(T0.FUNDALARGO,0) FUNDALARGO,isnull(t1.PESO_ESPERADO,0)PESO_ESPERADO,
				isnull(t1.PESO_PROMEDIO,0) PESO_PROMEDIO,ISNULL(T1.VARIABILIDAD_3,0) VARIABILIDAD_3,ISNULL(T0.MAQUINA,T1.MAQUINA) MAQUINA,
				ISNULL(T1.TAMANO_MUESTRA,0)TAMANO_MUESTRA,isnull(t1.PESOEXACTO,0) PESOEXACTO,ISNULL(T1.DEBAJO_LIMITE,0)DEBAJO_LIMITE,ISNULL(T1.ENCIMA_LIMITE,0)ENCIMA_LIMITE,
				ISNULL(T1.EN_RANGO,0)EN_RANGO
				FROM (

					select T0.CODIGOPRODUCTO,T0.NOMBREPRODUCTO,T0.LOTE,AVG(T1.PESOBASCULA) DIAMETRO_UTILIZADO, t0.DIAMETRO DIAMETRO_ESPERADO,
					FUNDADIAMETRO,FUNDALARGO,T2.MAQUINA
					from Reportes t0
					inner join ReportesPeso t1 on t1.IDREPORTE = t0.IDREPORTE
					inner join CatMaquinas t2 on t2.IDMAQUINA = t0.IDMAQUINA
					where T0.IDTIPOREPORTE = 16 and T0.LOTE = '".$lote."' ".$concatCodigo."
					GROUP BY T0.CODIGOPRODUCTO,T0.NOMBREPRODUCTO,T0.LOTE,t0.DIAMETRO,FUNDADIAMETRO,FUNDALARGO,t2.MAQUINA

				)T0 FULL OUTER JOIN
				(
					SELECT T0.CODIGOPRODUCTO,T0.NOMBREPRODUCTO,T0.LOTE,isnull(t0.DIAMETRO,0) DIAMETRO,FUNDADIAMETRO,FUNDALARGO, t0.PESOGRAMOS PESO_ESPERADO,
					AVG(T1.PESOBASCULA) PESO_PROMEDIO, 	AVG(T1.PESOBASCULA)-t0.PESOGRAMOS VARIABILIDAD_3,t2.MAQUINA,
					count( t1.CODIGO) TAMANO_MUESTRA, 
					cast((count(case when t1.DIFERENCIA = 0 then t1.CODIGO ELSE NULL END))as decimal)/count(t1.CODIGO)*100  PESOEXACTO,
					cast((count(case when t1.DIFERENCIA < 0 then t1.CODIGO ELSE NULL END))as decimal)/count(t1.CODIGO)*100  DEBAJO_LIMITE,
					cast((count(case when t1.DIFERENCIA > 0 then t1.CODIGO ELSE NULL END))as decimal)/count(t1.CODIGO)*100  ENCIMA_LIMITE,
					cast((count(CASE WHEN T1.DIFERENCIA >= ((t0.PESOGRAMOS*0.03)*-1) AND T1.DIFERENCIA <= (t0.PESOGRAMOS*0.03) THEN  t1.CODIGO ELSE NULL END )) as decimal)/count(t1.CODIGO)*100  EN_RANGO
					from Reportes t0
					inner join ReportesPeso t1 on t1.IDREPORTE = t0.IDREPORTE
					left join CatMaquinas t2 on t2.IDMAQUINA = t0.IDMAQUINA
					where T0.IDTIPOREPORTE = 10 and T0.LOTE = '".$lote."' ".$concatCodigo."
					GROUP BY  T0.CODIGOPRODUCTO,T0.NOMBREPRODUCTO,T0.LOTE,t0.PESOGRAMOS,FUNDADIAMETRO,FUNDALARGO,t0.DIAMETRO,t2.MAQUINA

				)T1 ON T1.LOTE = T0.LOTE AND T1.CODIGOPRODUCTO = T0.CODIGOPRODUCTO");

        	//echo json_encode($query->result_array());
            if (count($query->result_array())>0) {
                foreach ($query->result_array() as $key) {
                    $data['data'][$i]["CODIGOPRODUCTO"] = $key["CODIGOPRODUCTO"];
                    $data['data'][$i]["NOMBREPRODUCTO"] = $key["NOMBREPRODUCTO"];
                    $data['data'][$i]["LOTE"] = $key["LOTE"];
                    $data['data'][$i]["DIAMETRO_UTILIZADO"] = number_format($key["DIAMETRO_UTILIZADO"],2);
                    $data['data'][$i]["DIAMETRO_ESPERADO"] = number_format($key["DIAMETRO_ESPERADO"],2);
                    $data['data'][$i]["FUNDADIAMETRO"] = number_format($key["FUNDADIAMETRO"],2);
                    $data['data'][$i]["FUNDALARGO"] = number_format($key["FUNDALARGO"],2);
                    $data['data'][$i]["PESO_ESPERADO"] = number_format($key["PESO_ESPERADO"],2);
                    $data['data'][$i]["PESO_PROMEDIO"] = number_format($key["PESO_PROMEDIO"],2);
                    $data['data'][$i]["VARIABILIDAD_3"] = number_format($key["VARIABILIDAD_3"],2);
                    $data['data'][$i]["MAQUINA"] = $key["MAQUINA"];
                    $data['data'][$i]["TAMANO_MUESTRA"] = number_format($key["TAMANO_MUESTRA"],2);
                    $data['data'][$i]["PESOEXACTO"] = number_format($key["PESOEXACTO"],2);
                    $data['data'][$i]["DEBAJO_LIMITE"] = number_format($key["DEBAJO_LIMITE"],2);
                    $data['data'][$i]["ENCIMA_LIMITE"] = number_format($key["ENCIMA_LIMITE"],2);
                    $data['data'][$i]["EN_RANGO"] = number_format($key["EN_RANGO"],2);
                    
                    $i++;
                }
                echo json_encode($data);
                return;

                															

            }
            echo 0;
            return;
	}
	
	public function generarReporteDetallePeso($lote,$codigo){
		
		$data = array();
        $i = 0;
        $concatCodigo = "";
        
        if ($codigo != null || $codigo != '') {
        	$concatCodigo = " and t0.CODIGOPRODUCTO = ".$codigo."";
        	
        }
        //echo $concatCodigo." ----";
        $query = $this->db->query("SELECT t1.*
							from  reportes t0
							inner join ReportesPeso t1 on t1.IDREPORTE = T0.IDREPORTE
							where t0.IDTIPOREPORTE = 10 AND t1.CODIGO = '".$codigo."' and t0.LOTE = '".$lote."'");

        	//echo json_encode($query->result_array());
            if (count($query->result_array())>0) {
                foreach ($query->result_array() as $key) {
                    $data['data'][$i]["CODIGO"] = $key["CODIGO"];
                    $data['data'][$i]["DESCRIPCION"] = $key["DESCRIPCION"];
                    $data['data'][$i]["PESOBASCULA"] = $key["PESOBASCULA"];                    
                    $data['data'][$i]["DIFERENCIA"] = $key["DIFERENCIA"];
                    
                    $i++;
                }
                echo json_encode($data);
                return;
            }
            echo 0;
            return;
	}

	public function GraficaPeso($lote,$producto,$tipo)
	{
		//echo "lote: ".$lote." producto: ".$producto;
		
		$json = array();$i = 0;
		if ($tipo == 1) {
			$query = $this->db->query("SELECT t0.PESOGRAMOS,t1.CODIGO,T1.DESCRIPCION,PESOBASCULA,DIFERENCIA from Reportes t0
									inner join ReportesPeso t1 on t1.IDREPORTE = t0.IDREPORTE
									where t0.ESTADO = 'A' and t0.IDTIPOREPORTE = 10 and T0.LOTE = '".$lote."' 
									and T1.CODIGO = '".$producto."'");
		}else if ($tipo==2){
			$query = $this->db->query("SELECT t0.DIAMETRO PESOGRAMOS,t1.CODIGO,T1.DESCRIPCION,PESOBASCULA,DIFERENCIA from Reportes t0
									inner join ReportesPeso t1 on t1.IDREPORTE = t0.IDREPORTE
									where t0.ESTADO = 'A' and t0.IDTIPOREPORTE = 16 and T0.LOTE = '".$lote."' 
									and T1.CODIGO = '".$producto."'");
		}
		

		if($query->num_rows() > 0){
			echo json_encode($query->result_array());
			return;			
		 }

         echo 0; return;
	}

	public function GraficaPesoAceptables($lote,$producto,$tipo)
	{
		$json = array();$i = 0;

		if ($tipo == 1) {
			$query = $this->db->query("WITH TABLA AS (
								SELECT t0.PESOGRAMOS,t1.CODIGO,T1.DESCRIPCION,PESOBASCULA,DIFERENCIA from Reportes t0
																	inner join ReportesPeso t1 on t1.IDREPORTE = t0.IDREPORTE
																	where t0.ESTADO = 'A' and t0.IDTIPOREPORTE = 10 and T0.LOTE = '".$lote."' 
																	and T1.CODIGO = '".$producto."')
								SELECT CAST(COUNT(CASE WHEN PESOBASCULA <=(PESOGRAMOS+ (PESOGRAMOS*0.03)) AND PESOBASCULA >=(PESOGRAMOS-(PESOGRAMOS*0.03)) THEN 1 ELSE NULL END)AS DECIMAL) /CAST(COUNT(PESOGRAMOS) AS DECIMAL)*100 PORCENTAJE
								FROM TABLA");	
		}else{
			$query = $this->db->query("WITH TABLA AS (
								SELECT t0.DIAMETRO PESOGRAMOS,t1.CODIGO,T1.DESCRIPCION,PESOBASCULA,DIFERENCIA from Reportes t0
									inner join ReportesPeso t1 on t1.IDREPORTE = t0.IDREPORTE
									where t0.ESTADO = 'A' and t0.IDTIPOREPORTE = 16 and T0.LOTE = '".$lote."' 
									and T1.CODIGO = '".$producto."')
								SELECT CAST(COUNT(CASE WHEN PESOBASCULA <=(PESOGRAMOS+0.2) AND PESOBASCULA >=(PESOGRAMOS+(-0.2)) THEN 1 ELSE NULL END)AS DECIMAL) /CAST(COUNT(PESOGRAMOS) AS DECIMAL)*100 PORCENTAJE
								FROM TABLA");
		}
		

		if($query->num_rows() > 0){
			echo json_encode($query->result_array());
			return;			
		 }

         echo 0; return;
	}

	public function GraficaPesoDebajo($lote,$producto,$tipo)
	{
		$json = array();$i = 0;
		if ($tipo == 1) {
		$query = $this->db->query("WITH TABLA AS (
									SELECT t0.PESOGRAMOS,t1.CODIGO,T1.DESCRIPCION,PESOBASCULA,DIFERENCIA from Reportes t0
																		inner join ReportesPeso t1 on t1.IDREPORTE = t0.IDREPORTE
																		where t0.ESTADO = 'A' and t0.IDTIPOREPORTE = 10 and T0.LOTE =  '".$lote."' 
																		and T1.CODIGO = '".$producto."'
									)
									SELECT 
									CAST(COUNT(CASE WHEN PESOBASCULA <(PESOGRAMOS-(PESOGRAMOS*0.03)) THEN 1 ELSE NULL END)AS DECIMAL) /CAST(COUNT(PESOGRAMOS) AS DECIMAL)*100 PORCENTAJE
									FROM TABLA");
		}else{
			$query = $this->db->query("WITH TABLA AS (
									SELECT t0.DIAMETRO PESOGRAMOS,t1.CODIGO,T1.DESCRIPCION,PESOBASCULA,DIFERENCIA from Reportes t0
										inner join ReportesPeso t1 on t1.IDREPORTE = t0.IDREPORTE
										where t0.ESTADO = 'A' and t0.IDTIPOREPORTE = 16 and T0.LOTE =  '".$lote."' 
										and T1.CODIGO = '".$producto."'
									)
									SELECT 
			CAST(COUNT(CASE WHEN PESOBASCULA <(PESOGRAMOS-(0.2)) THEN 1 ELSE NULL END)AS DECIMAL) /CAST(COUNT(PESOGRAMOS) AS DECIMAL)*100 PORCENTAJE
									FROM TABLA");
		}
		

		if($query->num_rows() > 0){
			echo json_encode($query->result_array());
			return;			
		 }

         echo 0; return;
	}
	public function GraficaPesoArriba($lote,$producto,$tipo)
	{
		$json = array();$i = 0;
		if ($tipo==1) {
			$query = $this->db->query("WITH TABLA AS (
									SELECT t0.PESOGRAMOS,t1.CODIGO,T1.DESCRIPCION,PESOBASCULA,DIFERENCIA from Reportes t0
																		inner join ReportesPeso t1 on t1.IDREPORTE = t0.IDREPORTE
																		where t0.ESTADO = 'A' and t0.IDTIPOREPORTE = 10 and T0.LOTE = '".$lote."' 
																		and T1.CODIGO = '".$producto."'
									)
									SELECT 
									CAST(COUNT(CASE WHEN PESOBASCULA >(PESOGRAMOS+(PESOGRAMOS*0.03)) THEN 1 ELSE NULL END)AS DECIMAL) /CAST(COUNT(PESOGRAMOS) AS DECIMAL)*100 PORCENTAJE
									FROM TABLA");
		}else{
			$query = $this->db->query("WITH TABLA AS (
									SELECT t0.DIAMETRO PESOGRAMOS,t1.CODIGO,T1.DESCRIPCION,PESOBASCULA,DIFERENCIA from Reportes t0
																		inner join ReportesPeso t1 on t1.IDREPORTE = t0.IDREPORTE
																		where t0.ESTADO = 'A' and t0.IDTIPOREPORTE = 16 and T0.LOTE = '".$lote."' 
																		and T1.CODIGO = '".$producto."'
									)
									SELECT 
									CAST(COUNT(CASE WHEN PESOBASCULA >PESOGRAMOS+0.2 THEN 1 ELSE NULL END)AS DECIMAL) /CAST(COUNT(PESOGRAMOS) AS DECIMAL)*100 PORCENTAJE
									FROM TABLA");
		}
		

		if($query->num_rows() > 0){
			echo json_encode($query->result_array());
			return;			
		 }

         echo 0; return;
	}

	public function GraficaEnvase($lote,$codigo,$maquina)
	{
		$json = array();$i = 0;
				
		/*echo 	"SELECT T1.CODIGO,T1.NOMBRE,(AVG(GC)+AVG(GT)+0.22)-AVG(L) AS CANTIDAD
			FROM Reportes T0
			INNER JOIN ReportesEnvases T1 ON T1.IDREPORTE = T0.IDREPORTE
			WHERE T0.IDTIPOREPORTE = 11 
			AND T1.LOTE = '".$lote."' AND T1.CODIGO = '".$codigo."' AND CABEZALMAQUINA = '".$maquina."'
			GROUP BY T1.CODIGO,T1.NOMBRE";*/
		$query = $this->db->query("SELECT T0.FECHACREA,T1.CODIGO,T1.NOMBRE,(AVG(GC)+AVG(GT)+0.22)-AVG(L) AS CANTIDAD
			FROM Reportes T0
			INNER JOIN ReportesEnvases T1 ON T1.IDREPORTE = T0.IDREPORTE
			WHERE T0.IDTIPOREPORTE = 11 
			AND T1.LOTE = '".$lote."' AND T1.CODIGO = '".$codigo."' AND CABEZALMAQUINA = '".$maquina."'
			GROUP BY t0.FECHACREA,T1.CODIGO,T1.NOMBRE,t0.IDREPORTE");		

		if($query->num_rows() > 0){
			echo json_encode($query->result_array());
			return;			
		 }

         echo 0; return;
	}

}
