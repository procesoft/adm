
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



angular.module('apptablas', [])
.controller('controlador', function($scope,$http) {
    $scope.url=window.location.href.split('/');
    $scope.id = $scope.url[4].split('#')[0];
    $scope.id_api="";
    $scope.listas = [];
    $scope.ocultar=false;
    $scope.filtro_mod="";
    $scope.filtro="";
    $scope.tipo="";
    $scope.editar="";
    $scope.pagina=1;
    $scope.pag=[];
    $scope.ordenar="";
    $scope.activo="";
    $scope.responsables="";
    $scope.responsablesBD="";
    $scope.descripcion="";
    $scope.rol=usuario[0].id_rol;

    $scope.anterior=function(val){
        bloquear();
        $scope.pagina+=parseInt(val);
        $scope.listar_apis();
    }

    $scope.siguiente=function(val){
        bloquear();
        $scope.pagina+=parseInt(val);
        $scope.listar_apis();
    }
    $scope.verresponsables=function(){
        if(usuario[0].id_rol == 1 || usuario[0].id_rol == 2 || usuario[0].id_rol == 3){
            window.location="/responsables";
        }else{

        }
    }


$scope.agregar_auxiliar=function(){
    $http({
        method: 'GET',
        url: '/gestortabla/agregar_auxiliar',
        params: {
            v_id_login:usuario[0].id_responsable,
            v_id_modulo:$scope.id,
            v_id_auxiliar:$("#responsablesBD").val(),
        }
    }).success(function (data, status, headers, config){
        if (data.status) {
        $('#modal2').closeModal();
        swal({
            title: 'Correcto',
            text: "Se agrego auxiliar correctamente!!",
            type: 'success',
            showCancelButton: false,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Aceptar",
            closeOnConfirm: true
        },
        function(){
            $scope.listar_apis();
        });
    }else{
        swal("Alerta",data.data,"warning");
    }
    }).error(function (data, status, headers, config){

    });

}
$scope.detallemodulo=function(){
    $http({
        method: 'GET',
        url: '/gestormodulos/detalles_modulos',
        params: {
            v_opcion:2,
            v_id_opcion:$scope.id,
        }
    }).success(function (data, status, headers, config){
        if(data.status){
            $('#responsableB').empty();
            $('#auxiliar').empty();
            $('#total_apis').empty();
            $('#nombre_encabezado').empty();
            $('#descripcion_encabezado').empty();

            $('#responsableB').append(data.data[0].responsable_base);
            $('#auxiliar').append(data.data[0].auxiliar_base);
            $scope.auxiliar=data.data[0].auxiliar_base;
            $('#nombre_encabezado').append(data.data[0].nombre);
            $('#descripcion_encabezado').append(data.data[0].descripcion);
            $('#total_apis').append(data.data[0].tablas);

            $scope.id_api=data.data[0].id_api;
        }
    }).error(function (data, status, headers, config){

    });
}
$scope.listar_apis=function(){
    bloquear();
    $http({
        method: 'GET',
        url: '/gestortabla/traer_datos',
        params: {
            v_id_modulo:$scope.id,
            v_nombre:$("#txt_buscador").val(),
            v_fecha:$('#date').val(),
            v_num_pagina:$scope.pagina,
            v_cantidad:10,
            v_campo:"nombre",
            v_ordenado:$('#ordenar').val(),
        }
    }).success(function (data, status, headers, config){
        if(data.status){
            $('#responsableB').empty();
            $('#auxiliar').empty();
            $('#total_apis').empty();
            $('#nombre_encabezado').empty();
            $('#descripcion_encabezado').empty();
            $scope.listas = data.data;
            for(var i=0;i<$scope.listas.length;i++){
                var fecha_c=$scope.listas[i].fecha_creacion;
                var fecha_m=$scope.listas[i].fecha_modificacion;
                $scope.listas[i].fecha_creacion=fecha_c.split(' ')[0];
                $scope.listas[i].fecha_modificacion=fecha_m.split(' ')[0];
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
            $('#responsableB').append(data.data[0].responsable);
            $('#auxiliar').append(data.data[0].auxiliar);
            $scope.auxiliar=data.data[0].auxiliar;
            $('#nombre_encabezado').append(data.data[0].modulo);
            $('#descripcion_encabezado').append(data.data[0].descripcion);
            $('#total_apis').append(data.data[0].total_datos);
            $scope.pag_total = data.data[0].paginas_total;
            var pagina;
            $scope.id_api=data.data[0].id_api;

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

$scope.prueba = function(val){
    $scope.pagina=val;
    $scope.listar_apis();
}

    $scope.testAllowed = function () {
        var stocks = new Bloodhound({
            datumTokenizer: function () {
                return Bloodhound.tokenizers.whitespace($('#txt_buscador').val());
            },
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                url: '/gestortabla/traer_datos?v_id_modulo=%ID&v_nombre=%QUERY&v_fecha=%FECHA&v_ordenado=%ORDENAR&v_num_pagina=1&v_cantidad=10',
                replace: function (url, query) {
                    var nombre = encodeURIComponent($("#txt_buscador").val());
                    var id = encodeURIComponent($scope.id);
                    var ordenar = encodeURIComponent(($("#ordenar").val()==null?0:$("#responsables").val()));
                    var fecha = encodeURIComponent($("#date").val());
                    var uri = url.replace('%QUERY', nombre).replace('%ID', id).replace('%ORDENAR', ordenar).replace('%FECHA', fecha);
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
                        $scope.listas = data;
                        for(var i=0;i<$scope.listas.length;i++){
                            var fecha_c=$scope.listas[i].fecha_creacion;
                            var fecha_m=$scope.listas[i].fecha_modificacion;
                            $scope.listas[i].fecha_creacion=fecha_c.split(' ')[0];
                            $scope.listas[i].fecha_modificacion=fecha_m.split(' ')[0];
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
                        $scope.pag_total = $scope.listas[0].paginas_total;
                        var pagina;
                        $scope.pag=[];
                        for(var x=0;x<$scope.pag_total;x++){
                            pagina=x+1;
                            $scope.pag.push({
                                id:pagina,
                            });
                        }
                        if($('#txt_buscador').val()==""){
                            setTimeout(function(){$('input.col.s12.tt-hint').val('')},100);
                        }
                        $scope.nod = false;
                    }
                    if(data==""){
                        $scope.ocultar=true;
                        $scope.listas = [];
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


    $scope.filtro_Mod=function(val){
        $.ajax({
            url:"/gestormodulos/filtros",
            dataType:"json",
            type:"GET",
            data:{
                'filtro':val,
            },
            success: function(data){
            if (data.status) {
                if(val == "DS"){
                    $('#responsables_mod').empty();
                    $('#responsables_mod').append('<option value="" disabled selected>Responsable Desarrollo</option>');
                    for(ip in data.data){
                        $('#responsables_mod').append('<option value="'+data.data[ip].id_responsable+'">'+data.data[ip].nick+'</option>');
                    }
                }else{
                    $('#responsablesBD_mod').empty();
                    $('#responsablesBD_mod').append('<option value="" disabled selected>Responsable BD</option>');
                        for(ip in data.data){
                            $('#responsablesBD_mod').append('<option value="'+data.data[ip].id_responsable+'">'+data.data[ip].nick+'</option>');
                        }
                }

                $('select').material_select('update');

            }else{
                console.log(data.status);
            }
        }
        });
    }

    $scope.activarModalInsertar=function(val){
        $scope.filtro_Mod("DS");
        $scope.filtro_Mod("DB");
        $('#modal1').openModal();
        if(val != 0){
            $scope.modificar(val);
        }else{
            $('#titulo').empty();
            $('#nombre_tabla').val("");
            $('#tipo').val("");
            $('#descripcion').val("");
            $('#titulo').append('<h4>Crear nueva tabla</h4>');
            $scope.tipo="nuevo";
            $('select').material_select('update');
        }
    }
    $scope.activarModalauxiliar=function(val){
        $('#modal2').openModal();
        $scope.filtros2(val);

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

    $scope.filtros=function(){
        $.ajax({
            url:"/gestormodulos/filtros",
            dataType:"json",
            type:"GET",
            data:{
                'filtro':"DS",
            },
            success: function(data){
                $('#responsables').empty();
            if (data.status) {
                $('#responsables').append('<option value="" disabled selected>Responsable Desarrollo</option>');
                $('#responsables').append('<option value="">Todos</option>');
                    for(ip in data.data){
                        $('#responsables').append('<option value="'+data.data[ip].id_responsable+'">'+data.data[ip].nick+'</option>');
                    }

                $('select').material_select('update');

            }else{
                console.log(data.status);
            }
        }
        });
    }

    $scope.filtros2=function(val){
        $.ajax({
            url:"/gestormodulos/filtros",
            dataType:"json",
            type:"GET",
            data:{
                'filtro':"DB",
            },
            success: function(data){
                $('#responsablesBD').empty();
            if (data.status) {
                $('#responsablesBD').append('<option value="" disabled selected>Responsable BD</option>');
                    for(ip in data.data){
                        $('#responsablesBD').append('<option value="'+data.data[ip].id_responsable+'">'+data.data[ip].nick+'</option>');
                    }
                    if(val=="editar"){
                        $('#titulo2').empty();
                        $('#titulo2').append('<h4>Editar auxiliar</h4>');
                        setTimeout(function(){$('#responsablesBD').val($scope.listas[0].id_auxiliar_base)},600);
                        setTimeout(function(){$('select').material_select('update')},600);
                    }
                $('select').material_select('update');

            }else{
                console.log(data.status);
            }
        }
        });
    }
    $scope.modificar=function(val){
        $scope.editar=val;
        $.ajax({
            url:"/gestortabla/detalle",
            dataType:"json",
            type:"GET",
            data:{
                v_id_tabla:val,
            },
            success: function(data){
                if (data.status) {
                    $('#titulo').empty();
                    $('#nombre_tabla').val(data.data[0].nombre);
                    $('#tipo').val(data.data[0].tipo);
                    $('#descripcion').val(data.data[0].descripcion);
                    $('#titulo').append('<h4>Editar tabla</h4>');
                    setTimeout(function(){$('select').material_select('update')},600);
                    $scope.tipo="editar";
                }else{
                    swal("Alerta",data.data,"warning");
                }
            }
        });
    }
    $scope.eliminar=function(val){
        swal({
          title: 'Alerta',
          text: "¿Seguro que quiere eliminar este registro?",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Aceptar",
          closeOnConfirm: true
        },
        function(){
            bloquear();
            $.ajax({
                url:"/gestortabla/eliminar",
                dataType:"json",
                type:"POST",
                data:{
                    v_id_login:usuario[0].id_responsable,
                    v_id_tabla:val,
                },
                success: function(data){
                    if (data.status) {
                        $scope.listar_apis();
                        desbloquear();
                        swal('Correcto!!','se ha eliminado correctamente','success');
                    }else{
                        desbloquear();
                        swal("Alerta",data.data,"warning");
                    }
                }
            });
        });
    }
    $scope.nuevo=function(){
        if($scope.tipo == "nuevo"){
            if($('#nombre_tabla').val()=="" || $('#descripcion').val()=="" || $('#tipo').val()==""){
                swal('Alerta',"Completar todos los campos","warning");
            }else{
                bloquear();
                $.ajax({
                    url:"/gestortabla/nuevo",
                    dataType:"json",
                    type:"POST",
                    data:{
                        v_id_login:usuario[0].id_responsable,
                        v_id_api:$scope.id_api,
                        v_id_modulo:$scope.id,
                        v_nombre:$('#nombre_tabla').val(),
                        v_descripcion:$('#descripcion').val(),
                        v_tipo:$('#tipo').val(),
                    },
                    success: function(data){
                        if (data.status) {
                            $('#modal1').closeModal();
                            desbloquear();
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
                                $scope.listar_apis();
                            });
                        }else{
                            desbloquear();
                            swal("Alerta",data.data,"warning");
                        }
                    }
                });

            }
        }else if($scope.tipo == "editar"){
            if($('#nombre_tabla').val()=="" || $('#descripcion').val()=="" || $('#tipo').val()==""){
                swal('Alerta',"Completar todos los campos","warning");
            }else{
                bloquear();
                $.ajax({
                    url:"/gestortabla/modificar",
                    dataType:"json",
                    type:"POST",
                    data:{
                        v_id_login:usuario[0].id_responsable,
                        v_id_tabla: $scope.editar,
                        v_nombre:$('#nombre_tabla').val() ,
                        v_descripcion:$('#descripcion').val() ,
                        v_tipo:$('#tipo').val(),
                    },
                    success: function(data){
                        if (data.status) {
                            $('#modal1').closeModal();
                            desbloquear();
                            swal({
                                title: 'Correcto',
                                text: "Se modificó correctamente!!",
                                type: 'success',
                                showCancelButton: false,
                                confirmButtonColor: "#DD6B55",
                                confirmButtonText: "Aceptar",
                                closeOnConfirm: true
                            },
                            function(){
                                $scope.listar_apis();
                            });
                        }else{
                            desbloquear();
                            swal("Alerta",data.data,"warning");
                        }
                    }
                });
            }
        }
    }
    $scope.filtros();
    $scope.listar_apis();
    $scope.detallemodulo();

});
    //TERMINA BUSCADOR
