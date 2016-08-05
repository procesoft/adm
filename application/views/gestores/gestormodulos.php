
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
      <link href="/assets/js/sweetalert.css" rel="stylesheet" type="text/css"/>
      <link rel="icon" type="image/png" href="/assets/img/logo_admin.png" />
      <script src="/assets/js/sweetalert.min.js" type="text/javascript"></script>
    </head>
    <title>Modulo de Módulos</title>

    <body ng-app="appmodulos">
        <div class="col s12"  ng-controller="controlador">
            <nav>
                <div class="nav-wrapper"  style="height:250%; background-color:#232A36;">
                    <div class="container" style="width:80%;">
                        <div class="row">
                            <a href="/" class="brand-logo" style="color:#B1B1B1; margin-top:10px;"><img src="/assets/img/logo_admin.png" style="width:55px; height:50px;"/>&nbsp;ADMINISTRACIÓN DE MÓDULOS</a>
                            <a href="" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
                            <ul id="nav-mobile" class="right hide-on-med-and-down">
                                <li><a href="/api" style="border-bottom:solid #00A79D;">Api's</a></li>
                                <li><a ng-click="verresponsables()">Responsables</a></li>
                                <li><a id="sesion" style="padding-inline-start:100px;" class="dropdown-button" href="" data-activates='dropdown1'>Hola!! </a></li>
                            </ul>
                            <ul class="side-nav" id="mobile-demo">
                                <li><a href="/api" style="border-bottom:solid #00A79D;">Api's</a></li>
                                <li><a ng-click="verresponsables()" style="border-bottom:solid #00A79D;">Responsables</a></li>
                                <li><a ng-click="logout()">Salir</a></li>
                            </ul>
                        </div>
                        <div class="row">
                            <div class="col s4" style="font-size:30px; height:0px;">
                                <a href="/api"><span style="color:#B1B1B1;">API'S > </span></a><a id="activo" style="color:#6F6F6F;" class="dropdown-button" href="" data-activates='api'><span style="color:#B1B1B1;"> MÓDULOS&nbsp;</span><span style="color:#00A79D;"><span id="total_apis"></span>&nbsp;<img style="width:10; height:10px;" src="/assets/img/arrows.png" /></span></a>
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
                <div class="col s11 offset-s1">
                    <div class="col s12" style="color:#00A79D;"><h4 id="nombre_encabezado"></h4></div>
                    <div class="col s12" id="descripcion_encabezado"></div>
                </div>
                <div class="col s11 offset-s1" style="margin-top:70px;">
                    <div style="float:left; margin-top:30px;">
                        <i class="material-icons dp48"><img src="/assets/img/buscador-de-lupa.png" alt="" /></i>
                    </div>
                    <div class="input-field col s2" style="margin-top:10px;">
                        <input style="height:50px; width:100%;" type="text" placeholder="Buscar.." class="col s2"  ng-init="testAllowed($event);" id="txt_buscador">
                    </div>
                    <div class="input-field col s2" style="margin-top:0%;">
                        <div class="input-field col s12">
                            <select id="responsables" ng-model="responsables" ng-change="listar_apis()">
                                <option value="" disabled selected>Responsables</option>
                            </select>
                        </div>
                    </div>
                    <div class="input-field col s2" style="margin-top:0%;">
                        <div class="input-field col s12">
                            <select id="responsablesBD" ng-model="responsablesBD" ng-change="listar_apis()">
                                <option value="" disabled selected>Responsables</option>
                            </select>
                        </div>
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
                    <div class="input-field col s1" style="margin-top:0%;">
                        <div class="input-field col s12">
                            <select id="activo2" ng-model="activo" ng-change="listar_apis()">
                                <option value="" selected>Activo</option>
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
                            <th class="text-center col-md-3">Nombre del Módulo</th>
                            <th class="text-center col-md-2">Tablas</th>
                            <th class="text-center col-md-1">Responsable Desarrollo</th>
                            <th class="text-center col-md-1">Responsable BD</th>
                            <th class="text-center col-md-1">Creación</th>
                            <th class="text-center col-md-1">Última modif</th>
                            <th class="text-center col-md-1">Estatus</th>
                            <th class="text-center col-md-1">Acciones</th>
                        </tr>
                    <tbody>
                        <tr ng-repeat="listas in listas">
                            <td class="text-center">{{listas.id_modulo}}</td>
                            <td ng-if="rol!=6"><a style="cursor: pointer" href="/tablas/{{listas.id_modulo}}" >{{listas.nombre}}</a></td>
                            <td ng-if="rol==6"><a style="cursor: pointer" >{{listas.nombre}}</a></td>
                            <td class="text-center">{{listas.tablas}}</td>
                            <td class="text-center">{{listas.responsable_web}}</td>
                            <td class="text-center">{{listas.responsable_base}}</td>
                            <td class="text-center">{{listas.fecha_creacion | date}}</td>
                            <td class="text-center">{{listas.fecha_modificacion | date}}</td>
                            <td class="text-center">{{listas.status}}</td>
                            <td class="text-center"><i class="material-icons dp48" ng-if="rol!=6" ng-click="activarModalInsertar(listas.id_modulo)" style="cursor:pointer;"><img src="/assets/img/editar.png" alt="" /></i>
                            <i class="material-icons dp48" ng-if="rol!=6" ng-click="eliminar(listas.id_modulo)" style="cursor:pointer;"><img src="/assets/img/interfaz.png" alt="" /></i>
                            <i class="material-icons dp48" ng-if="rol!=6 && listas.status != 'Revision'" ng-click="revision(listas.nombre,listas.id_modulo)" style="cursor:pointer;"><img src="/assets/img/success.png" alt="" /></i>
                            <i class="material-icons dp48" ng-if="rol==6 && listas.status == 'Revision'" ng-click="terminado(listas.nombre,listas.id_modulo)" style="cursor:pointer;"><img src="/assets/img/success.png" alt="" /></i>
                            <i class="material-icons dp48" ng-if="rol==6 && listas.status == 'Revision'" ng-click="progreso(listas.nombre,listas.id_modulo)" style="cursor:pointer;"><img src="/assets/img/error.png" alt="" /></i>
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
                            <input type="text" id="nombre_modulo" placeholder="Nombre módulo*"  maxlength="40" onkeypress="return soloLetras(event)">
                            <label for="nombre_modulo">Nombre Módulo*</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <select id="responsables_mod">
                                <option value="" disabled selected>Responsables</option>
                            </select>
                            <label for="responsables_mod">Responsable desarrollo*</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <select id="responsablesBD_mod">
                                <option value="" disabled selected>Responsables</option>
                            </select>
                            <label for="responsablesBD_mod">Responsable Base de datos*</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input type="checkbox" id="test6" ng-model="test6" checked="checked" ng-click="llenar_auxiliares()" />
                            <label for="test6">agregar auxiliar</label>
                        </div>
                    </div>
                    <div class="row" ng-show="test6">
                        <div class="input-field col s5">
                            <select id="auxiliar">
                                <option value="" disabled selected>Auxiliar desarrollo</option>
                            </select>
                            <label for="auxiliar">Auxiliar desarrollo</label>
                        </div>

                        <div class="input-field col s5 offset-s1">
                            <select id="auxiliar_bd">
                                <option value="" disabled selected>Auxiliar BD</option>
                            </select>
                            <label for="auxiliar_bd">Auxiliar Base de datos</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <textarea id="descripcion" class="materialize-textarea" maxlength="250" placeholder="Descripción"></textarea>
                            <label for="descripcion">Descripción*</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <center>
                        <a href="" class="waves-effect btn waves-green btn-flat " ng-click="nuevo()">ACEPTAR</a>
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
          <script src="/assets/scripts/gestor_modulos.js" charset="utf-8"></script>
          <script src="/assets/scripts/validador_caracter.js" charset="utf-8"></script>
    </body>
  </html>
