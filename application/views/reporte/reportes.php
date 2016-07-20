
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
                            <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
                            <ul id="nav-mobile" class="right hide-on-med-and-down">
                                <li><a href="/api">Api's</a></li>
                                <li><a ng-click="verresponsables()">Responsables</a></li>
                                <li><a id="sesion" style="padding-inline-start:100px;" class="dropdown-button" href="#" data-activates='dropdown1'>Hola!! </a></li>
                            </ul>
                            <ul class="side-nav" id="mobile-demo">
                                <li><a href="/api">Api's</a></li>
                                <li><a ng-click="verresponsables()" style="border-bottom:solid #00A79D;">Responsables</a></li>
                                <li><a ng-click="logout()">Salir</a></li>
                            </ul>
                        </div>

                        <div class="row">
                            <ul id="nav-mobile" class="left hide-on-med-and-down">
                                <li><a href="/reporte_alcance" style="color:#B1B1B1; cursor:pointer; border-bottom:solid #00A79D;">Reporte alcance</a></li>
                                <li><a href="/reporte_usuario" style="color:#B1B1B1; cursor:pointer;">Reporte usuario</a></li>
                            </ul>
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

        <div class="row" style="margin-top:150px;">
            <div class="container">
                <div class="col s11 offset-s1">
                <label for=""> Rango de fecha</label>
                <div class="row">
                    <div class="input-field col s2">
                        <input type="date"  class="datepicker" id="ini">
                    </div>
                    <div class="input-field col s2">
                        <input type="date" class="datepicker"  id="fin">
                    </div>
                    <div class="input-field col s2 offset-s6">
                        <input type="text" id="tamano" placeholder="numero modulos">
                        <label for="tamano">Tamaño</label>
                    </div>
                </div>
                </div>
                <div class="row" style="margin-bottom:100px;">
                    <div class="col s11 offset-s1">
                        <table class="bordered highlight" style="margin-top:30px;" ng-show="!ocultar">
                            <tr>
                                <th class="text-center col-md-1">ID</th>
                                <th class="text-center col-md-3">Nombre del api</th>
                                <th class="text-center col-md-3">Entrega</th>
                                <th class="text-center col-md-2">Módulos</th>
                                <th class="text-center col-md-2">Tablas</th>
                                <th class="text-center col-md-1">Procedimientos</th>
                                <th class="text-center col-md-1">Dias</th>
                            </tr>
                        <tbody>
                            <tr ng-repeat="listas in listas">
                                <td class="text-center">{{listas.id_api}}</td>
                                <td class="text-center">{{listas.nombre}}</td>
                                <td class="text-center">{{listas.fecha | date}}</td>
                                <td class="text-center">{{listas.modulos}}</td>
                                <td class="text-center">{{listas.tablas}}</td>
                                <td class="text-center">{{listas.procedimientos}}</td>
                                <td class="text-center">{{listas.dias}}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="col s12" ng-show="ocultar">
                        <center>
                        <span><h4>No hay datos<h4></span>
                        </center>
                    </div>
                </div>
                <div class="col s12" ng-show="pag_total != 1" style="margin-top:20px;">
                    <center>
                        <span style="cursor:pointer;" ng-hide="pagina == 1" ng-click="anterior(-1)">< </span>pagina {{pagina}} de {{pag_total}}<span style="cursor:pointer;" ng-hide="pagina == pag_total"  ng-click="siguiente(+1)"> ></span>
                    </center>
                </div>
                <div class="col s12" ng-show="pag_total != 1" style="margin-top:20px;">
                    <center>
                        <a ng-click="imprimir()"><label for="">Ver Pdf</label><br>
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
          <script src="/assets/scripts/reporte_alcance.js" charset="utf-8"></script>
          <script src="/assets/scripts/validador_caracter.js" charset="utf-8"></script>
    </body>
  </html>
