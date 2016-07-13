<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <!--Import Google Icon Font-->
        <title>Modulo de procedimientos</title>
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!--Import materialize.css-->
        <link type="text/css" rel="stylesheet" href="/assets/plugins/materialize/css/materialize.min.css"  media="screen,projection"/>
        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link rel="icon" type="image/png" href="/assets/img/logo_admin.png" />
        <link href="/assets/js/sweetalert.css" rel="stylesheet" type="text/css"/>
        <script src="/assets/js/sweetalert.min.js" type="text/javascript"></script>
    </head>
    <body ng-app="appprocedimientos">
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
                                <li><a ng-click="verresponsables()">Responsables</a></li>
								<li><a ng-click="logout()">Salir</a></li>
                            </ul>
                        </div>
                        <div class="row">
                            <div class="col s12" style="font-size:30px; height:0px;">
                                <a href="/api"><span style="color:#B1B1B1;">API'S ></span></a><a href="/modulos/{{listas[0].id_api}}"><span style="color:#B1B1B1;"> MÓDULOS ></span></a><a href="/tablas/{{listas[0].id_modulo}}"><span style="color:#B1B1B1;"> TABLAS ></span></a><a id="activo" style="color:#6F6F6F;" class="dropdown-button" href="" data-activates='api'><span style="color:#B1B1B1;"> PROCEDIMIENTOS&nbsp;</span><span style="color:#00A79D;"><span id="total_apis"></span>&nbsp;<img style="width:10; height:10px;" src="/assets/img/arrows.png" /></span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- Dropdown Structure -->
            <ul id='dropdown1' class='dropdown-content'style="margin-top:45px;">
              <li><a href="">Mis Pendientes</a></li>
              <li><a href="/mi_perfil">Mi perfil</a></li>
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
            </div>
            <div class="row" style="background-color:#F2F2F2;">
                <div class="col s12" style="margin-top:25px; margin-bottom:25px;">
                    <div class="col s1 offset-s2">
                        <img src="/assets/img/avatar.png" alt="" width="50px"/>
                    </div>
                    <div class="col s4" style="margin-top:15px;">
                        <b>Responsable Base de datos: </b><span id="responsableB" style="color:#00A79D;"></span>
                    </div>
                    <div class="col s1">
                        <img src="/assets/img/avatar.png" alt="" width="50px"/>
                    </div>
                    <div class="col s4" style="margin-top:15px;">
                        <b>Auxiliar Base de datos: </b><a style="cursor:pointer;"><span ng-show="auxiliar" id="auxiliar" style="color:#00A79D;"></span></a>
                        <a style="cursor:pointer;"><span ng-show="!auxiliar" style="color:#00A79D;">-</span></a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s11 offset-s1" style="margin-top:30px;">
                    <div style="float:left; margin-top:30px;">
                        <i class="material-icons dp48">search</i>
                    </div>
                    <div class="input-field col s3" style="margin-top:10px;">
                        <input style="height:50px; width:100%;" type="text" placeholder="Buscar.." class="col s12"  ng-init="testAllowed($event);" id="txt_buscador">
                    </div>
                    <div class="input-field col s2 offset-s4" style="margin-top:0%;">
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
                            <label for="">Última modificación</label>
                            <input  id="date" type="text" class="validate">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row"  style="margin-bottom:100px;">
                <div class="col s10 offset-s1">
                    <table class="bordered highlight" style="margin-top:30px;" ng-show="!ocultar">
                        <thead>
                            <tr>
                                <th class="text-center col-md-1">ID</th>
                                <th class="text-center col-md-3">Nombre del procedimiento</th>
                                <th class="text-center col-md-1">Creación</th>
                                <th class="text-center col-md-1">Última modif</th>
                                <th class="text-center col-md-1">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="listas in listas">
                                <td class="text-center">{{listas.id_procedimiento}}</td>
                                <td><a style="cursor: pointer" ng-click="detalle(listas.id_procedimiento)">{{listas.nombre}}</a></td>
                                <td class="text-center">{{listas.fecha_creacion | date}}</td>
                                <td class="text-center">{{listas.fecha_modificacion | date}}</td>
                                <td class="text-center"><i class="material-icons dp48" ng-click="activarModalInsertar(listas.id_procedimiento)" style="cursor:pointer;">mode_edit</i>
                                <i class="material-icons dp48" ng-click="eliminar(listas.id_procedimiento)" style="cursor:pointer;">delete</i>
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
                    </span>
                    </center>
                    <input type="text" id="nombre_procedimiento" placeholder="Nombre procedimiento*">
                    <select id="accion">
                        <option value="" disabled selected>Accion</option>
                        <option value="GET">Listar</option>
                        <option value="POST">Insertar</option>
                        <option value="PUT">Modificar</option>
                        <option value="DEL">Eliminar</option>
                    </select>
                    <select id="tipos">
                        <option value="" disabled selected>Tipo</option>
                        <option value="FN">funcion</option>
                        <option value="SP">procedimientos</option>
                    </select>
                    <textarea id="parametros" class="materialize-textarea" placeholder="Parametros"></textarea>
                    <textarea id="descripcion" class="materialize-textarea" placeholder="Descripción"></textarea>
                </div>
                <div class="modal-footer">
                    <center>
                        <a href="" class="waves-effect btn waves-green btn-flat " ng-click="nuevo()">ACEPTAR</a>
                    </center>
                </div>
            </div>
            <div id="modal2" class="modal" style="width: 70%; max-height: 80%; height: 80%">
                <div class="modal-content" style="padding:0">
                    <center style="padding-top: 30px">
                        <span id="titulo" style="color:#00A99D;"><h4>Detalles del procedimiento</h4></span>
                    </center>
                    <p style="padding: 0px 10%">{{detalle_proc.descripcion}}</p>
                    <div class="row" style="background-color:#F2F2F2;">
                        <div class="col s12" style="margin-top:20px; margin-bottom:20px;">
                            <div class="col s3">
                                <div class="col s2"><img src="/assets/img/avatar.png" alt="" width="25px"/></div>
                                <div class="col s10" style="padding-top: 5px"><strong>Responsable web: </strong>{{detalle_proc.nick_web}}</div>
                            </div>
                            <div class="col s3">
                                <div class="col s2"><img src="/assets/img/avatar.png" alt="" width="25px"/></div>
                                <div class="col s10" style="padding-top: 5px"><strong>Responsable base: </strong>{{detalle_proc.nick_base}}</div>
                            </div>
                            <div class="col s3">
                                <div class="col s2"><img src="/assets/img/avatar.png" alt="" width="25px"/></div>
                                <div class="col s10" style="padding-top: 5px"><strong>Auxiliar web: </strong>{{detalle_proc.nick_auxiliar_web}}</div>
                            </div>
                            <div class="col s3">
                                <div class="col s2"><img src="/assets/img/avatar.png" alt="" width="25px"/></div>
                                <div class="col s10" style="padding-top: 5px"><strong>Auxiliar base: </strong>{{detalle_proc.nick_auxiliar_base}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s6" style="border-right: 1px solid lightgray;">
                            <div class="col s12">
                                <div class="row">
                                    <div class="col s6">
                                        <strong class="right">Módulo</strong>
                                    </div>
                                    <div class="col s6">
                                        {{detalle_proc.modulo}}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col s6">
                                        <strong class="right">Tablas</strong>
                                    </div>
                                    <div class="col s6">
                                        {{detalle_proc.tabla}}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col s6">
                                        <strong class="right">Tipo</strong>
                                    </div>
                                    <div class="col s6">
                                        {{detalle_proc.tipo}}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col s6">
                                        <strong class="right">Acción</strong>
                                    </div>
                                    <div class="col s6">
                                        {{detalle_proc.accion}}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col s6">
                                        <strong class="right">Fecha de creación</strong>
                                    </div>
                                    <div class="col s6">
                                        {{detalle_proc.fecha_creacion | date: "dd' 'MMMM' 'yyyy"}}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col s6">
                                        <strong class="right">Última modificación</strong>
                                    </div>
                                    <div class="col s6">
                                        {{detalle_proc.fecha_modificacion | date: "dd' 'MMMM' 'yyyy"}}
                                    </div>
                                </div>
                                <div class="row">
                                    <center><a href="/historial/{{detalle_proc.id_procedimiento}}">Ver historial</a></center>
                                </div>
                            </div>
                        </div>
                        <div class="col s6">
                            <div class="col s10 offset-s1">
                                <div class="row"><strong>Procedimiento</strong></div>
                                <div class="row">{{detalle_proc.nombre}}</div>
                                <div class="row"><strong>Parametros</strong></div>
                                <div class="row">{{detalle_proc.parametros}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="background-color:#F2F2F2; margin-bottom: 0px">
                        <div class="col s10 offset-s1" style="margin-top:20px;">
                            <div class="row">
                                <strong>Peticiones al responsable</strong>
                                <textarea id="peticion" class="materialize-textarea" placeholder="Descripcion"></textarea>
                            </div>
                            <div class="row">
                                <p><strong>Historial de modificiaciones</strong></p>
                                <div class="col s12">
                                    <div class="col s1">
                                        <input type="checkbox" id="test5" class="filled-in"/>
                                        <label for="test5"></label>
                                    </div>
                                    <div class="col s11">
                                        <div>
                                            <span>18 marzo 2016 - 10:00 am</span>
                                        </div>
                                        <div>
                                            <strong>Carlos</strong>
                                        </div>
                                        <div>
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam vestibulum elit ante, sit amet commodo velit viverra vitae.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <center><button class="waves-effect waves-light btn">ACEPTAR</button></center>
                            </div>
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
        <script src="/assets/scripts/gestor_procedimientos.js" charset="utf-8"></script>
    </body>
</html>
