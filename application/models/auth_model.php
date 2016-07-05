<?php

class Auth_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function usuario_por_nombre_contrasena($nombre, $contrasena) {
        $consulta = $this->db->query("CALL sp_get_usuario_gm ('$nombre', '$contrasena')");
        $res = $consulta->result()[0]->status;
        if($res == '0')
        {
            $resultado = $consulta->row();
            $this->session->set_userdata("valido", TRUE);
            return $resultado;
        }

    }

    public function valido() {
        //$this->load->library('session');
        if ($this->session->userdata("valido") === TRUE) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function recuperar($correo, $password) {

        $this->load->library('email');


        $config['protocol'] = "smtp";
        $config['smtp_host'] = "ssl://email-smtp.us-east-1.amazonaws.com";
        $config['smtp_port'] = "465";
        $config['smtp_user'] = "AKIAIHHTPYL2AA2LY3XQ"; 
        $config['smtp_pass'] = "Aqf4xSuTiavazMZDoV9fiF1g1120Jq4YnBp7oNCbtE2K";
        $config['charset'] = "utf-8";
        $config['mailtype'] = "html";
 

        $this->email->initialize($config);


        $this->email->from('noreply@lagentemanda.mx', 'LGM::Recuperar');
        $this->email->to($correo);
        $this->email->subject('Recuperar contraseña');
        $this->email->message("Hola Administrador tu contraseña para accesar al sistema es: " .$password);
        if ($this->email->send())
                echo json_encode(array('status' => TRUE, 'data' => 'Bien'));
        else
                echo json_encode(array('status' => FALSE, 'data' => 'No se envió'));


        var_dump($this->email->print_debugger());
    }

}
