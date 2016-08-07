
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
    <title>Reportes</title>

    <body ng-app="appResponsables">
        <div class="col s12"  ng-controller="controlador" style="margin.bottom:200px;">
            <nav>
                <div class="nav-wrapper"  style="height:250%; background-color:#232A36;">
                    <div class="container" style="width:80%;">
                        <div class="row">
                            <a href="/" class="brand-logo" style="color:#B1B1B1; margin-top:10px;"><img src="/assets/img/logo_admin.png" style="width:55px; height:50px;"/>&nbsp;ADMINISTRACIÓN DE MÓDULOS</a>
                            <a href="" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
                            <ul id="nav-mobile" class="right hide-on-med-and-down">
                                <li><a href="/api">Api's</a></li>
                                <li><a ng-click="verresponsables()">Responsables</a></li>
                                <li><a id="sesion" style="padding-inline-start:100px;" class="dropdown-button" href="" data-activates='dropdown1'>Hola!! </a></li>
                            </ul>
                            <ul class="side-nav" id="mobile-demo">
                                <li><a href="/api">Api's</a></li>
                                <li><a ng-click="verresponsables()" style="border-bottom:solid #00A79D;">Responsables</a></li>
                                <li><a ng-click="logout()">Salir</a></li>
                            </ul>
                        </div>

                        <div class="row">
                            <ul id="nav-mobile" class="left hide-on-med-and-down">
                                <li><a href="/reporte_alcance" style="color:#B1B1B1; cursor:pointer; ">Reporte alcance</a></li>
                                <li><a href="/reporte_usuario" style="color:#B1B1B1; cursor:pointer; border-bottom:solid #00A79D;">Reporte usuario</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
                                <!-- Dropdown Structure -->
                                <ul id='dropdown1' class='dropdown-content'style="margin-top:45px;">
                                    <li><a href="/mi_historial">Mis Pendientes</a></li>
                                    <li><a href="/mi_perfil">Mi perfil</a></li>
                                    <li><a href="/reporte_alcance">Reportes</a></li>
                                    <li><a href="" ng-click="logout()">Salir</a></li>
                                </ul>

                                <ul id='api' class='dropdown-content'style="margin-top:45px;" width="100px">
                                  <li><a href="">Todos</a></li>
                                  <li><a href="">En los que trabajo</a></li>
                                </ul>

        <div class="row" style="margin-top:150px;">
            <div class="container">
                <div class="col s11 offset-s1">
                <div class="row">

                    <div id="activo1" class="input-field col s3 offset-s9">
                        <select id="estatus" ng-model="estatus" ng-change="listar_datos()">
                            <option value="" disabled selected>Activo</option>
                            <option value="D">Definición</option>
                            <option value="P">Progreso</option>
                            <option value="R">Revisión</option>
                            <option value="T">Terminado</option>
                        </select>
                    </div>
                    <div id="activo2" class="input-field col s3 offset-s9">
                        <select id="estatus2" ng-model="estatus2" ng-change="detalles(0)">
                            <option value="" disabled selected>Activo</option>
                            <option value="D">Definición</option>
                            <option value="P">Progreso</option>
                            <option value="R">Revisión</option>
                            <option value="T">Terminado</option>
                        </select>
                    </div>
                </div>
                </div>
                <div class="row" style="margin-bottom:100px;">
                    <div class="col s11 offset-s1">
                        <table class="bordered highlight" style="margin-top:30px;" ng-show="!ocultar">
                            <tr ng-if="!cambio_tbl">
                                <th style="text-align: center;">ID</th>
                                <th style="text-align: center;">Nombre Usuario</th>
                                <th style="text-align: center;" >Rol</th>
                                <th style="text-align: center;" >Apis</th>
                                <th style="text-align: center;">Módulos</th>
                                <th style="text-align: center;">Responsable</th>
                                <th style="text-align: center;">Auxiliar</th>
                            </tr>
                            <tr ng-if="cambio_tbl">
                                <th style="text-align: center;">Nombre Api</th>
                                <th style="text-align: center;">Situación</th>
                                <th style="text-align: center;" >Nombre Módulo</th>
                                <th style="text-align: center;" >Estatus</th>
                            </tr>
                        <tbody>
                            <tr ng-repeat="listas in listas" ng-if="!cambio_tbl">
                                <td style="text-align: center; cursor:pointer;" ng-click="detalles(listas.id_responsable)">{{listas.id_responsable}}</td>
                                <td style="text-align: center; cursor:pointer;" ng-click="detalles(listas.id_responsable)">{{listas.nick}}</td>
                                <td style="text-align: center; cursor:pointer;" ng-click="detalles(listas.id_responsable)">{{listas.id_rol}}</td>
                                <td style="text-align: center; cursor:pointer;" ng-click="detalles(listas.id_responsable)">{{listas.apis}}</td>
                                <td style="text-align: center; cursor:pointer;" ng-click="detalles(listas.id_responsable)">{{listas.modulos}}</td>
                                <td style="text-align: center; cursor:pointer;" ng-click="detalles(listas.id_responsable)">{{listas.responsables}}</td>
                                <td style="text-align: center; cursor:pointer;" ng-click="detalles(listas.id_responsable)">{{listas.auxiliares}}</td>
                            </tr>
                            <tr ng-repeat="listas in listas" ng-if="cambio_tbl">
                                <td style="text-align: center;">{{listas.Api}}</td>
                                <td style="text-align: center;">{{listas.responsable}}</td>
                                <td style="text-align: center;">{{listas.Modulo}}</td>
                                <td style="text-align: center;">{{listas.status}}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="col s12" ng-show="ocultar">
                        <center>
                        <span><h4>No hay datos<h4></span>
                        </center>
                    </div>
                </div>
                <div class="col s12" ng-if="!cambio_tbl" ng-show="pag_total != 1" style="margin-top:20px;">
                    <center>
                        <span style="cursor:pointer;" ng-hide="pagina == 1" ng-click="anterior(-1)">< </span>pagina {{pagina}} de {{pag_total}}<span style="cursor:pointer;" ng-hide="pagina == pag_total"  ng-click="siguiente(+1)"> ></span>
                    </center>
                </div>
                <div class="col s12" ng-if="cambio_tbl" ng-show="pag_total != 1" style="margin-top:20px;">
                    <center>
                        <span style="cursor:pointer;" ng-hide="pagina == 1" ng-click="anterior2(-1)">< </span>pagina {{pagina2}} de {{pag_total}}<span style="cursor:pointer;" ng-hide="pagina2 == pag_total"  ng-click="siguiente2(+1)"> ></span>
                    </center>
                </div>
                <div class="col s12" ng-show="pag_total != ''" style="margin-top:20px;" ng-if="!cambio_tbl">
                    <center>
                        <a ng-click="imprimir()" style="cursor:pointer;"><label for="">Ver Pdf</label><br>
                        <img src="/assets/img/pdf.png" alt="" width="50px" /></a>
                    </center>
                </div>
                <div class="col s12" ng-show="pag_total != ''" style="margin-top:20px;" ng-if="cambio_tbl">
                    <center>
                        <a ng-click="imprimir2()" style="cursor:pointer;"><label for="">Ver Pdf</label><br>
                        <img src="/assets/img/pdf.png" alt="" width="50px" /></a>
                    </center>
                </div>
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
          <script src="/assets/scripts/reporte_usu.js" charset="utf-8"></script>
          <script src="/assets/scripts/validador_caracter.js" charset="utf-8"></script>
          <script src="/assets/jquery.blockUI.js" charset="utf-8"></script>
          <script>
              bloquear = function () {
                  $.blockUI({
                      css: {
                          border: 'none',
                          padding: '15px',
                          backgroundColor: '#000',
                          '-webkit-border-radius': '10px',
                          '-moz-border-radius': '10px',
                          opacity: .5,
                          color: '#fff'
                      }
                  });
              }

              desbloquear = function () {
                  $.unblockUI();
              }
          </script>
    </body>
  </html>
