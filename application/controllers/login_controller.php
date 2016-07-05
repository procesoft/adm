<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_controller extends CI_Controller {

    public function index(){
        session_start();
        if(isset($_SESSION['email'])){
            header('Location:/api');
        }else{
            $this->load->view('principal/login');
        }
    }

    public function postlogin() {

        try {
            session_start();
            extract($_POST);
            $query = $this->db->query('CALL sp_log_responsables(?,?)', array($user, $pass));

			if(!$query){
				throw new Exception('Error BD');
			}

			$resultado = $query->result();

			if($resultado > 0){
                if (isset($resultado[0]->id_responsable) && isset($resultado[0]->usuario)) {
                    $_SESSION["email"] = $resultado[0]->usuario;
                    $_SESSION["id_usuario"] = $resultado[0]->id_responsable;
                    $_SESSION["id_rol"] = $resultado[0]->id_rol;
                    $_SESSION["nick"] = $resultado[0]->nick;

                    echo json_encode(array("status" => true, 'data' => $resultado));
                } else {
                    $errors = 'Usuario no valido, intenta nuevamente';
                    echo json_encode(array("status" => false, 'data' => $resultado));
                }
			}else{
				echo json_encode(array('status'=>false,'data'=>'No hay datos'));
			}
        } catch (Exception $ex) {
            echo $ex;
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function logout() {
        session_start();
            unset($_SESSION["email"]);
            unset($_SESSION["id_usuario"]);
        session_destroy();
        echo json_encode(array("status" => true, 'data' => 0));
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
