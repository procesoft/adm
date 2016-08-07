
  <!DOCTYPE html>
  <html>
    <head>
      <meta charset="utf-8">
      <!--Import Google Icon Font-->
      <title>Asignado a</title>
      <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <!--Import materialize.css-->
      <link type="text/css" rel="stylesheet" href="/assets/plugins/materialize/css/materialize.min.css"  media="screen,projection"/>
      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
      <link rel="icon" type="image/png" href="/assets/img/logo_admin.png" />
      <link href="/assets/css/sweetalert2.min.css" rel="stylesheet" type="text/css"/>
      <script src="/assets/js/sweetalert2.min.js" type="text/javascript"></script>
    </head>

    <body ng-app="asignado_a">
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
                            <ul id="nav-mobile" class="left hide-on-med-and-down" style="margin-top: 9px">
                                <li><a href="/mi_historial" style="color:#B1B1B1; cursor:pointer; font-size:25px">MI HISTORIAL</a></li>
                                <li><a href="/asignado_a" style="color:#B1B1B1; cursor:pointer; border-bottom:solid #00A79D; font-size:25px">ASIGNADO A</a></li>
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

            <div class="row" style="margin-top:30px;">
                <div class="col s10 offset-s1">
                    <div class="col s12" style="color:#00A79D;"><h5 style="font-weight: bold">Modulos asignados</h5></div>
                    <div class="row"  style="margin-bottom:100px;">
                        <div class="col s10 offset-s1">
                            <table class="bordered highlight" style="margin-top:30px;" ng-show="!ocultar">
                                <thead>
                                    <tr>
                                        <th class="text-center col-md-1">ID</th>
                                        <th class="text-center col-md-3">Nombre del módulo</th>
                                        <th class="text-center col-md-1">Nombre del API</th>
                                        <th class="text-center col-md-1">Estatus</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="listas in listas">
                                        <td class="text-center">{{listas.id_modulo}}</td>
                                        <td class="text-center">{{listas.Modulo}}</td>
                                        <td class="text-center">{{listas.Api}}</td>
                                        <td class="text-center">{{listas.status}}</td>
                                    </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="col s12" ng-show="ocultar">
                                <center>
                                <span><h4>No hay datos<h4></span>
                                </center>
                            </div>
                        </div>
                        <div class="col s12" ng-show="pag_total > 1 && pagina < pag_total" style="margin-top:20px;">
                            <center>
                                <center><i class="medium material-icons" style="color: gray; cursor: pointer" ng-if="pag_total > 1 && pagina < pag_total" ng-click="mas()">more_horiz</i></center>
                            </center>
                        </div>
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
          <script src="/assets/scripts/asignado_a.js" charset="utf-8"></script>
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
