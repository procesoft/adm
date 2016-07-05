<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gestortabla extends CI_Controller {

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
			$this->load->view('gestores/gestor_tablas');
        }else{
            header('Location:/login');
        }
    }
	function agregar_auxiliar(){
            try{
                extract($_GET);

                if (empty($v_campo)) {
                    $v_campo = '';
                }
                if (empty($v_ordenado)) {
                    $v_ordenado = '';
                }
                if (empty($v_fecha)) {
                    $v_fecha = '';
                }
				//fn_post_auxiliar(v_id_login,v_id_modulo , v_id_auxiliar)
				//fn_post_auxiliar($v_id_login,$v_id_modulo , $v_id_auxiliar)
                $query = $this->db->query('select fn_post_auxiliar(?,?,?) as resultado',array($v_id_login,$v_id_modulo , $v_id_auxiliar));
                if(!$query){
                    throw new Exception("Error BD");
                }
				if($query->result()[0]->resultado==0){
	                echo json_encode(array('status' => TRUE, 'data' => $query->result_array()));
	            }else{
					try{
						$error = $this->db->query('SELECT * from adm_cat_errores where codigo=?',array($query->result()[0]->resultado));
						if(!$error){
			                throw new Exception("Error BD");
			            }
						echo json_encode(array('status' => False, 'data' => $error->result()[0]->mensaje));
					}catch(Exception $e){
						echo json_encode(array('status' => FALSE, 'data' => "Error BD"));
					}
	            }
	        }catch(Exception $e){
	            echo json_encode(array('status' => FALSE, 'data' => "Error BD"));
	        }
	    }

	function traer_datos(){
            try{
                extract($_GET);

                if (empty($v_campo)) {
                    $v_campo = '';
                }
                if (empty($v_ordenado)) {
                    $v_ordenado = '';
                }
                if (empty($v_fecha)) {
                    $v_fecha = '';
                }
				//v_nombre,v_id_tabla ,v_fecha , v_num_pagina, v_cantidad, v_campo, v_ordenado
				//$v_nombre,$v_id_tabla ,$v_fecha ,$v_num_pagina,$v_cantidad,$v_campo,$v_ordenado
                $query = $this->db->query('call SP_GET_ADM_TABLAS(?,?,?,?,?,?,?)',array($v_id_modulo,$v_nombre,$v_fecha ,$v_num_pagina,$v_cantidad,$v_campo,$v_ordenado ));
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
			//v_id_login ,v_id_api , v_id_modulo, v_nombre,v_descripcion, v_tipo
			//$v_id_login ,$v_id_api , $v_id_modulo, $v_nombre, $v_descripcion, $v_tipo
            $query = $this->db->query('SELECT FN_POST_TABLA(?,?,?,?,?,?) as resultado',array($v_id_login ,$v_id_api , $v_id_modulo, $v_nombre, $v_descripcion, $v_tipo));
            if(!$query){
                throw new Exception("Error BD");
            }
            if($query->result()[0]->resultado==0){
                echo json_encode(array('status' => TRUE, 'data' => $query->result_array()));
            }else{
				try{
					$error = $this->db->query('SELECT * from adm_cat_errores where codigo=?',array($query->result()[0]->resultado));
					if(!$error){
		                throw new Exception("Error BD");
		            }
					echo json_encode(array('status' => False, 'data' => $error->result()[0]->mensaje));
				}catch(Exception $e){
					echo json_encode(array('status' => FALSE, 'data' => "Error BD"));
				}
            }
        }catch(Exception $e){
            echo json_encode(array('status' => FALSE, 'data' => "Error BD"));
        }
    }
    function modificar(){
        try{
            extract($_POST);
			//v_id_login ,v_id_tabla , v_nombre ,v_descripcion , v_tipo
			//$v_id_login ,$v_id_tabla , $v_nombre ,$v_descripcion , $v_tipo
            $query = $this->db->query('SELECT FN_PUT_TABLA(?,?,?,?,?) as resultado',array($v_id_login ,$v_id_tabla , $v_nombre ,$v_descripcion , $v_tipo));
            if(!$query){
                throw new Exception("Error BD");
            }
			if($query->result()[0]->resultado==0){
                echo json_encode(array('status' => TRUE, 'data' => $query->result_array()));
            }else{
				try{
					$error = $this->db->query('SELECT * from adm_cat_errores where codigo=?',array($query->result()[0]->resultado));
					if(!$error){
		                throw new Exception("Error BD");
		            }
					echo json_encode(array('status' => False, 'data' => $error->result()[0]->mensaje));
				}catch(Exception $e){
					echo json_encode(array('status' => FALSE, 'data' => "Error BD"));
				}
            }
        }catch(Exception $e){
            echo json_encode(array('status' => FALSE, 'data' => "Error BD"));
        }
    }
    function eliminar(){
        try{
            extract($_POST);
            $query = $this->db->query('SELECT 	FN_DEL_ADM_TABLA(?,?) as resultado',array($v_id_login,$v_id_tabla));
            if(!$query){
                throw new Exception("Error BD");
            }
			if($query->result()[0]->resultado==0){
                echo json_encode(array('status' => TRUE, 'data' => $query->result_array()));
            }else{
				try{
					$error = $this->db->query('SELECT * from adm_cat_errores where codigo=?',array($query->result()[0]->resultado));
					if(!$error){
		                throw new Exception("Error BD");
		            }
					echo json_encode(array('status' => False, 'data' => $error->result()[0]->mensaje));
				}catch(Exception $e){
					echo json_encode(array('status' => FALSE, 'data' => "Error BD"));
				}
            }
        }catch(Exception $e){
            echo json_encode(array('status' => FALSE, 'data' => "Error BD"));
        }
    }
    function detalle(){
        try{
            extract($_GET);
            $query = $this->db->query('CALL SP_GET_DETALLE_TABLA(?)',array($v_id_tabla));
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
