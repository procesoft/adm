<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Historial extends CI_Controller {

    public function index(){
        session_start();
        if(isset($_SESSION['email'])){
            $this->load->view('historial/historial');
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
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
