<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gestorapi extends CI_Controller {

    public function index()
    {
        session_start();
        if(isset($_SESSION['email'])){
            $this->load->view('gestores/gestor_api');
        }else{
            header('Location:/login');
        }
    }
    function traer_datos(){
            try{
                extract($_GET);
                if (empty($base_de_datos)) {
                    $base_de_datos = 0;
                }
                if (empty($status)) {
                    $status = '';
                }
                if (empty($campo)) {
                    $campo = '';
                }
                if (empty($ordenado)) {
                    $ordenado = '';
                }
                if (empty($fecha)) {
                    $fecha = '';
                }

                $query = $this->db->query('call sp_get_adm_apis(?,?,?,?,?,?,?,?)',array($nombre,$base_de_datos,$status,$fecha, $num_pagina, $cantidad, $campo, $ordenado));
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

    function filtros(){
        try{
            extract($_GET);
            $query = $this->db->query('call sp_get_bases_de_datos(?)',array($filtro));
            if(!$query){
                throw new Exception("Error BD");
            }
            if($query->num_rows()==0){
                echo json_encode(array('status' => TRUE, 'false' => $query->result_array()));
            }else{
                echo json_encode(array('status' => TRUE, 'data' => $query->result_array()));
            }
        }catch(Exception $e){
            echo json_encode(array('status' => FALSE, 'data' => "Error BD"));
        }
    }

    function nuevo(){
        try{
            extract($_POST);
            $query = $this->db->query('SELECT fn_post_adm_api(?,?,?,?,?) as resultado',array($v_id_login,$v_nombre,$v_prefijo,$v_id_base_de_datos,$v_descripcion));
            if(!$query){
                throw new Exception("Error BD");
            }
            if($query->num_rows()==0){
                echo json_encode(array('status' => TRUE, 'false' => $query->result_array()));
            }else{
                echo json_encode(array('status' => TRUE, 'data' => $query->result_array()));
            }
        }catch(Exception $e){
            echo json_encode(array('status' => FALSE, 'data' => "Error BD"));
        }
    }
    function modificar(){
        try{
            extract($_POST);
            $query = $this->db->query('SELECT FN_PUT_ADM_API(?,?,?,?,?,?) as resultado',array($v_id_login,$v_id_api,$v_nombre,$v_prefijo,$v_id_base_de_datos,$v_descripcion));
            if(!$query){
                throw new Exception("Error BD");
            }
            if($query->num_rows()==0){
                echo json_encode(array('status' => TRUE, 'false' => $query->result_array()));
            }else{
                echo json_encode(array('status' => TRUE, 'data' => $query->result_array()));
            }
        }catch(Exception $e){
            echo json_encode(array('status' => FALSE, 'data' => "Error BD"));
        }
    }
    function eliminar(){
        try{
            extract($_POST);
            $query = $this->db->query('SELECT fn_del_adm_api(?,?) as resultado',array($v_id_login,$v_id_api));
            if(!$query){
                throw new Exception("Error BD");
            }
            if($query->num_rows()==0){
                echo json_encode(array('status' => TRUE, 'false' => $query->result_array()));
            }else{
                echo json_encode(array('status' => TRUE, 'data' => $query->result_array()));
            }
        }catch(Exception $e){
            echo json_encode(array('status' => FALSE, 'data' => "Error BD"));
        }
    }
    function detalle(){
        try{
            extract($_GET);
            $query = $this->db->query('CALL SP_GET_DETALLE_API(?)',array($v_id_api));
            if(!$query){
                throw new Exception("Error BD");
            }
            if($query->num_rows()==0){
                echo json_encode(array('status' => TRUE, 'false' => $query->result_array()));
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
