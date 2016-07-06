
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



angular.module('appResponsables', [])
.controller('controlador', function($scope,$http) {
    $scope.listas = [];
    $scope.ocultar=false;
    $scope.filtro_mod="";
    $scope.filtro="";
    $scope.tipo="";
    $scope.editar="";
    $scope.pagina=1;
    $scope.ordenar="";
    $scope.activo="";


$scope.listar_datos=function(){

    $http({
        method: 'GET',
        url: 'perfil/detalle',
        params: {
            v_id_responsable:usuario[0].id_responsable,
        }
    }).success(function (data, status, headers, config){
        if(data.status){
            $('#nombre').val(data.data[0].nombre);
            $('#nick').val(data.data[0].nick);
            $('#apellido_pa').val(data.data[0].apellido_paterno);
            $('#apellido_ma').val(data.data[0].apellido_materno);
            $('#correo').val(data.data[0].usuario);
            $('#Area').val(data.data[0].id_rol);
            $('select').material_select('update');
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


    $scope.modificar=function(){
        if($('#nombre').val()=="" || $('#nick').val()=="" || $('#apellido_pa').val()=="" || $('#apellido_ma').val()=="" || $('#correo').val()=="" || $('#Area').val()==""){
            swal('Alerta', 'Campos en blanco','warning');
        }
        if($('#psw_actual').val()){
            $.ajax({
                url:"login_controller/postlogin",
                dataType:"json",
                type:"post",
                data:{
                    'user':usuario[0].usuario,
                    'pass':$('#psw_actual').val(),
                },
                success: function(data){
                    if (data.status) {
                        if($('#psw_nueva').val()==$('#psw_renueva').val() && $('#psw_nueva').val()!="" && $('#psw_renueva').val()!=""){
                            $scope.editar(1);
                        }else{
                            swal('Alerta','Debe de coincidir la nueva contraseña', 'warning')
                        }
                    }else{
                        swal('Alerta','Favor de colocar tu contraseña actual','warning')
                    }
                }
            });
        }else{
            $scope.editar(0);
        }
    }

    $scope.editar=function(val){
        if($('#psw_nueva').val()=="" || $('#nombre').val()=="" || $('#apellido_pa').val()=="" || $('#apellido_ma').val()=="" || $('#nick').val()=="" || $('#Area').val()==""){
            swal('Alerta',"Completar todos los campos","warning");
        }else{
            $.ajax({
                url:"perfil/modificar",
                dataType:"json",
                type:"POST",
                data:{
                    v_id_login:usuario[0].id_responsable,
                    v_id_responsable:usuario[0].id_responsable,
                    v_password:$('#psw_nueva').val(),
                    v_nombre:$('#nombre').val() ,
                    v_apellido_paterno:$('#apellido_pa').val(),
                    v_apellido_materno:$('#apellido_ma').val(),
                    v_nick:$('#nick').val(),
                    v_id_rol:$('#Area').val(),
                },
                success: function(data){
                    if (data.status) {
                        swal({
                            title: 'Correcto',
                            text: "Se guardo correctamente!!",
                            type: 'success',
                            showCancelButton: false,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "Aceptar",
                            closeOnConfirm: true
                        },
                        function(){
                            if(val==1){
                                $scope.correo();
                                setTimeout(function(){location.reload()},500);
                            }else{
                                location.reload();
                            }
                        });
                    }else{
                        swal('Alerta',data.data,"warning");
                    }
                }
            });

        }
    }
    $scope.correo=function(){
        $.ajax({
            url:"perfil/mail",
            dataType:"json",
            type:"POST",
            data:{
                correo:$('#correo').val(),
                pass:$('#psw_nueva').val(),
                nom:$('#nombre').val(),
            },
            success: function(data){
                console.log(data);
            }
        });
    }
    $scope.listar_datos();

});
    //TERMINA BUSCADOR
