
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



angular.module('appdetalle_res', [])
.controller('controlador', function($scope,$http) {
    $scope.url=window.location.href.split('/');
    $scope.id = $scope.url[4].split('#')[0];
    $scope.listas = [];
    $scope.listas2 = [];
    $scope.ocultar=false;
    $scope.filtro_mod="";
    $scope.filtro="";
    $scope.tipo="";
    $scope.editar="";
    $scope.pagina=1;
    $scope.ordenar="";
    $scope.activo="";


$scope.listar_detalle=function(){
    $http({
        method: 'GET',
        url: '/peticiones_res/detalle',
        params: {
            v_id_responsables:$scope.id ,
        }
    }).success(function (data, status, headers, config){
        if(data.status){
            $('#responsable').append('<h5>'+data.data[0].nombre+' '+data.data[0].apellido_paterno+'</h5>');
            if(data.data[0].activo=='S'){
                data.data[0].activo='Habilitado';
            }else{
                data.data[0].activo='Deshabilitado';
            }
            $('#status').append(data.data[0].activo);
            $('#modulos').append(data.data[0].nombre);
            $('#rol').append(data.data[0].rol);
            $('#mail').append(data.data[0].usuario);
        }else{

        }
    }).error(function (data, status, headers, config){

    });

}

$scope.listar_tareas=function(){
    $http({
        method: 'GET',
        url: '/peticiones_res/tareas',
        params: {
            v_id_responsables:3 ,
        }
    }).success(function (data, status, headers, config){
        if(data.status){
            $scope.listas=data.data;
        }else{

        }
    }).error(function (data, status, headers, config){

    });

}
$scope.historial=function(){
    $http({
        method: 'GET',
        url: '/peticiones_res/historial',
        params: {
            v_id_responsables:$scope.id ,
        }
    }).success(function (data, status, headers, config){
        if(data.status){
            $scope.listas2=data.data;
        }else{

        }
    }).error(function (data, status, headers, config){

    });

}

    $scope.logout=function(){
        $.ajax({
            url:"login_controller/logout",
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

    $scope.listar_detalle();
    $scope.listar_tareas();
    $scope.historial();

});
    //TERMINA BUSCADOR
