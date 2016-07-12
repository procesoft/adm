
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
    $scope.tareas_exist=0;


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
            v_id_responsables:$scope.id,
        }
    }).success(function (data, status, headers, config){
        if(data.status){
            if(data.data==""){
                $scope.tareas_exist=1;
            }else{
                $scope.listas=data.data;
                $scope.tareas_exist=0;
            }
        }else{

        }
    }).error(function (data, status, headers, config){

    });

}

$scope.testAllowed = function () {
    var stocks = new Bloodhound({
        datumTokenizer: function () {
            return Bloodhound.tokenizers.whitespace($('#txt_buscador').val());
        },
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            url: '/peticiones_res/historial?v_id_login=%RES&v_id_responsables=0&v_accion=%QUERY&v_id_accion=0&v_num_paginas=1&v_cantidad=10',
            replace: function (url, query) {
                var nombre = encodeURIComponent($("#txt_buscador").val());
                var res=encodeURIComponent($scope.id);
                var uri = url.replace('%QUERY', nombre).replace('%RES', res);
                return uri;
            },
        }
    })

    stocks.initialize();
    $('#txt_buscador').typeahead({
        minLength: 0
    }, {
        name: 'nombre',
        displayKey: 'nombre',
        source: stocks.ttAdapter(),
        templates: {
            suggestion: function (data) {
                stocks.clearRemoteCache();
                $(".tt-dropdown-menu").remove();
                $scope.$apply();
                if (data.length > 0) {
                    $scope.ocultar=false;
                    $scope.listas2=data;
                    $scope.pag_total = $scope.listas2[0].paginas_total;
                    if($('#txt_buscador').val()==""){
                        setTimeout(function(){$('input.ng-pristine.ng-untouched.ng-valid.tt-hint').val('')},100);
                    }
                }
                if(data==""){
                    $scope.ocultar=true;
                    $scope.listas2 = [];
                    $scope.pag_total=1;
                    $scope.nod = true;
                }
                $scope.pag = 1;
                $scope.$apply();
            }
        }
    })
    $(".twitter-typeahead").addClass("col-md-12");
    $(".twitter-typeahead").css("padding", "0");
}


$scope.historial=function(){
    $http({
        method: 'GET',
        url: '/peticiones_res/historial',
        params: {
            v_id_login:$scope.id,
            v_id_responsables:0,
            v_id_accion:0,
            v_accion:$("#txt_buscador").val(),
            v_num_paginas:$scope.pagina,
            v_cantidad:10,
        }
    }).success(function (data, status, headers, config){
        if(data.status){
            if($scope.pagina == data.data[0].paginas_total){
                $('#mas').hide();
            }
            for(var i=0; i<data.data.length; i++){
                $scope.listas2.push({
                    accion:data.data[i].accion,
                    fecha_creacion:data.data[i].fecha_creacion,
                    nick_responsable:data.data[i].nick_responsable,
                });
            }

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

$scope.pagina_sig=function(val){
    var pagina=$scope.pagina+parseInt(val);
    $scope.pagina=pagina;
    $scope.historial();
}
    $scope.listar_detalle();
    $scope.listar_tareas();
    $scope.historial();

});
    //TERMINA BUSCADOR
