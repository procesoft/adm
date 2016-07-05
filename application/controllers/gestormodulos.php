<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gestormodulos extends CI_Controller {

    public function index()
    {
        session_start();
        if(isset($_SESSION['email'])){
            $this->load->view('gestores/gestormodulos');
        }else{
            header('Location:/login');
        }
    }
    function traer_datos(){
            try{
                extract($_GET);

                if ($v_id_responsable_web == null) {
                    $v_id_responsable_web = 0;
                }
                if (empty($v_status_modulo)) {
                    $v_status_modulo = '';
                }
                if (empty($v_campo)) {
                    $v_campo = '';
                }
                if (empty($v_ordenado)) {
                    $v_ordenado = '';
                }
                if (empty($v_fecha)) {
                    $v_fecha = '';
                }
                $query = $this->db->query('call SP_GET_ADM_MODULOS(?,?,?,?,?,?,?,?,?,?)',array($v_id_api, $v_nombre_modulo, $v_id_responsable_web,$v_id_responsable_base, $v_status_modulo,$v_fecha,$v_num_pagina, $v_cantidad, $v_campo, $v_ordenado));
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
            $query = $this->db->query('call sp_get_asignar_responsable(?)',array($filtro));
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
            $query = $this->db->query('SELECT FN_POST_ADM_MODULO(?,?,?,?,?,?,?,?) as resultado',array($v_id_login,$v_id_api, $v_nombre,$v_descripcion, $v_id_responsable_web, $v_id_responsable_base, $v_id_auxiliar_web, $v_id_auxiliar_base));
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
            $query = $this->db->query('SELECT FN_PUT_ADM_MODULO(?,?,?,?,?,?,?,?,?) as resultado',array($v_id_login,$v_id_api, $v_id_modulo, $v_nombre,$v_descripcion, $v_id_responsable_web, $v_id_responsable_base, $v_id_auxiliar_web, $v_id_auxiliar_base));
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
            $query = $this->db->query('SELECT FN_DEL_ADM_MODULO(?,?) as resultado',array($v_id_login,$v_id_modulo));
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
            $query = $this->db->query('CALL SP_GET_DETALLE_MODULO(?)',array($v_id_modulo));
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
