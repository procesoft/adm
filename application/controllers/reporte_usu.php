<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reporte_usu extends CI_Controller {

    public function index(){
        session_start();
        if(isset($_SESSION['email'])){
            $this->load->view('reporte/reporte_usu');
        }else{
            header('Location:/login');
        }
    }

    function traer_datos(){
            try{
                extract($_GET);

                if (empty($usuario)) {
                    $usuario = 0;
                }
                if (empty($estatus)) {
                    $estatus = '';
                }
				if (empty($pag)) {
                    $pag = 1;
                }
                if (empty($cant)) {
                    $cant = 10;
                }
                $query = $this->db->query('call sp_get_reporte_responsables(?,?,?,?)',array($usuario,$estatus,$pag,$cant));
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
