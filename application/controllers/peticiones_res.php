<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Peticiones_res extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index(){
        session_start();
        if(isset($_SESSION['email'])){
			$this->load->view('peticiones/peticiones_res');
        }else{
            header('Location:/login');
        }
    }
    function detalle(){
        try{
            extract($_GET);
            $query = $this->db->query('CALL SP_GET_DETALLE_RESPONSABLE(?)',array($v_id_responsables));
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
	function tareas(){
		try{
			extract($_GET);
			$query = $this->db->query('CALL sp_get_tareas_pendientes(?)',array($v_id_responsables));
			if(!$query){
				throw new Exception("Error BD");
			}
			if($query->num_rows()==0){
				echo json_encode(array('status' => TRUE, 'data' => $query->result_array()));
			}else{
				echo json_encode(array('status' => true, 'data' => $query->result_array()));
			}
		}catch(Exception $e){
			echo json_encode(array('status' => FALSE, 'data' => "Error BD"));
		}
	}
	function historial(){
		try{
			extract($_GET);


			$query = $this->db->query('CALL sp_get_historial_responsables(?,?,?,?,?,?,?)',array($v_id_login,$v_id_responsables,$v_id_accion,$v_accion,"",$v_num_paginas,$v_cantidad));
			if(!$query){
				throw new Exception("Error BD");
			}
			if($query->num_rows()==0){
				echo json_encode(array('status' => TRUE, 'data' => $query->result_array()));
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
