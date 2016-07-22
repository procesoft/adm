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
    .controller('controlador', function($scope,$http,$filter) {
        url=window.location.href.split('/');
        $scope.id = url[4];
        $scope.historial = [];
        $scope.peticiones = [];
        $scope.fechas = [];
        $scope.rol=usuario[0].id_rol;
        /*$scope.datos = [];
        $scope.actividad = {};
        $scope.act = 0;
        $scope.meses = [{nombre:'MAYO'},{nombre:'JUNIO'},{nombre:'JULIO'},{nombre:'AGOSTO'}];
        $scope.modal_info = {};
        $scope.paginas = 0;
        $scope.pag_act = 1;*/

        $http({
            method: 'GET',
            url: '/gestorprocedimientos/detalle',
            params: {
                v_id_procedimiento: $scope.id,
            }
        }).success(function (data, status, headers, config){
            if(data.status){
                $scope.historial = data.data[0];
            }
        }).error(function (data, status, headers, config){

        });

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
                $scope.peticiones = data.data;
                for(var x = 0; x < $scope.peticiones.length; x++){
                    $scope.peticiones[x].hora_creacion = $scope.peticiones[x].fecha_creacion.split(' ')[1];
                    $scope.peticiones[x].fecha_creacion = $scope.peticiones[x].fecha_creacion.split(' ')[0];
                    $scope.fechas.push({fecha:$scope.peticiones[x].fecha_creacion.split(' ')[0]});
                }
            }
        }).error(function (data, status, headers, config){

        });
    });
