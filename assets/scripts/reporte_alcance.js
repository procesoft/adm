
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
    $scope.tamano="";

$scope.fechas=function(ini){
    if(ini != ""){
        var fechaini_dia= ini.split(" ")[0].split(",");
        var fechaini_mes= ini.split(" ")[1].split(",")[0];
        var fechaini_ayo= ini.split(" ")[2].split(",");

        switch(fechaini_mes){
            case "Enero":
                fechaini_mes='01';
            break;
            case "Febrero":
                fechaini_mes='02';
            break;
            case "Marzo":
                fechaini_mes='03';
            break;
            case "Abril":
                fechaini_mes='04';
            break;
            case "Mayo":
                fechaini_mes='05';
            break;
            case "Junio":
                fechaini_mes='06';
            break;
            case "Julio":
                fechaini_mes='07';
            break;
            case "Agosto":
                fechaini_mes='08';
            break;
            case "Septiembre":
                fechaini_mes='09';
            break;
            case "Octubre":
                fechaini_mes='10';
            break;
            case "Noviembre":
                fechaini_mes='11';
            break;
            case "Diciembre":
                fechaini_mes='12';
            break;
        }
        console.log(fechaini_mes);
        return fechaini_ayo+'-'+fechaini_mes+'-'+fechaini_dia;
    }
}
$scope.listar_datos=function(){
    var inicio=$('#ini').val();
    var fin=$('#fin').val();
    var fecha_in=$scope.fechas(inicio);
    var fecha_fin=$scope.fechas(fin);
    $http({
        method: 'GET',
        url: 'report/traer_datos',
        params: {
            v_fecha_inicio:fecha_in,
            v_fecha_fin:fecha_fin,
            v_modulos_minimos:$('#tamano').val(),
            v_num_pagina:$scope.pagina,
            v_cantidad:10,
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
$scope.anterior=function(val){
    $scope.pagina+=parseInt(val);
    $scope.listar_datos();
}

$scope.siguiente=function(val){
    $scope.pagina+=parseInt(val);
    $scope.listar_datos();
}
$scope.imprimir = function () {
    var ini=$('#ini').val();
    var fin=$('#fin').val();
    var min=0;
    var fecha_in=$scope.fechas(ini);
    var fecha_fin=$scope.fechas(fin);
    window.open('/c_test/create_pdf_alcance?v_fecha_inicio=' + fecha_in +'&v_fecha_fin='+fecha_fin+'&v_modulos_minimos='+ min, '', 'width=600,height=400,left=50,top=50,toolbar=yes');
}

    $scope.listar_datos();

});
    //TERMINA BUSCADOR
