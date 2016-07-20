
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

$(".datepicker").pickadate({
    monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
    monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
    weekdaysFull: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sábado'],
    today: 'Hoy',
    clear: 'Limpiar',
    close: 'Cerrar',
});

$('#tamano').inputmask('99');
angular.module('appResponsables', [])
.controller('controlador', function($scope,$http) {
    $scope.listas = [];
    $scope.ocultar=false;
    $scope.pagina=1;



$scope.listar_datos=function(){

    $http({
        method: 'GET',
        url: 'report/traer_datos',
        params: {
            v_fecha_inicio:"",
            v_fecha_fin:"",
            v_modulos_minimos:"",
        }
    }).success(function (data, status, headers, config){
        if(data.status){
            $scope.listas = data.data;

            $scope.pag_total = data.data[0].paginas_total;

            $scope.ocultar=false;

            $scope.nod = false;
        }else{
                $scope.ocultar=true;
                $scope.listas = [];
                $scope.nod = true;
                $scope.nod = true;
                $scope.pag_total = 1;
        }
    }).error(function (data, status, headers, config){

    });

}

$scope.imprimir = function () {
    var id ="";
    //window.open('c_test/create_pdf_alcance?v_fecha_inicio=' + id, '', 'width=600,height=400,left=50,top=50,toolbar=yes');
    window.open('c_test/create_pdf_alcance?v_fecha_inicio=' + id, 'v_fecha_fin='+ id,'v_modulos_minimos='+ id, '', 'width=600,height=400,left=50,top=50,toolbar=yes');
}

    $scope.listar_datos();

});
    //TERMINA BUSCADOR
