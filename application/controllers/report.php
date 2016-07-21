<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report extends CI_Controller {

    public function index(){
        session_start();
        if(isset($_SESSION['email'])){
            $this->load->view('reporte/reportes');
        }else{
            header('Location:/login');
        }
    }

    function traer_datos(){
            try{
                extract($_GET);

                if (empty($v_campo)) {
                    $v_campo = '';
                }
                if (empty($v_activo)) {
                    $v_activo = '';
                }
				if (empty($v_fecha_inicio)) {
                    $v_fecha_inicio = '';
                }
                if (empty($v_fecha_fin)) {
                    $v_fecha_fin = '';
                }
                $query = $this->db->query('call sp_get_reporte_apis(?,?,?,?,?)',array($v_fecha_inicio,$v_fecha_fin,$v_modulos_minimos,$v_num_pagina,$v_cantidad));
                if(!$query){
                    throw new Exception("Error BD");
                }
                if($query->num_rows()==0){
                    echo json_encode(array('status' => false, 'data' => $query->result_array()));
                }else{
                    echo json_encode(array('status' => TRUE, 'data' => $query->result_array()));
                }
            }catch(Exception $e){
                echo json_encode(array('status' => FALSE, 'data' => "Error BD"));
            }
        }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
