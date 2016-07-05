
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



angular.module('appmodulos', [])
.controller('controlador', function($scope,$http) {
    $scope.url=window.location.href.split('/');
    $scope.id = $scope.url[4].split('#')[0];
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

    $scope.anterior=function(val){
        $scope.pagina+=parseInt(val);
        $scope.listar_apis();
    }

    $scope.siguiente=function(val){
        $scope.pagina+=parseInt(val);
        $scope.listar_apis();
    }

$scope.listar_apis=function(){
    $http({
        method: 'GET',
        url: '/gestormodulos/traer_datos',
        params: {
            v_id_api:$scope.id,
            v_nombre_modulo:$("#txt_buscador").val(),
            v_id_responsable_web:($("#responsables").val()==null?0:$("#responsables").val()),
            v_id_responsable_base:($("#responsablesBD").val()==null?0:$("#responsablesBD").val()),
            v_status_modulo:($("#activo2").val()==null?0:$("#activo2").val()),
            v_fecha:$('#date').val(),
            v_num_pagina:$scope.pagina,
            v_cantidad:10,
            v_campo:"nombre",
            v_ordenado:$('#ordenar').val(),
        }
    }).success(function (data, status, headers, config){
        if(data.status){
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
            $('#nombre_encabezado').append(data.data[0].api);
            $('#descripcion_encabezado').append(data.data[0].descripcion);
            $('#total_apis').append(data.data[0].total_datos);
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
                url: '/gestormodulos/traer_datos?v_nombre_modulo=%QUERY&v_id_api=%ID&v_id_responsable_web=%WEB&v_id_responsable_base=%BD&v_status_modulo=%ACTIVO&v_fecha=%FECHA&v_ordenado=%ORDENAR&v_num_pagina=1&v_cantidad=10',
                replace: function (url, query) {
                    var nombre = encodeURIComponent($("#txt_buscador").val());
                    var id = encodeURIComponent($scope.id);
                    var web = encodeURIComponent(($("#responsables").val()==null?0:$("#responsables").val()));
                    var bd = encodeURIComponent(($("#responsablesBD").val()==null?0:$("#responsablesBD").val()));
                    var ordenar = encodeURIComponent(($("#ordenar").val()==null?0:$("#ordenar").val()));
                    var activo = encodeURIComponent(($("#activo2").val()==null?0:$("#activo2").val()));
                    var fecha = encodeURIComponent($("#date").val());
                    var uri = url.replace('%QUERY', nombre).replace('%ID', id).replace('%WEB', web).replace('%BD', bd).replace('%ORDENAR', ordenar).replace('%ACTIVO', activo).replace('%FECHA', fecha);
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
            $('#nombre_api').val("");
            $('#prefijo').val("");
            $('#descripcion').val("");
            $('#servidormod').val("0");
            $('#basemod').val("0");
            $('#titulo').append('<h4>Crear nuevo módulo</h4>');
            $scope.tipo="nuevo";
            $('select').material_select('update');
        }
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

    $scope.filtros2=function(){
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
                $('#responsablesBD').append('<option value="">Todos</option>');
                    for(ip in data.data){
                        $('#responsablesBD').append('<option value="'+data.data[ip].id_responsable+'">'+data.data[ip].nick+'</option>');
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
            url:"/gestormodulos/detalle",
            dataType:"json",
            type:"GET",
            data:{
                v_id_modulo:val,
            },
            success: function(data){
                if (data.status) {
                    $('#titulo').empty();
                    $('#nombre_modulo').val(data.data[0].nombre);
                    setTimeout(function(){$('#responsables_mod').val(data.data[0].id_responsable_web)},600);
                    setTimeout(function(){$('#responsablesBD_mod').val(data.data[0].id_responsable_base)},600);
                    $('#descripcion').val(data.data[0].descripcion);
                    $('#titulo').append('<h4>Editar módulo</h4>');
                    setTimeout(function(){$('select').material_select('update')},600);
                    $scope.tipo="editar";
                }else{
                    console.log(data.status);
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
            $.ajax({
                url:"/gestormodulos/eliminar",
                dataType:"json",
                type:"POST",
                data:{
                    v_id_login:usuario[0].id_responsable,
                    v_id_modulo:val,
                },
                success: function(data){
                    if (data.status) {
                        $scope.listar_apis();
                        swal('Correcto!!','se ha eliminado correctamente','success');
                    }else{
                        console.log(data.status);
                    }
                }
            });
        });
    }
    $scope.nuevo=function(){

        if($scope.tipo == "nuevo"){
            $.ajax({
                url:"/gestormodulos/nuevo",
                dataType:"json",
                type:"POST",
                data:{
                    v_id_login:usuario[0].id_responsable,
                    v_id_api:$scope.id,
                    v_nombre:$('#nombre_modulo').val(),
                    v_descripcion:$('#descripcion').val(),
                    v_id_responsable_web:$('#responsables_mod').val(),
                    v_id_responsable_base:$('#responsablesBD_mod').val(),
                    v_id_auxiliar_web:0,
                    v_id_auxiliar_base:0,
                },
                success: function(data){
                    if (data.status) {
                        $('#modal1').closeModal();
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
                        console.log(data.status);
                    }
                }
            });
        }else if($scope.tipo == "editar"){
            $.ajax({
                url:"/gestormodulos/modificar",
                dataType:"json",
                type:"POST",
                data:{
                    v_id_login:usuario[0].id_responsable,
                    v_id_api:$scope.id,
                    v_id_modulo:$scope.editar,
                    v_nombre:$('#nombre_modulo').val(),
                    v_descripcion:$('#descripcion').val(),
                    v_id_responsable_web:$('#responsables_mod').val(),
                    v_id_responsable_base:$('#responsablesBD_mod').val(),
                    v_id_auxiliar_web:0,
                    v_id_auxiliar_base:0,
                },
                success: function(data){
                    if (data.status) {
                        $('#modal1').closeModal();
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
                        console.log(data.status);
                    }
                }
            });
        }
    }

    $scope.filtros();
    $scope.filtros2();
    $scope.listar_apis();

});
    //TERMINA BUSCADOR
