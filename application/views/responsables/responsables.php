
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
                                <li><a ng-click="verresponsables()" style="border-bottom:solid #00A79D;">Responsables</a></li>
                                <li><a id="sesion" style="padding-inline-start:100px;" class="dropdown-button" href="" data-activates='dropdown1'>Hola!! </a></li>
                            </ul>
                            <ul class="side-nav" id="mobile-demo">
                                <li><a href="/api">Api's</a></li>
                                <li><a ng-click="verresponsables()" style="border-bottom:solid #00A79D;">Responsables</a></li>
                                <li><a ng-click="logout()">Salir</a></li>
                            </ul>
                        </div>
                        <div class="row">
                            <div class="col s4" style="font-size:30px; height:0px;">
                                <span style="color:#B1B1B1;">RESPONSABLES</span>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
                                <!-- Dropdown Structure -->
                                <ul id='dropdown1' class='dropdown-content'style="margin-top:45px;">
                                  <li><a href="">Mis Pendientes</a></li>
                                  <li><a href="/mi_perfil">Mi perfil</a></li>
                                  <li><a href="/reporte_alcance">Reportes</a></li>
                                  <li><a href="" ng-click="logout()">Salir</a></li>
                                </ul>

                                <ul id='api' class='dropdown-content'style="margin-top:45px;" width="100px">
                                  <li><a href="">Todos</a></li>
                                  <li><a href="">En los que trabajo</a></li>
                                </ul>



        <div class="row">
            <div class="col s1 offset-s10" style="margin-top:44px;"  ng-click="activarModalInsertar(0)">
                <a class="btn-floating btn-large waves-effect waves-light"><i class="material-icons">add</i></a>
            </div>
        </div>
        <div class="row">
            <div class="col s11 offset-s1" style="margin-top:30px;">
                <div style="float:left; margin-top:30px;">
                    <i class="material-icons dp48"><img src="/assets/img/buscador-de-lupa.png" alt="" /></i>
                </div>
                <div class="input-field col s3" style="margin-top:10px;">
                    <input style="height:50px; width:100%;" type="text" placeholder="Buscar.." class="col s12"  ng-init="testAllowed($event);" id="txt_buscador">
                </div>

                <div class="input-field col s2 offset-s2" style="margin-top:0%;">
                    <div class="input-field col s12">
                        <select id="ordenar" ng-model="ordena" ng-change="listar_apis()">
                            <option value="" disabled selected>Ordenar</option>
                            <option value="Asc">Ascendente</option>
                            <option value="Desc">Descendente</option>
                        </select>
                    </div>
                </div>
                <div class="input-field col s2" style="margin-left:-1%; margin-top:0%;">
                    <div class="input-field col s12">
                        <select id="activos2" ng-model="activos" ng-change="listar_apis()">
                            <option value="" disabled selected>Activos</option>
                            <option value="">Todos</option>
                            <option value="S">Habilitado</option>
                            <option value="N">Deshabilitado</option>
                        </select>
                    </div>
                </div>
                <div class="input-field col s2" style="margin-left:-1%; margin-top:0%;">
                    <div class="input-field col s12">
                        <select id="Area" ng-model="area" ng-change="listar_apis()">
                            <option value="" disabled selected>Área</option>
                            <option value="">Todos</option>
                            <option value="4">Desarrollador</option>
                            <option value="5">Base de datos</option>
                            <option value="2">Admin Desarrollo</option>
                            <option value="3">Admin Base de datos</option>
                            <option value="1">Super Usuario</option>
                            <option value="6">QA</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
            <div class="row" style="margin-bottom:100px;">
                <div class="col s10 offset-s1">
                    <table class="bordered highlight" style="margin-top:30px;" ng-show="!ocultar">
                        <tr>
                            <th class="text-center col-md-1">ID</th>
                            <th class="text-center col-md-3">Nombre del reponsable</th>
                            <th class="text-center col-md-2">Apis asignadas</th>
                            <th class="text-center col-md-2">Módulos asignados</th>
                            <th class="text-center col-md-1">Área</th>
                            <th class="text-center col-md-1">Estatus</th>
                            <th class="text-center col-md-1">Acciones</th>
                        </tr>
                    <tbody>
                        <tr ng-repeat="listas in listas">
                            <td class="text-center">{{listas.id_responsable}}</td>
                            <td><a style="cursor: pointer" href="/detalle_responsable/{{listas.id_responsable}}">{{listas.nombre_completo}}</a></td>
                            <td class="text-center">{{listas.apis}}</td>
                            <td class="text-center">{{listas.modulos}}</td>
                            <td class="text-center">{{listas.rol}}</td>
                            <td class="text-center">{{listas.activo}}</td>
                            <td class="text-center"><i class="material-icons dp48" ng-show="listas.activo=='Deshabilitado'" ng-click="activarModalInsertar(listas.id_responsable)" style="cursor:pointer;"><img src="/assets/img/bloquear.png" alt="" /></i>
                                <i class="material-icons dp48" ng-show="listas.activo=='Habilitado'" ng-click="eliminar(listas.id_responsable)" style="cursor:pointer;"><img src="/assets/img/bloquear-1.png" alt="" /></i></td>
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
        </div>

            <div id="modal1" class="modal modal-fixed-footer" >
                <div class="modal-content">
                    <center>
                    <span id="titulo" style="color:#00A99D;">
                        <h4></h4>
                    </span>
                    </center>
                    <div class="row">
                        <div class="input-field col s4">
                            <input type="text" id="Usuario" maxlength="15" placeholder="Usuario*">
                            <label for="Usuario">Usuario*</label>
                        </div>
                        <div class="input-field col s8">
                            <input type="text" id="nombre_res" placeholder="Nombre Usuario*" maxlength="45" onkeypress="return soloLetras(event)">
                            <label for="nombre_res">Nombre usuario*</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s6">
                            <input type="text" id="ape_pa" placeholder="Apellido Paterno*" maxlength="45" onkeypress="return soloLetras(event)">
                            <label for="ape_pa">Apellido paterno*</label>
                        </div>
                        <div class="input-field col s6">
                            <input type="text" id="ape_ma" placeholder="Apellido Materno" maxlength="45" onkeypress="return soloLetras(event)">
                            <label for="ape_ma">Apellido materno</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s6">
                            <select id="Area_mod">
                                <option hidden="true"></option>
                                <option value="0" disabled selected>Rol</option>
                                <option value="4">Desarrollador</option>
                                <option value="5">Base de datos</option>
                                <option value="2">Admin Desarrollo</option>
                                <option value="3">Admin Base de datos</option>
                                <option value="1">Super Usuario</option>
                                <option value="6">QA</option>
                            </select>
                            <label for="Area_mod">Rol</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s6">
                            <input id="email" type="email" class="validate" maxlength="40" placeholder="@correo*">
                            <label for="email" id="msn" data-error="invalido" data-success="correcto">Email*</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <center>
                        <a href="" class="waves-effect btn waves-green btn-flat" ng-click="nuevo()">ACEPTAR</a>
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
          <script src="/assets/scripts/responsables.js" charset="utf-8"></script>
          <script src="/assets/scripts/validador_caracter.js" charset="utf-8"></script>
    </body>
  </html>
