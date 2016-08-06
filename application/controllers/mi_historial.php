<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mi_historial extends CI_Controller {

    public function index(){
        session_start();
        if(isset($_SESSION['email'])){
            $this->load->view('historial/mi_historial');
        }else{
            header('Location:/login');
        }
    }
    function peticiones(){
        try {
			$id = $this->input->get('id');
			$pagina = $this->input->get('pagina');
			$cantidad = $this->input->get('cantidad');
			$query = $this->db->query('CALL sp_get_log_procedimientos(?,?,?)', array($id,$pagina,$cantidad));

			if(!$query){
				throw new Exception('Error BD');
			}

			$resultado = $query->result();

			if($resultado > 0){
				echo json_encode(array('status'=>true,'data'=>$resultado));
			}else{
				echo json_encode(array('status'=>false,'data'=>'No hay datos'));
			}
		} catch (Exception $e) {
			echo json_encode(array('status'=>false,'data'=>'Error en base de datos'));
		}
    }

    function post_peticion(){
        try {
            $log_proc = $this->input->get('$log_proc');
            $login = $this->input->get("login");
            $api = $this->input->get('api');
            $modulo = $this->input->get('modulo');
            $tabla = $this->input->get('tabla');
            $proc = $this->input->get('proc');
            $comentario = $this->input->get('comentario');
            $tipo = $this->input->get('tipo');

            $query = $this->db->query('SELECT fn_post_log_procedimientos(?,?,?,?,?,?,?,?) as resultado', array($log_proc,$login,$api,$modulo,$tabla,$proc,$comentario,$tipo));

            $resultado = $query->row()->resultado;

			if($query){
				if($resultado >= 0){
					echo json_encode(array('status'=>true,'data'=>$resultado));
				}else{
					$query = $this->db->query('CALL sp_get_error (?)', array($resultado));
					$error = $query->result();
					echo json_encode(array('status'=>false,'data'=>$error));
				}
			}else{
				throw new Exception('Error BD');
			}
		} catch (Exception $e) {
			echo json_encode(array('status'=>false,'data'=>'Error en base de datos'));
		}
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
