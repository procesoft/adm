<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class C_test extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library("Pdf");
        //$this->load->model('consultas');
    }

    public $bandera_continuar = false;
    public $bandera_continuar_ex = false;
    public $bandera_continuar_tras = false;

    public function create_pdf_alcance() {
        try {
            $count = 0;
            $hoy=getdate();
            extract($_GET);


            if (empty($v_fecha_inicio)) {
                $v_fecha_inicio = '';
            }
            if (empty($v_fecha_fin)) {
                $v_fecha_fin = '';
            }
            if (empty($v_modulos_minimos)) {
                $v_modulos_minimos = '';
            }


            $v_fecha_inicio = $_GET['v_fecha_inicio'];
            $v_fecha_fin = $_GET['v_fecha_fin'];
            $v_modulos_minimos = $_GET['v_modulos_minimos'];

            $query = $this->db->query('call sp_get_reporte_apis(?,?,?)',array($v_fecha_inicio,$v_fecha_fin,$v_modulos_minimos));

            if (!$query) {
                throw new Exception('Error en query');
                return false;
            }

            if ($query->num_rows() == 0) {
                echo "No existen datos";
                $bandera_continuar_tras = false;
            } else {
                $info = $query->result_array();
                $bandera_continuar_tras = true;
            }
        } catch (Exception $ex) {
            echo "Hubo un error al momento de intentar imprimir el pdf, intentalo más tarde";
            $bandera_continuar_tras = false;
        }

        if ($bandera_continuar_tras == true) {

            // create new PDF document
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

            // set document information
            $pdf->SetCreator(PDF_CREATOR);
            //$pdf->SetAuthor('Guadalajara');
            //$pdf->SetTitle('Formato Guadalajara');
            //$pdf->SetSubject('Formatos Espacios Abiertos');
            //$pdf->SetKeywords('Guadalajara, centro_historico');

            // set default header data
            //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, '', '', array(91, 104, 113), array(91, 104, 113));
            $pdf->setFooterData(array(91, 104, 113), array(91, 104, 113));

            // set header and footer fonts
            $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

            // set default monospaced font
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

            // set margins
            $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

            // set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

            // set image scale factor
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
            // set some language-dependent strings (optional)
            if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
                require_once(dirname(__FILE__) . '/lang/eng.php');
                $pdf->setLanguageArray($l);
            }
            // ---------------------------------------------------------
            // set default font subsetting mode
            $pdf->setFontSubsetting(false);

            $pdf->SetFont('times', '', 8.5);
            // Add a page
            // This method has several options, check the source code documentation for more information.
            $pdf->AddPage();
            //LOGO MUJERES
            //$imgdata = base64_decode('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');
            //$pdf->Image('@' . $imgdata, 140, 5, 55, 23);
            // set text shadow effect
            $pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));



            // Set some content to print
            $raw_html = '<h4 style="text-align: center;"></h4>'
                    . '<h4 style="text-align: center; font-size:10;"></h4>'
                    . '<table class="bordered highlight" style="margin-top:30px;">'
                        .'<tr>'
                        .'<th class="text-center col-md-1">ID</th>'
                        .'<th class="text-center col-md-3">Nombre del api</th>'
                        .'<th class="text-center col-md-3">Entrega</th>'
                        .'<th class="text-center col-md-2">Módulos</th>'
                        .'<th class="text-center col-md-2">Tablas</th>'
                        .'<th class="text-center col-md-1">Procedimientos</th>'
                        .'<th class="text-center col-md-1">Dias</th>'
                        .'</tr>';


            $limite = 0;
            foreach ($info as $datos) {
                    if ($limite == 1) {
                        $raw_html.='<br pagebreak="true"/>';
                        $limite = 0;
                    }
                    //$limite++;
                    $raw_html .='<tbody>'
                        .'<tr ng-repeat="listas in listas">'
                        .'<td class="text-center">' . $datos['id_api'] .'</td>'
                        .'<td class="text-center">' . $datos['nombre'] .'</td>'
                        .'<td class="text-center">' . $datos['fecha'] .'</td>'
                        .'<td class="text-center">' . $datos['modulos'] .'</td>'
                        .'<td class="text-center">' . $datos['tablas'] .'</td>'
                        .'<td class="text-center">' . $datos['procedimientos'] .'</td>'
                        .'<td class="text-center">' . $datos['dias'] .'</td>'
                        .'</tr>'
                        .'</tbody>'
                        .'</table>';
                    /*$raw_html .='<table><tr>'
                            . '<td style="float:left" colspan="3"></td>'
                            . '</tr>'
                            . '<br><tr>'
                            . '<td style="width:100%; height:50px; text-align: center"><h2>Lugar de donde proviene</h2></td>'
                            . '</tr>'
                            . '<br><tr>'
                            . '<td style="width:13%;"><h3>Cementerio:</h3></td>'
                            . '<td style="width:3%;"></td>'
                            . '<td style="border-bottom: .5px solid black;float:left;text-align: center; width:50%;">  ' . $datos['clasificacion'] . '</td>'
                            . '</tr>'
                            . '<br><tr>'
                            . '<td style="width:18%;"><h3>Sección:</h3> </td>'
                            . '<td style="text-align: center;width:10%;"> </td>'
                            . '<td style="width:18%;"><h3>Línea:</h3> </td>'
                            . '<td style="text-align: center;width:10%;"> </td>'
                            . '<td style="width:18%;"><h3>Fosa: </h3></td>'
                            . '</tr>'
                            . '<br><tr>'
                            . '<td style="border-bottom: .5px solid black;float:left;text-align: center;width:18%;">  ' . $datos['seccion'] . '</td>'
                            . '<td style="width:10%;"></td>'
                            . '<td style="border-bottom: .5px solid black;float:left;text-align: center;width:18%;">  ' . $datos['linea'] . '</td>'
                            . '<td style="width:10%;"></td>'
                            . '<td style="border-bottom: .5px solid black;float:left;text-align: center;width:18%;">  ' . $datos['fosa'] . '</td>'
                            . '</tr>'
                            . '<br><tr>'
                            . '<td style="width:100%; height:50px; text-align: center"><h2>Datos de Inhumación</h2></td>'
                            . '</tr>'
                            . '<br><tr>'
                            . '<td style="width:13%;"><h3>Clasificación:</h3></td>'
                            . '<td style="width:60%;"></td>'
                            . '<td style="width:20%; text-align: right;"><b>Registro: </b>' . $datos['registro'] . '</td>'
                            . '</tr>'
                            . '<br><tr>'
                            . '<td style="border-bottom: .5px solid black;float:left;text-align: center; width:50%;">  ' . $datos['clasificacion'] . '</td>'
                            . '</tr>'
                            . '<br><tr>'
                            . '<td style="width:18%;"><h3>Fecha de compra:</h3> </td>'
                            . '<td style="text-align: center; width:29%;">  </td>'
                            . '<td style="width:18%;"><h3>Partida de pago:</h3> </td>'
                            . '<td style="text-align: center;width:20%;"> </td>'
                            . '</tr>'
                            . '<br><tr>'
                            . '<td style="border-bottom: .5px solid black;float:left;text-align: center; width:35%;">  ' . $datos['fecha'] . '</td>'
                            . '<td style="width:12%;"></td>'
                            . '<td style="border-bottom: .5px solid black;float:left;text-align: center;width:30%;">  ' . $datos['ppago'] . '</td>'
                            . '</tr>'
                            . '<br><tr>'
                            . '<td style="width:18%;"><h3>Nombre: </h3></td>'
                            . '</tr>'
                            . '<br><tr>'
                            . '<td style="border-bottom: .5px solid black;float:left;text-align: center;width:100%;">  ' . $datos['nombre'] . '</td>'
                            . '</tr>'
                            . '<br><tr>'
                            . '<td style="width:18%;"><h3>Sección:</h3> </td>'
                            . '<td style="text-align: center;width:10%;"> </td>'
                            . '<td style="width:18%;"><h3>Línea:</h3> </td>'
                            . '<td style="text-align: center;width:10%;"> </td>'
                            . '<td style="width:18%;"><h3>Fosa: </h3></td>'
                            . '</tr>'
                            . '<br><tr>'
                            . '<td style="border-bottom: .5px solid black;float:left;text-align: center;width:18%;">  ' . $datos['seccion'] . '</td>'
                            . '<td style="width:10%;"></td>'
                            . '<td style="border-bottom: .5px solid black;float:left;text-align: center;width:18%;">  ' . $datos['linea'] . '</td>'
                            . '<td style="width:10%;"></td>'
                            . '<td style="border-bottom: .5px solid black;float:left;text-align: center;width:18%;">  ' . $datos['fosa'] . '</td>'
                            . '</tr>'
                            . '<br><tr>'
                            . '<td style="width:18%;"><h3>No. registro civil:</h3> </td>'
                            . '<td style="text-align: center; width:32%;">  </td>'
                            . '<td style="width:13%;"><h3>No. de acta:</h3> </td>'
                            . '</tr>'
                            . '<br><tr>'
                            . '<td style="border-bottom: .5px solid black;float:left;text-align: center; width:40%;">  ' . $datos['regcivil'] . '</td>'
                            . '<td style="width:10%;"></td>'
                            . '<td style="border-bottom: .5px solid black;float:left;text-align: center;width:50%;">  ' . $datos['num_acta'] . '</td>'
                            . '</tr>'
                            . '<br><tr>'
                            . '<td style="width:20%;"><h3>Funeraria: </h3></td>'
                            . '<td style="text-align: center; width:30%;"> </td>'
                            . '<td style="width:20%;"><h3>Trabajo a realizar:</h3> </td>'
                            . '</tr>'
                            . '<br><tr>'
                            . '<td style="border-bottom: .5px solid black;float:left;text-align: center; width:40%;">  '. $datos['funeraria'] . '</td>'
                            . '<td style="width:10%;"></td>'
                            . '<td style="border-bottom: .5px solid black;float:left;text-align: center;width:50%;">  ' . $datos['trabajo'] . '</td>'
                            . '</tr>'
                            . '<br><tr>'
                            . '<td style="width:20%"><h3>Otros:</h3></td>'
                            . '<br></tr>'
                            . '<br><tr>'
                            . '<td style="border-bottom: .5px solid black;float:left;text-align: center; width:100%;">  ' . $datos['otros'] . '</td>'
                            . '<br></tr>'
                            . '<br><br><tr>'
                            . '<td style="height:100px;"> </td>'
                            . '</tr>'
                            . '<br><br><tr>'
                            . '<td style="width:24%;"> </td>'
                            . '<td style="border-bottom: .5px solid black;float:left;text-align: center; width:50%;">  </td>'
                            . '</tr>'
                            . '<br><tr>'
                            . '<td style="width:24%;"> </td>'
                            . '<td style="text-align: center; width:50%;"><h3>Administrador del cementerio</h3></td>'
                            . '</tr>'
                            . '</table>';*/

            }
            $html = <<<EOD
    $raw_html
EOD;


            $pdf->SetFont('times', '', 8.5);
            $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
            ob_end_clean();
            // TERMINA FORMATO DE DESISTIMIENTO DE ASIGNACIÓN EN ESTRATEGIA DE ORDENAMIENTO ANTERIOR
            // ---------------------------------------------------------
            // Close and output PDF document
            // This method has several options, check the source code documentation for more information.
            $pdf->Output('traslado.pdf', 'I');

            //============================================================+
            // END OF FILE
            //============================================================+
        }
    }


}
