<!DOCTYPE html>
<html ng-app="historial">
    <head>
        <meta charset="utf-8">
        <!--Import Google Icon Font-->
        <title>Historial</title>
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!--Import materialize.css-->
        <link type="text/css" rel="stylesheet" href="/assets/plugins/materialize/css/materialize.min.css"  media="screen,projection"/>
        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link href="/assets/js/sweetalert.css" rel="stylesheet" type="text/css"/>
        <link rel="icon" type="image/png" href="/assets/img/logo_admin.png" />
        <script src="/assets/js/sweetalert.min.js" type="text/javascript"></script>
    </head>
    <body>
        <div class="col s12"  ng-controller="controlador">
            <nav>
                <div class="nav-wrapper"  style="height:250%; background-color:#232A36;">
                    <div class="container" style="width:80%;">
                        <div class="row">
                            <a href="/" class="brand-logo" style="color:#B1B1B1; margin-top:10px;"><img src="/assets/img/logo_admin.png" style="width:55px; height:50px;"/>&nbsp;ADMINISTRACIÓN DE MÓDULOS</a>
                            <a href="" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
                            <ul id="nav-mobile" class="right hide-on-med-and-down">
                                <li><a href="/" style="border-bottom:solid #00A79D;">Api's</a></li>
                                <li><a href="/responsables">Responsables</a></li>
                                <li><a id="sesion" style="padding-inline-start:100px;" class="dropdown-button" href="" data-activates='dropdown1'>Hola!! </a></li>
                            </ul>
                            <ul class="side-nav" id="mobile-demo">
                                <li><a href="sass.html">Api's</a></li>
                                <li><a href="/responsables" style="border-bottom:solid #00A79D;">Responsables</a></li>
                            </ul>
                        </div>
                        <div class="row">
                            <div class="col s12" style="font-size:30px; height:0px;">
                                <a href="/api"><span style="color:#B1B1B1;">API'S ></span></a><a href="/modulos/{{historial.id_api}}"><span style="color:#B1B1B1;"> MÓDULOS ></span></a><a href="/tablas/{{historial.id_modulo}}"><span style="color:#B1B1B1;"> TABLAS ></span></a><a href="/procedimientos/{{historial.id_tabla}}"><span style="color:#B1B1B1;"> PROCEDIMIENTOS ></span></a><span style="color:#B1B1B1;"> HISTORIAL</span>
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
            <div class="row">
                <div class="col s10 offset-s1">
                    <div class="row">
                        <div class="col s12" style="margin-top:80px;">
                            <a href="/procedimientos/{{historial.id_tabla}}"><h5 style="color:#B1B1B1;">< Regresar</h5></a>
                        </div>
                        <div class="col s12">
                            <span id="titulo" style="color:#00A99D;"><h4>{{historial.nombre}}</h4></span>
                        </div>
                        <div class="col s12">
                            {{historial.descripcion}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="background-color:#F2F2F2;">
                <div class="col s10 offset-s1" style="margin-top:20px; margin-bottom:20px;">
                    <div class="col s3">
                        <div class="col s2"><img src="/assets/img/avatar.png" alt="" width="25px"/></div>
                        <div class="col s10" style="padding-top: 5px"><strong>Responsable web: </strong>{{historial.nick_web}}</div>
                    </div>
                    <div class="col s3">
                        <div class="col s2"><img src="/assets/img/avatar.png" alt="" width="25px"/></div>
                        <div class="col s10" style="padding-top: 5px"><strong>Responsable base: </strong>{{historial.nick_base}}</div>
                    </div>
                    <div class="col s3">
                        <div class="col s2"><img src="/assets/img/avatar.png" alt="" width="25px"/></div>
                        <div class="col s10" style="padding-top: 5px"><strong>Auxiliar web: </strong>{{historial.nick_auxiliar_web}}</div>
                    </div>
                    <div class="col s3">
                        <div class="col s2"><img src="/assets/img/avatar.png" alt="" width="25px"/></div>
                        <div class="col s10" style="padding-top: 5px"><strong>Auxiliar base: </strong>{{historial.nick_auxiliar_base}}</div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s10 offset-s1">
                    <div class="col s6" style="border-right: 1px solid lightgray;">
                        <div class="col s12">
                            <div class="row">
                                <div class="col s6">
                                    <strong class="right">Módulo</strong>
                                </div>
                                <div class="col s6">
                                    {{historial.modulo}}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s6">
                                    <strong class="right">Tablas</strong>
                                </div>
                                <div class="col s6">
                                    {{historial.tabla}}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s6">
                                    <strong class="right">Tipo</strong>
                                </div>
                                <div class="col s6">
                                    {{historial.tipo}}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s6">
                                    <strong class="right">Acción</strong>
                                </div>
                                <div class="col s6">
                                    {{historial.accion}}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s6">
                                    <strong class="right">Fecha de creación</strong>
                                </div>
                                <div class="col s6">
                                    {{historial.fecha_creacion | date: "dd' 'MMMM' 'yyyy"}}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s6">
                                    <strong class="right">Última modificación</strong>
                                </div>
                                <div class="col s6">
                                    {{historial.fecha_modificacion | date: "dd' 'MMMM' 'yyyy"}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col s6">
                        <div class="col s10 offset-s1">
                            <div class="row"><strong>Procedimiento</strong></div>
                            <div class="row">{{historial.nombre}}</div>
                            <div class="row"><strong>Parametros</strong></div>
                            <div class="row">{{historial.parametros}}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="padding-top: 30px">
                <div class="col s10 offset-s1" ng-repeat="fechas in fechas | unique: 'fecha'">
                    <div class="row">
                        <div style="color: white; background-color: #232A36; width: 200px" class="chip center">{{fechas.fecha | date: "dd' 'MMMM' 'yyyy"}}</div>
                    </div>
                    <div class="row" ng-repeat="peticiones in peticiones">
                        <div ng-if="peticiones.tipo == 'C'">
                            <div class="col s11 offset-s1">
                                <div>
                                    <span>{{peticiones.fecha_creacion}}</span>
                                </div>
                                <div>
                                    <strong>{{peticiones.nick}}</strong>
                                </div>
                                <div>
                                    {{peticiones.comentario}}
                                </div>
                            </div>
                        </div>
                        <div ng-if="peticiones.tipo == 'T'" class="col s11 offset-s1">
                            <div class="col s11 offset-s1">
                                <div class="col" style="margin-right: 10px">
                                    <img src="/assets/img/avatar.png" alt="" width="25px"/>
                                </div>
                                <div>
                                    <strong>{{peticiones.nick}}</strong>
                                </div>
                                <div>
                                    {{peticiones.comentario}}
                                </div>
                            </div>
                            <div class="col s12" style="padding-top: 15px">
                                <hr style="border-color:white">
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
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/angular-i18n/1.5.5/angular-locale_es-es.min.js"></script>
        <script src="/assets/plugins/typeahead.bundle.js" charset="utf-8"></script>
        <script src="/assets/plugins/jquery.inputmask.bundle.js" charset="utf-8"></script>
        <script src="/assets/scripts/historial.js" charset="utf-8"></script>
    </body>
</html>
