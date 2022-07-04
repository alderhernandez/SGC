<?php

/**
 * @Author: cesar mejia
 * @Date:   2019-08-23 09:58:33
 * @Last Modified by:   cesar mejia
 * @Last Modified time: 2019-08-27 16:05:00
 */
class Hana_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public $BD = 'SBO_DELMOR';

	public function OPen_database_odbcSAp()
	{
		$conn = @odbc_connect("HANAPHP","DELMOR","CazeheKuS2th", SQL_CUR_USE_ODBC);
         if(!$conn){
            echo '<div class="row errorConexion white-text center">
                    ¡ERROR DE CONEXION CON EL SERVIDOR!
                </div>';
         } else {
           return $conn;
         }
	}

	public function getProductosSAP($search)
	{
        $qfilter = '';
        if($search){
        	$qfilter = 'AND ("ItemName" LIKE '."'%".$search."%'".'
                        OR "ItemCode" LIKE '."'%".$search."%'".') ';
		}else{
            $qfilter = '';
        }
				//WHERE "ItemCode" between '.'1101'.' and '.'88101'.'
        $conn = $this->OPen_database_odbcSAp();
                    $query = 'SELECT DISTINCT "ItemCode","ItemName","SWeight1"
                        FROM '.$this->BD.'."VIEW_BODEGAS_EXISTENCIAS"
												WHERE "SWeight1" > 1
                        '.$qfilter.'
                        GROUP BY "ItemCode","ItemName","SWeight1"
                        LIMIT 10';

            $resultado = @odbc_exec($conn,$query);
            $json = array();
            $i = 0;
            while ($fila = @odbc_fetch_array($resultado)) {
                $json[$i]["ItemCode"] = utf8_encode($fila["ItemCode"]);
                $json[$i]["ItemName"] = utf8_encode($fila["ItemName"]);
                $json[$i]["SWeight1"] = utf8_encode($fila["SWeight1"]);
                $i++;
            }
            echo json_encode($json);
            //echo @odbc_error($conn);
            @odbc_close($conn);
    }

    public function getPresentacionById($ItemCode)
	{
				//WHERE "ItemCode" between '.'1101'.' and '.'88101'.'
        $conn = $this->OPen_database_odbcSAp();
                    $query = 'SELECT "SWeight1"
                        FROM '.$this->BD.'."OITM"
                        WHERE "ItemCode" =  '."'".$ItemCode."'".' ';

            $resultado = @odbc_exec($conn,$query);
            $json = array();
            $i = 0;
            while ($fila = @odbc_fetch_array($resultado)) {
                $json[$i]["SWeight1"] = utf8_encode($fila["SWeight1"]);
                $i++;
            }
            echo json_encode($json);
            //echo @odbc_error($conn);
            @odbc_close($conn);
    }

    public function getGramos($itemcode){
        $conn = $this->OPen_database_odbcSAp();

        $KG = 'KG';
        $LB = 'LB';
        $query = 'SELECT IFNULL(CASE WHEN T0."SalUnitMsr" = '."'".$KG."'".' THEN 1000 WHEN  T0."SalUnitMsr" = '."'".$LB."'".'     THEN 454 ELSE T0."SWeight1" end,0) "GRAMOS"             FROM '.$this->BD.'."OITM" T0 WHERE T0."ItemCode" = '."'".$itemcode."'";
        //echo $query;
        $resultado = @odbc_exec($conn,$query);
        $json = array();
        $i = 0;
        while ($fila = @odbc_fetch_array($resultado)){
            $json[$i]["GRAMOS"] = $fila["GRAMOS"];
            $i++;
        }
        echo json_encode($json);
        //echo json_encode(@odbc_error($conn));
    }
}