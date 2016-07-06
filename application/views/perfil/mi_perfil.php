
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
      <script src="assets/js/sweetalert.min.js" type="text/javascript"></script>
    </head>
    <title>Mi perfil</title>

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
                                <li><a href="/responsables">Responsables</a></li>
                                <li><a id="sesion" style="padding-inline-start:100px;" class="dropdown-button" href="#" data-activates='dropdown1'>Hola!! </a></li>
                            </ul>
                            <ul class="side-nav" id="mobile-demo">
                                <li><a href="/api">Api's</a></li>
                                <li><a href="/responsables" style="border-bottom:solid #00A79D;">Responsables</a></li>
                            </ul>
                        </div>
                        <div class="row">
                            <div class="col s4" style="font-size:30px; height:0px;">
                                <span style="color:#B1B1B1;">MI PERFIL</span>
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

        <div class="row" style="margin-top:150px;">
            <div class="container">
                <div class="row">
                    <div class="input-field col s5">
                        <input type="text" placeholder="Usuario" id="nick" name="nick" value="">
                        <label for="nick">Usuario</label>
                    </div>
                    <div class="input-field col s5 offset-s1">
                        <input type="text" placeholder="Nombre" id="nombre" name="nombre" value="">
                        <label for="nombre">Nombre</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s5">
                        <input type="text" placeholder="Apellido Paterno"  id="apellido_pa" name="apellido_pa" value="">
                        <label for="apellido_pa">Apellido Paterno</label>
                    </div>
                    <div class="input-field col s5 offset-s1">
                        <input type="text" placeholder="Apellido Materno" id="apellido_ma" name="apellido_ma" value="">
                        <label for="apellido_ma">Apellido Materno</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s5">
                        <select id="Area" disabled>
                            <option value="" disabled selected>Area</option>
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
                <div class="row">
                    <div class="input-field col s5">
                        <input type="text" placeholder="Correo" id="correo" disabled name="correo" value="">
                        <label for="correo">Correo</label>
                    </div>
                </div>
            <fieldset>
                <legend>Cambio de Contraseña</legend>
                <div class="row">
                    <div class="input-field col s5">
                        <input type="password" id="psw_actual"  name="psw_actual" value="">
                        <label for="psw_actual">Contraseña Actual</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s5">
                        <input type="password" id="psw_nueva"  name="psw_nueva" value="">
                        <label for="psw_nueva">Contraseña Nueva</label>
                    </div>
                    <div class="input-field col s5 offset-s1">
                        <input type="password" id="psw_renueva"  name="psw_renueva" value="">
                        <label for="psw_renueva">Confirma tu nueva contraseña</label>
                    </div>
                </div>
            </fieldset>
            <div class="row" style="margin-top:25px;">
                <center>
                    <button class="btn waves-effect waves-light" type="button" name="action" ng-click="modificar()">Modificar
                        <i class="material-icons right">send</i>
                    </button>
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
          <script src="/assets/scripts/perfil.js" charset="utf-8"></script>
    </body>
  </html>
