
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
    <title>Modulo de Api´s</title>

    <body ng-app="appApis">
        <div class="col s12"  ng-controller="controlador" style="margin.bottom:200px;">
            <nav>
                <div class="nav-wrapper"  style="height:250%; background-color:#232A36;">
                    <div class="container" style="width:80%;">
                        <div class="row">
                            <a href="/" class="brand-logo" style="color:#B1B1B1; margin-top:10px;"><img src="/assets/img/logo_admin.png" style="width:55px; height:50px;"/>&nbsp;ADMINISTRACIÓN DE MÓDULOS</a>
                            <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
                            <ul id="nav-mobile" class="right hide-on-med-and-down">
                                <li><a href="/api" style="border-bottom:solid #00A79D;">Api's</a></li>
                                <li><a ng-click="verresponsables()">Responsables</a></li>
                                <li><a id="sesion" style="padding-inline-start:100px;" class="dropdown-button" href="#" data-activates='dropdown1'>Hola!! </a></li>
                            </ul>
                            <ul class="side-nav" id="mobile-demo">
                                <li><a href="/api" style="border-bottom:solid #00A79D;">Api's</a></li>
                                <li><a ng-click="verresponsables()">Responsables</a></li>
                                <li><a ng-click="logout()">Salir</a></li>
                            </ul>
                        </div>
                        <div class="row">
                            <div class="col s4" style="font-size:30px; height:0px;">
                                <a id="activo" style="color:#6F6F6F;" class="dropdown-button" href="#" data-activates='api'><span style="color:#B1B1B1;">API'S&nbsp;</span><span style="color:#00A79D;"><span id="total_apis"></span>&nbsp;<img style="width:10; height:10px;" src="/assets/img/arrows.png" /></span></a>
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



        <div class="row">
            <div class="col s1 offset-s10" style="margin-top:44px;"  ng-click="activarModalInsertar(0)">
                <a class="btn-floating btn-large waves-effect waves-light"><i class="material-icons">add</i></a>
            </div>
        </div>
            <div class="row">
                <div class="col s11 offset-s1">
                    <div style="float:left; margin-top:30px;">
                        <i class="material-icons dp48">search</i>
                    </div>
                    <div class="input-field col s2" style="margin-top:10px;">
                        <input style="height:50px;" type="text" placeholder="Buscar.." ng-model="buscador" class="form-control"  ng-init="testAllowed($event);" id="txt_buscador">
                        <!--input type="text" placeholder="Buscar" onkeypress="testAllowed(event)" id="txt_buscador" length="30"-->
                    </div>
                    <div class="input-field col s2" style="margin-top:0%;">
                        <div class="input-field col s12">
                            <select id="ordenar" ng-model="ordena" ng-change="listar_apis()">
                                <option value="" disabled selected>Ordenar</option>
                                <option value="Asc">Ascendente</option>
                                <option value="Desc">Descendente</option>
                            </select>
                        </div>
                    </div>
                    <div class="input-field col s2" style="margin-top:0%;">
                        <div class="input-field col s12">
                            <select id="servidores" ng-model="filtro" ng-change="filtros()">
                                <option value="" disabled selected>Servidor</option>
                            </select>
                        </div>
                    </div>
                    <div class="input-field col s2" style="margin-top:0%;" >
                        <div class="input-field col s12">
                            <select id="BD" ng-model="bd_filtro" ng-change="listar_apis()">
                                <option value="" disabled selected>Base de datos</option>
                            </select>
                        </div>
                    </div>
                    <div class="input-field col s1" style="margin-top:0%;">
                        <div class="input-field col s12">
                            <select id="activo2" ng-model="activo" ng-change="listar_apis()">
                                <option value="" disabled selected>Activo</option>
                                <option value="D">Definición</option>
                                <option value="P">Progreso</option>
                                <option value="R">Revisión</option>
                                <option value="T">Terminado</option>
                            </select>
                        </div>
                    </div>
                    <div class="input-field col s2" style="margin-left:-1%; margin-top:0%;">
                        <div class="input-field col s12">
                            <label for="">Última modificación</label>
                            <input  id="date" type="text" class="validate">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="margin-bottom:100px;">
                <div class="col s10 offset-s1">
                    <table class="bordered highlight" style="margin-top:30px;" ng-show="!ocultar">
                        <tr>
                            <th class="text-center col-md-1">ID</th>
                            <th class="text-center col-md-3">Nombre de Proyecto</th>
                            <th class="text-center col-md-2">Módulos</th>
                            <th class="text-center col-md-1">Entrega</th>
                            <th class="text-center col-md-1">Última modif</th>
                            <th class="text-center col-md-1">Prefijo</th>
                            <th class="text-center col-md-1">Estatus</th>
                            <th class="text-center col-md-1">Situación</th>
                            <th class="text-center col-md-1">Servidor</th>
                            <th class="text-center col-md-1">Base de Datos</th>
                            <th class="text-center col-md-1">Acciones</th>
                        </tr>
                    <tbody>
                        <tr ng-repeat="listas in listas">
                            <td class="text-center">{{listas.id_api}}</td>
                            <td><a style="cursor: pointer" href="/modulos/{{listas.id_api}}">{{listas.nombre}}</a></td>
                            <td class="text-center">{{listas.modulos}}</td>
                            <td class="text-center">{{listas.fecha | date}}</td>
                            <td class="text-center">{{listas.fecha_modificacion | date}}</td>
                            <td class="text-center">{{listas.prefijo}}</td>
                            <td class="text-center">{{listas.status}}</td>
                            <td class="text-center">
                            <div class="progress" ng-if="listas.tiempo=='C'">
                                <div class="determinate" style="width: 100%; background-color:#FF0000;"></div>
                            </div>
                            <div class="progress" ng-if="listas.tiempo=='T'">
                                <div class="determinate" style="width: 100%;"></div>
                            </div>
                            <div class="progress" ng-if="listas.tiempo=='F'">
                                <div class="determinate" style="width: 100%; background-color:#FFBF00;"></div>
                            </div>
                            </td>
                            <td class="text-center">{{listas.servidor}}</td>
                            <td class="text-center">{{listas.base_de_datos}}</td>
                            <td class="text-center"><i class="material-icons dp48" ng-click="activarModalInsertar(listas.id_api)" style="cursor:pointer;">mode_edit</i>
                            <i class="material-icons dp48" ng-click="eliminar(listas.id_api)" style="cursor:pointer;">delete</i>
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
            <div class="col s12" ng-show="pag_total != 1" style="margin-top:20px;">
                <center>
                    <span style="cursor:pointer;" ng-hide="pagina == 1" ng-click="anterior(-1)">< </span>pagina {{pagina}} de {{pag_total}}<span style="cursor:pointer;" ng-hide="pagina == pag_total"  ng-click="siguiente(+1)"> ></span>
                </center>
            </div>
        </div>

            <div id="modal1" class="modal modal-fixed-footer">
                <div class="modal-content">
                    <center>
                    <span id="titulo" style="color:#00A99D;">
                        <h4>Crear nuevo módulo</h4>
                    </span>
                    </center>
                    <div class="row">
                        <div class="input-field col s12">
                            <input type="text" id="nombre_api" placeholder="Nombre api*" onkeypress="return soloLetras(event)" maxlength="40">
                            <label for="nombre_api">Nombre Api*</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s5">
                            <input type="text" id="prefijo" placeholder="Prefijo*" maxlength="4">
                            <label for="prefijo">Prefijo*</label>
                        </div>

                        <div class="input-field col s5 offset-s1">
                            <input type="text" id="fecha" placeholder="Fecha entrega*">
                            <label for="fecha">Fecha de entrega*</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s5">
                            <select id="servidormod" ng-model="filtro_mod" ng-change="filtro_Mod()">
                                <option hidden="true"></option>
                                <option value="0" disabled selected>Servidor</option>
                            </select>
                            <label for="servidormod">Servidor*</label>
                        </div>

                        <div class="input-field col s5 offset-s1">
                            <select id="basemod">
                            </select>
                            <label for="basemod">Base de datos*</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <textarea id="descripcion" class="materialize-textarea" placeholder="Descripción" maxlength="250"></textarea>
                            <label for="descripcion">Descripción*</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <center>
                        <a href="#!" class="waves-effect btn waves-green btn-flat " ng-click="nuevo()">ACEPTAR</a>
                    </center>
                </div>
            </div>

        </div>
        <!--div class="row">
            <footer style="background-color:#232A36; width: 100%; height: 100px; background: #232A36; position: absolute; bottom: 0;">
                    <div class="col s12" style="margin-top:25px; margin-bottom:25px; color:#fff;">
                        <center>
                            ADMINISTRACION DE MÓDULOS | DAS 2016
                        </center>
                    </div>
            </footer>
        </div-->



      <!--Import jQuery before materialize.js-->
          <script src="/assets/plugins/jquery-2.2.4.js" charset="utf-8"></script>
          <script src="/assets/plugins/angular.js" charset="utf-8"></script>
          <script src="/assets/plugins/materialize/angular-materialize.js"></script>
          <script type="text/javascript" src="/assets/plugins/materialize/js/materialize.js"></script>
          <script src="/assets/plugins/typeahead.bundle.js" charset="utf-8"></script>
          <script src="/assets/plugins/jquery.inputmask.bundle.js" charset="utf-8"></script>
          <script src="/assets/scripts/gestor.js" charset="utf-8"></script>
          <script src="/assets/scripts/validador_caracter.js" charset="utf-8"></script>
    </body>
  </html>
