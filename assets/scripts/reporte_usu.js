
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
    $scope.pagina2=1;
    $scope.tamano="";
    $scope.cambio_tbl=false;
    $scope.estatus="";
    $scope.estatus2="";
    $('#activo2').hide();
    $('#activo1').hide();

$scope.listar_datos=function(){
    bloquear();
    $('#activo2').hide();
    $('#activo1').show();
    $http({
        method: 'GET',
        url: 'reporte_usu/traer_datos',
        params: {
            usuario:0,
            estatus:$('#estatus').val(),
            pag:$scope.pagina,
            cant:10,
        }
    }).success(function (data, status, headers, config){
        if(data.status){
            $scope.cambio_tbl=false;
            $scope.listas = data.data;
            for(var x=0; x<$scope.listas.length;x++){
                if($scope.listas[x].id_rol==1){
                    $scope.listas[x].id_rol="Super usuario"
                }else if($scope.listas[x].id_rol==2){
                    $scope.listas[x].id_rol="Administrador web"
                }else if($scope.listas[x].id_rol==3){
                    $scope.listas[x].id_rol="Administrador Bd"
                }else if($scope.listas[x].id_rol==4){
                    $scope.listas[x].id_rol="Desarrollo"
                }else if($scope.listas[x].id_rol==5){
                    $scope.listas[x].id_rol="Base de datos"
                }else if($scope.listas[x].id_rol==6){
                    $scope.listas[x].id_rol="Qa"
                }
            }


            $scope.pag_total = data.data[0].paginas_total;

            $scope.ocultar=false;

            $scope.nod = false;
            desbloquear();
        }else{
                $scope.ocultar=true;
                $scope.listas = [];
                $scope.nod = true;
                $scope.nod = true;
                $scope.pag_total = 1;
                desbloquear();
        }
    }).error(function (data, status, headers, config){

    });

}

$scope.detalles=function(x){
    bloquear();
    $('#activo2').show();
    $('#activo1').hide();
    if(x != 0){
        $scope.res=x;
    }
    $http({
        method: 'GET',
        url: 'reporte_usu/traer_datos',
        params: {
            usuario:$scope.res,
            estatus:$('#estatus2').val(),
            pag:$scope.pagina2,
            cant:10,
        }
    }).success(function (data, status, headers, config){
        if(data.status){
            $scope.cambio_tbl=true;
            $scope.listas = data.data;
            for(var i=0;i<$scope.listas.length;i++){
                switch($scope.listas[i].status){
                    case 'D':
                    $scope.listas[i].status="Definicion";
                    break;
                    case 'P':
                    $scope.listas[i].status="Progreso";
                    break;
                    case "R":
                    $scope.listas[i].status="Revision";
                    break;
                    case "T":
                    $scope.listas[i].status="Terminado";
                    break;
                }
            }
            $scope.pag_total = data.data[0].paginas_total;

            $scope.ocultar=false;

            $scope.nod = false;
            desbloquear();
        }else{
                $scope.ocultar=true;
                $scope.listas = [];
                $scope.nod = true;
                $scope.nod = true;
                $scope.pag_total = 1;
                desbloquear();
        }
    }).error(function (data, status, headers, config){

    });

}
$scope.anterior=function(val){
    bloquear();
    $scope.pagina+=parseInt(val);
    $scope.listar_datos();
}

$scope.siguiente=function(val){
    bloquear();
    $scope.pagina+=parseInt(val);
    $scope.listar_datos();
}

$scope.anterior2=function(val){
    bloquear();
    $scope.pagina2+=parseInt(val);
    $scope.detalles(0);
}

$scope.siguiente2=function(val){
    bloquear();
    $scope.pagina2+=parseInt(val);
    $scope.detalles(0);
}
$scope.imprimir = function () {

    window.open('/c_test/create_pdf_usu_uno?usuario=' + 0 +'&estatus='+$('#estatus').val()+'&pag='+$scope.pagina+'&cant='+ 0, '', 'width=600,height=400,left=50,top=50,toolbar=yes');
}
$scope.imprimir2 = function () {

    window.open('/c_test/create_pdf_usu_dos?usuario=' + $scope.res +'&estatus='+$('#estatus2').val()+'&pag='+$scope.pagina2+'&cant='+ 0, '', 'width=600,height=400,left=50,top=50,toolbar=yes');
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

    $scope.listar_datos();

});
    //TERMINA BUSCADOR
