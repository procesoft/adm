var usuario=JSON.parse(localStorage.getItem('log'));
$('#sesion').empty();
$('#sesion').append('Hola '+usuario[0].nick+' <img style="width:10; height:10px;" src="/assets/img/arrows.png" />');
$('select').material_select();
$(".button-collapse").sideNav();
$('#tabla').empty();
$('#date').inputmask('9999-99-99');
function cambio_color(id){
    $('#fila_'+id).prop('style','color:#00A79D;')
}
function cambio_color1(id){
    $('#fila_'+id).prop('style','color:#333;')
}
angular.module('historial', [])
    .config(['$httpProvider', function($httpProvider) {
        //initialize get if not there
        if (!$httpProvider.defaults.headers.get) {
            $httpProvider.defaults.headers.get = {};
        }

        // Answer edited to include suggestions from comments
        // because previous version of code introduced browser-related errors

        //disable IE ajax request caching
        $httpProvider.defaults.headers.get['If-Modified-Since'] = 'Mon, 26 Jul 1997 05:00:00 GMT';
        // extra
        $httpProvider.defaults.headers.get['Cache-Control'] = 'no-cache';
        $httpProvider.defaults.headers.get['Pragma'] = 'no-cache';
    }])
    .filter('unique', function() {
       return function(collection, keyname) {
          var output = [],
              keys = [];

          angular.forEach(collection, function(item) {
              var key = item[keyname];
              if(keys.indexOf(key) === -1) {
                  keys.push(key);
                  output.push(item);
              }
          });

          return output;
       };
    })
    .directive('myEnter', function () {
        return function (scope, element, attrs) {
            element.bind("keydown keypress", function (event) {
                if(event.which === 13) {
                    scope.$apply(function (){
                        scope.$eval(attrs.myEnter);
                    });

                    event.preventDefault();
                }
            });
        }
    })
    .controller('controlador', function($scope,$http,$filter) {
        url=window.location.href.split('/');
        $scope.id = url[4];
        $scope.historial = [];
        $scope.peticiones = [];
        $scope.fechas = [];
        $scope.rol=usuario[0].id_rol;
        $scope.pag = 1;
        $scope.pag_total = '';
        $scope.nod = true;
        $scope.respuesta = [];
        $scope.resp = false;
        $scope.asig = false;
        $scope.peticion_proc = "";


        $scope.comentar = function(){
            $http({
                method: 'POST',
                url: '/historial/post_peticion',
                params: {
                    log_proc: 0,
                    login: usuario[0].id_responsable,
                    api: $scope.historial.id_api,
                    modulo: $scope.historial.id_modulo,
                    tabla: $scope.historial.id_tabla,
                    proc: $scope.historial.id_procedimiento,
                    comentario: $scope.peticion_proc,
                    tipo: 'C'
                }
            }).success(function (data, status, headers, config){
                if(data.status){
                    swal('Listo','','success');
                    $scope.llamarpeticiones($scope.historial.id_procedimiento);
                }
            }).error(function (data, status, headers, config){

            });
        }
        $scope.responder = function(v){
            $http({
                method: 'POST',
                url: '/historial/post_peticion',
                params: {
                    log_proc: v,
                    login: usuario[0].id_responsable,
                    api: $scope.historial.id_api,
                    modulo: $scope.historial.id_modulo,
                    tabla: $scope.historial.id_tabla,
                    proc: $scope.historial.id_procedimiento,
                    comentario: $scope.respuesta[v],
                    tipo: 'T'
                }
            }).success(function (data, status, headers, config){
                if(data.status){
                    swal('Listo','','success');
                    $scope.llamarpeticiones($scope.historial.id_procedimiento);
                }
            }).error(function (data, status, headers, config){

            });
        }

        $http({
            method: 'GET',
            url: '/gestorprocedimientos/detalle',
            params: {
                v_id_procedimiento: $scope.id,
            }
        }).success(function (data, status, headers, config){
            if(data.status){
                $scope.historial = data.data[0];
                if(usuario[0].id_responsable == $scope.historial.id_responsable_base || usuario[0].id_responsable == $scope.historial.id_auxiliar_base){
                    $scope.resp = true;
                }else{
                    $scope.resp = false;
                }
                if(usuario[0].id_responsable == $scope.historial.id_responsable_base || usuario[0].id_responsable == $scope.historial.id_auxiliar_base || usuario[0].id_responsable == $scope.historial.id_responsable_web || usuario[0].id_responsable == $scope.historial.id_auxiliar_web){
                    $scope.asig = true;
                }else{
                    $scope.asig = false;
                }
                $scope.llamarpeticiones();
            }
        }).error(function (data, status, headers, config){

        });

        $scope.llamarpeticiones = function(){
            $scope.pag = 1;
            $http({
                method: 'GET',
                url: '/historial/peticiones',
                params: {
                    id: $scope.id,
                    pagina: 1,
                    cantidad: 10,
                }
            }).success(function (data, status, headers, config){
                if(data.status){
                    $scope.nod = false;
                    $scope.peticiones = data.data;
                    for(var x = 0; x < $scope.peticiones.length; x++){
                        $scope.peticiones[x].hora_creacion = $scope.peticiones[x].fecha_creacion.split(' ')[1];
                        $scope.peticiones[x].fecha_creacion = $scope.peticiones[x].fecha_creacion.split(' ')[0];
                        if($scope.peticiones[x].tipo == 'C'){
                            $scope.fechas.push({fecha:$scope.peticiones[x].fecha_creacion.split(' ')[0]});
                        }
                    }
                    $scope.pag_total = $scope.peticiones[0].paginas_total;
                }else{
                    $scope.nod = true;
                }
            }).error(function (data, status, headers, config){

            });
        }
        $scope.mas = function(){
            if($scope.pag <= $scope.pag_total){
                $scope.pag += 1;
                bloquear();
                $http({
                    method: 'GET',
                    url: '/historial/peticiones',
                    params: {
                        id: $scope.id,
                        pagina: $scope.pag,
                        cantidad: 10,
                    }
                }).success(function (data, status, headers, config){
                    if(data.status){
                        for(var x = 0; x< data.data.length; x++){
                            $scope.temp = data.data[x];
                            $scope.temp.hora_creacion = $scope.temp.fecha_creacion.split(' ')[1];
                            $scope.temp.fecha_creacion = $scope.temp.fecha_creacion.split(' ')[0];
                            if($scope.temp.tipo == 'C'){
                                $scope.fechas.push({fecha:$scope.temp.fecha_creacion.split(' ')[0]});
                            }
                            $scope.peticiones.push($scope.temp);
                        }
                        $scope.nod = false;
                        desbloquear();
                    }else{
                        $scope.nod = true;
                        desbloquear();
                    }
                }).error(function (data, status, headers, config){

                });
            }
        }

        $scope.fin_tarea = function(v){
            if($('#cb_'+v).prop('checked') == true){
                swal({
                    title: '¿Finalizar tarea?',
                    text: "",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Si, Estoy de acuerdo',
                    cancelButtonText: 'Cancelar'
                }).then(function(isConfirm) {
                    if (isConfirm) {
                        $http({
                            method: 'POST',
                            url: '/historial/fin_tarea',
                            params: {
                                login: usuario[0].id_responsable,
                                log_proc: v
                            }
                        }).success(function (data, status, headers, config){
                            if(data.status){
                                swal('Listo','','success');
                                $scope.llamarpeticiones();
                            }
                        }).error(function (data, status, headers, config){

                        });
                    }else{
                        $('#cb_'+v).prop('checked', false);
                    }
                })
            }
        }

        $scope.eliminar_peticion = function(v){
            swal({
                title: '¿Eliminar peticion?',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Si, Estoy de acuerdo',
                cancelButtonText: 'Cancelar'
            }).then(function(isConfirm) {
                if (isConfirm) {
                    bloquear();
                    $http({
                        method: 'POST',
                        url: '/historial/eliminar_peticion',
                        params: {
                            login: usuario[0].id_responsable,
                            log_proc: v
                        }
                    }).success(function (data, status, headers, config){
                        if(data.status){
                            swal('Listo','','success');
                            $scope.llamarpeticiones();
                        }
                    }).error(function (data, status, headers, config){
                        swal("Alerta",data.data,"warning");
                    });
                }else{
                    $('#cb_'+v).prop('checked', false);
                }
            })
        }

        $scope.logout=function(){
            $.ajax({
                url:"/login_controller/logout",
                dataType:"json",
                type:"GET",
                success: function(data){
                    if (data.status) {
                        localStorage.removeItem('log');
                        window.location="/login";
                    }else{
                        console.log(data.status);
                    }
                }
            });
        }

        $scope.verresponsables=function(){
            if(usuario[0].id_rol == 1 || usuario[0].id_rol == 2 || usuario[0].id_rol == 3){
                window.location="/responsables";
            }else{

            }
        }
    });
