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
    function revision(){
        try{
            extract($_POST);
            $query = $this->db->query('SELECT FN_PUT_STATUS(?,?,?) as resultado',array($v_id_login,$v_id_modulo,'R'));
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
    function terminado(){
        try{
            extract($_POST);
            $query = $this->db->query('SELECT FN_PUT_STATUS(?,?,?) as resultado',array($v_id_login,$v_id_modulo,'T'));
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
    function progreso(){
        try{
            extract($_POST);
            $query = $this->db->query('SELECT FN_PUT_STATUS(?,?,?) as resultado',array($v_id_login,$v_id_modulo,'P'));
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
    function usuario_qa(){
        try{
            $query = $this->db->query('SELECT * FROM adm_cat_responsables WHERE id_rol=6');
            if(!$query){
                throw new Exception("Error BD");
            }
            if($query->num_rows()>0){
                echo json_encode(array('status' => TRUE, 'data' => $query->result_array()));
            }else{
                echo json_encode(array('status' => false, 'data' => 'no data'));
            }
        }catch(Exception $e){

        }
    }
    function usuario_responsables(){
        try{
            $query = $this->db->query('SELECT * FROM adm_cat_responsables WHERE id_rol=1 or id_rol=3 or id_rol=2');
            if(!$query){
                throw new Exception("Error BD");
            }
            if($query->num_rows()>0){
                echo json_encode(array('status' => TRUE, 'data' => $query->result_array()));
            }else{
                echo json_encode(array('status' => false, 'data' => 'no data'));
            }
        }catch(Exception $e){

        }
    }
    function usuario_web(){
        try{
            $query = $this->db->query('SELECT * FROM adm_cat_responsables WHERE id_rol=2');
            if(!$query){
                throw new Exception("Error BD");
            }
            if($query->num_rows()>0){
                echo json_encode(array('status' => TRUE, 'data' => $query->result_array()));
            }else{
                echo json_encode(array('status' => false, 'data' => 'no data'));
            }
        }catch(Exception $e){

        }
    }
    function correo_revision(){
        $modulo=$_POST['modulo'];
        $correo=$_POST['correo'];

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
        $this->email->Subject = "ADM::Cambio de estatus";
        $this->email->MsgHTML("Hola QA!!<br> En estos momentos cambiaron a estatus de revisión el siguiente modulo:<br><br>".$modulo);

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
    function correo_progreso(){
        $modulo=$_POST['modulo'];
        $correo=$_POST['correo'];

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
        $this->email->Subject = "ADM::Cambio de estatus";
        $this->email->MsgHTML("Hola!!<br> En estos momentos QA revisó el siguiente modulo:<br>".$modulo."<br>Y lo regreso a estatus de progreso");

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
    function correo_terminado(){
        $modulo=$_POST['modulo'];
        $correo=$_POST['correo'];

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
        $this->email->Subject = "ADM::Cambio de estatus";
        $this->email->MsgHTML("Hola!!<br> En estos momentos el siguiente modulo:<br>".$modulo."<br> Se dio por terminado.");

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
    function detalles_modulos(){
        try{
            extract($_GET);
            $query = $this->db->query('call sp_get_adm_detalles(?,?)',array($v_opcion, $v_id_opcion));
            if(!$query){
                throw new Exception("Error BD");
            }
            if($query->num_rows()==0){
                echo json_encode(array('status' => false, 'data' => $query->result_array()));
            }else{
                echo json_encode(array('status' => TRUE, 'data' => $query->result_array()));
            }
        }catch(Exception $e){

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
            $query = $this->db->query('SELECT FN_PUT_ADM_MODULO(?,?,?,?,?,?,?,?,?) as resultado',array($v_id_login,$v_id_api, $v_id_modulo, $v_nombre,$v_descripcion, $v_id_responsable_web, $v_id_responsable_base, $v_id_auxiliar_web, $v_id_auxiliar_base));
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
            $query = $this->db->query('SELECT FN_DEL_ADM_MODULO(?,?) as resultado',array($v_id_login,$v_id_modulo));
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
