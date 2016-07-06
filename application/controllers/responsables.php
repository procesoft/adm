<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Responsables extends CI_Controller {

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
			$this->load->view('responsables/responsables');
        }else{
            header('Location:/login');
        }
    }
	public function mail()
	{
		$correo=$_POST['correo'];
		$pass=$_POST['pass'];
		$nom=$_POST['nom'];

        require_once("assets/PHPMailer/class.phpmailer.php");
        require_once("assets/PHPMailer/class.smtp.php");
		require_once("assets/PHPMailer/PHPMailerAutoload.php");

        $this->email = new PHPMailer();
        $this->email->IsSMTP();
		$this->email->SMTPDebug = 2;
        $this->email->SMTPAuth = true;
        $this->email->SMTPSecure = "ssl";
        $this->email->Host = "smtp.gmail.com";
        $this->email->Port = 465;
        $this->email->Username = 'contacto.procesoft@gmail.com';
        $this->email->From = "contacto.procesoft@gmail.com";
        $this->email->Password = "utjproyecto";

        $this->email->From = "contacto.procesoft@gmail.com";
        $this->email->FromName = "Procesoft";
        $this->email->Subject = "ADM::Registro Usuario";
        $this->email->MsgHTML("Hola ".$nom."!!<br> Bienvenido, ya eres parte de administracion de modulos, Donde podras administrar el flujo de trabajo en el proyecto en el cual estas trabajando. <br><br> Para ingresar: <br><br> Usuario: ".$correo."<br> Contraseña: ".$pass."<br><br> Cualquier anomalia referente a tu cuenta hazla saber a contacto.procesoft@gmail.com ");

        $this->email->AddAddress($correo, "destinatario");

        $this->email->IsHTML(true);
        if(!$this->email->Send()) {
			print_r('mal');
            echo "<b>Error:" . $this->email->ErrorInfo."</b><br/>";
         }
         else {
			 print_r('bien');
            return "Mensaje enviado correctamente";
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
				if (empty($v_ordenado)) {
                    $v_ordenado = '';
                }
                if (empty($v_fecha)) {
                    $v_fecha = '';
                }
                $query = $this->db->query('call SP_GET_ADM_RESPONSABLES(?,?,?,?,?,?,?,?)',array($v_id_responsable,$v_activo,$v_nombre,$v_id_rol,$v_num_pagina,$v_cantidad,$v_campo,$v_ordenado));
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

    function nuevo(){
        try{
            extract($_POST);
            $query = $this->db->query('SELECT FN_POST_ADM_RESPONSABLES(?,?,?,?,?,?,?,?) as resultado',array($v_id_login, $v_usuario, $v_password, $v_nombre, $v_apellido_paterno, $v_apellido_materno, $v_nick, $v_id_rol ));
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
            $query = $this->db->query('SELECT FN_DEL_ADM_RESPONSABLES(?,?) as resultado',array($v_id_login,$v_id_responsableS));
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
