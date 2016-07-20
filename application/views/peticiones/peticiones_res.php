
  <!DOCTYPE html>
  <html>
    <head>
      <meta charset="utf-8">
      <!--Import Google Icon Font-->
      <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <!--Import materialize.css-->
      <link type="text/css" rel="stylesheet" href="/assets/plugins/materialize/css/materialize.min.css"  media="screen,projection"/>
      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
      <link href="assets/js/sweetalert.css" rel="stylesheet" type="text/css"/>
      <link rel="icon" type="image/png" href="/assets/img/logo_admin.png" />
      <script src="assets/js/sweetalert.min.js" type="text/javascript"></script>
    </head>
    <title>Responsables</title>

    <body ng-app="appdetalle_res">
        <div class="col s12"  ng-controller="controlador" style="margin.bottom:200px;">
            <nav>
                <div class="nav-wrapper"  style="height:250%; background-color:#232A36;">
                    <div class="container" style="width:80%;">
                        <div class="row">
                            <a href="/" class="brand-logo" style="color:#B1B1B1; margin-top:10px;"><img src="/assets/img/logo_admin.png" style="width:55px; height:50px;"/>&nbsp;ADMINISTRACIÓN DE MÓDULOS</a>
                            <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
                            <ul id="nav-mobile" class="right hide-on-med-and-down">
                                <li><a href="/api">Api's</a></li>
                                <li><a href="/responsables" style="border-bottom:solid #00A79D;">Responsables</a></li>
                                <li><a id="sesion" style="padding-inline-start:100px;" class="dropdown-button" href="#" data-activates='dropdown1'>Hola!! </a></li>
                            </ul>
                            <ul class="side-nav" id="mobile-demo">
                                <li><a href="/api">Api's</a></li>
                                <li><a href="/responsables" style="border-bottom:solid #00A79D;">Responsables</a></li>
                                <li><a ng-click="logout()">Salir</a></li>
                            </ul>
                        </div>
                        <div class="row">
                            <div class="col s4" style="font-size:30px; height:0px;">
                                <a href="/responsables"><span style="color:#B1B1B1;">< Regresar</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
                                <!-- Dropdown Structure -->
                                <ul id='dropdown1' class='dropdown-content'style="margin-top:45px;">
                                  <li><a href="#!">Mis Pendientes</a></li>
                                  <li><a href="/mi_perfil">Mi perfil</a></li>
                                  <li><a href="#!" ng-click="logout()">Salir</a></li>
                                </ul>

                                <ul id='api' class='dropdown-content'style="margin-top:45px;" width="100px">
                                  <li><a href="#!">Todos</a></li>
                                  <li><a href="#!">En los que trabajo</a></li>
                                </ul>

            <div class="row" style="margin-top:125px;">
                <div class="container">
                    <div class="col s12">
                        <span id="responsable" style="color:#00A99D;"></span>
                    </div>
                    <div class="col s4 ">
                        <div class="col s12" style="text-align: right;">
                            <span><b>Estatus: </b></span><span id="status"></span>
                        </div>
                    </div>
                    <div class="col s4 offset-s4">
                        <span><b>Área: </b></span><span id="rol"></span>
                    </div>
                    <div class="col s4" style="text-align: right;">
                        <span><b>Módulos asignados: </b></span><span id="modulos"></span>
                    </div>
                    <div class="col s4 offset-s4">
                        <span><b>E-mail: </b></span><span id="mail"></span>
                    </div>
                </div>
            </div>
            <div class="row" style="background-color:#F2F2F2;">
                <div class="container">
                    <div class="col s12" style="margin-top:25px; margin-bottom:25px;">
                        <h5 style="color:#00A99D;"><b>Tareas pendientes</b></h5>
                    </div>
                    <div class="col s12" ng-repeat="listas in listas">
                        <div class="col s12">
                            <span style="color:#00A99D;" id="nombre_tarea">{{listas.nombre}}</span>
                        </div>
                        <div class="col s12">
                            <span id="fecha">{{listas.fecha_creacion | date}}</span>
                        </div>
                        <div class="col s12">
                            <span id="nombre_comentario">{{listas.nick}}</span>
                        </div>
                        <div class="col s12" style="margin-bottom:30px;">
                            <span id="comentario">{{listas.comentario}}</span>
                        </div>
                    </div>
                    <div class="col s12" ng-if="tareas_exist==1">
                        <h5><b>No hay tareas pendientes</b></h5>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="container">
                    <div class="col s12">
                        <span style="color:#00A99D;"><h5><b>Historial</b></h5></span>
                    </div>
                    <div style="float:left; margin-top:30px;">
                        <i class="material-icons dp48"><img src="/assets/img/buscador-de-lupa.png" alt="" /></i>
                    </div>
                    <div class="input-field col s2" style="margin-top:10px; margin-bottom:30px;">
                        <input style="height:50px;" type="text" placeholder="Buscar.." ng-model="buscador" ng-init="testAllowed($event);" id="txt_buscador">
                    </div>
                    <div class="col s11 offset-s1" ng-repeat="listas2 in listas2" style="border-bottom:solid #B1B1B1; margin-bottom:30px;">
                        <div class="col s12" style="margin-bottom:10px;">
                            <span>{{listas2.fecha_creacion | date}}  {{listas2.accion}} {{listas2.nick_responsable}}</span>
                        </div>
                    </div>
                    <center>
                    <div class="col s12" ng-show="ocultar" style="margin-bottom:100px;">
                        <center>
                        <span><h4>No hay datos<h4></span>
                        </center>
                    </div>
                    <div class="col s12" ng-if="pag_total != 1" style="margin-bottom:100px;">
                        <a id="mas" class="waves-effect waves-light btn" ng-click="pagina_sig(+1)">Más</a>
                    </div>
                    </center>
                </div>
            </div>


        </div>




      <!--Import jQuery before materialize.js-->
          <script src="/assets/plugins/jquery-2.2.4.js" charset="utf-8"></script>
          <script src="/assets/plugins/angular.js" charset="utf-8"></script>
          <script src="/assets/plugins/materialize/angular-materialize.js"></script>
          <script type="text/javascript" src="/assets/plugins/materialize/js/materialize.js"></script>
          <script src="/assets/plugins/typeahead.bundle.js" charset="utf-8"></script>
          <script src="/assets/plugins/jquery.inputmask.bundle.js" charset="utf-8"></script>
          <script src="/assets/scripts/detalle_res.js" charset="utf-8"></script>
    </body>
  </html>
