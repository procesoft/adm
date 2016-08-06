
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



angular.module('asignado_a', [])
.controller('controlador', function($scope,$http) {
    $scope.url=window.location.href.split('/');
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
    $scope.tareas_exist=0;
    $scope.rol=usuario[0].id_rol;


$scope.listar_detalle=function(){
    $http({
        method: 'GET',
        url: '/asignado_a/asig',
        params: {
            id: usuario[0].id_responsable ,
            pagina: 1,
            cantidad: 10
        }
    }).success(function (data, status, headers, config){
        if(data.status){
            $scope.listas = data.data;
            $scope.ocultar = false;
            $scope.pag_total = $scope.listas[0].paginas_total;
        }else{
            $scope.ocultar = true;
        }
    }).error(function (data, status, headers, config){

    });

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
$scope.mas = function(){
    if($scope.pagina <= $scope.pag_total){
        $scope.pagina += 1;
        $http({
            method: 'GET',
            url: '/asignado_a/asig',
            params: {
                id: usuario[0].id_responsable ,
                pagina: $scope.pagina,
                cantidad: 10
            }
        }).success(function (data, status, headers, config){
            if(data.status){
                for(var x = 0; x< data.data.length; x++){
                    $scope.listas.push(data.data[x]);
                }
                $scope.ocultar = false;
            }else{
                $scope.ocultar = true;
            }
        }).error(function (data, status, headers, config){

        });
    }
}
    $scope.listar_detalle();

});
    //TERMINA BUSCADOR
