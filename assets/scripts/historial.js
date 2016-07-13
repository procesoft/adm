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
                    $scope.fechas.push({fecha:$scope.peticiones[x].fecha_creacion.split(' ')[0]});
                }
                console.log($scope.fechas);
            }
        }).error(function (data, status, headers, config){

        });

        /*$http({
            method: 'GET',
            url: '/calendario/calendario_get',
            params: {
                pagina: $scope.pag_act,
                cantidad: 100,
                campo: '',
                orden: '',
            }
        }).success(function (data, status, headers, config){
            if(data.status){
                $scope.datos = data.data;
                var s = 0;
                angular.forEach($scope.datos, function(obj){
                    obj['mes'] = $filter('date')($scope.datos[s].fecha,"LLLL").trim().toUpperCase();
                    //$scope.meses.push({nombre:$scope.datos[s].fecha.split('de ')[1].trim().toUpperCase()});
                    s+=1;
                });
                eventDates = $scope.datos;

                $scope.datostr();
                $scope.paginas = data.data[0].paginas_total;
            }
        }).error(function (data, status, headers, config){

        });

        $scope.info = function(idx){
            $('#map').empty();
            $scope.modal_info = $scope.datos[idx];
            $('#map').append('<iframe width="100%" height="400px" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?q='+$scope.datos[idx].lat_long.split(",")[0]+','+$scope.datos[idx].lat_long.split(",")[1]+'&key=AIzaSyDGTudSloc1qFPppXGDmSpMVNAnBqj51ow" allowfullscreen></iframe>');
        }
        $scope.datostr = function(){
            var IDs = [];
            $("#calendario").find("div").each(function(){ IDs.push(this.id); });

            var fin = false;

            for(var x=0; x < $scope.datos.length;x++){
                if(fin == true){
                    break;
                }else{
                    for(var y=0; y < IDs.length;y++){
                        if ($scope.datos[x].fecha == IDs[y]) {
                            $('#'+IDs[y]).addClass("bold");
                        }else{
                            if($filter('date')($scope.datos[x],"MM") > $filter('date')(IDs[y].fecha,"MM")){
                                fin = true;
                                break;
                            }
                        }
                    }
                }
            }
        }

        var eventDates = [];
        $('#calendario').datepicker({
            onRenderCell: function (date, cellType) {
                var currentDate = date.getDate();
                var fecha = $filter('date')(date,"yyyy-MM-dd");
                if(cellType == 'day'){
                    return {
                        html: '<div id="'+fecha+'">'+currentDate+'</div>'
                    }
                }
            },
            onChangeView: function(view) {
                if(view == 'days'){
                    $scope.datostr();
                }
            },
            onSelect: function onSelect(fd, date) {
                var fecha = $filter('date')(date,"yyyy-MM-dd");
                var title = '', content = ''
                // If date with event is selected, show it
                for(var x=0; x < $scope.datos.length;x++){
                    if (fecha == $scope.datos[x].fecha) {
                        $scope.info(x);
                        $('#myModal').modal('toggle');
                        $scope.$apply();
                    }else{

                    }
                }
                $scope.datostr();

            },
            onChangeMonth: function(month, year) {
                $scope.datostr();
            }
        });*/
    });
