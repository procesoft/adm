
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

$scope.anterior=function(val){
    $scope.pagina+=parseInt(val);
    $scope.listar_apis();
}

$scope.siguiente=function(val){
    $scope.pagina+=parseInt(val);
    $scope.listar_apis();
}

$scope.listar_apis=function(){
    var base=$('#BD').val();
    if(base==null){
        base=0;
    }
    $http({
        method: 'GET',
        url: 'responsables/traer_datos',
        params: {
            v_id_responsable:0,
            v_activo:$('#activos2').val(),
            v_nombre:$("#txt_buscador").val(),
            v_id_rol:0,
            v_num_pagina:$scope.pagina,
            v_cantidad:10,
            v_campo:'',
            v_ordenado:$('#ordenar').val()
        }
    }).success(function (data, status, headers, config){
        if(data.status){
            $scope.listas = data.data;
            for(var i=0;i<$scope.listas.length;i++){
                switch($scope.listas[i].activo){
                    case 'S':
                    $scope.listas[i].activo="Habilitado";
                    break;
                    case 'N':
                    $scope.listas[i].activo="Deshabilitado";
                    break;
                }
            }
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
                //v_id_responsable,v_activo,v_nombre,v_id_rol,v_num_pagina,v_cantidad,v_campo,v_ordenado
                url: 'responsables/traer_datos?v_id_responsable=0&v_activo=%ACTIVO&v_nombre=%QUERY&v_id_rol=%ROL&v_num_pagina=1&v_cantidad=10&v_campo=&v_ordenado=%ORDENAR',
                replace: function (url, query) {
                    var nombre = encodeURIComponent($("#txt_buscador").val());
                    var rol = encodeURIComponent(($('#Area').val()==null?0:$('#Area').val()));
                    var status = encodeURIComponent(($('#activos2').val()==null?"":$('#activos2').val()));
                    var ordenar = encodeURIComponent($('#ordenar').val());
                    var uri = url.replace('%QUERY', nombre).replace('%ROL', rol).replace('%ACTIVO', status).replace('%ORDENAR', ordenar);
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
                            switch($scope.listas[i].activo){
                                case 'S':
                                $scope.listas[i].activo="Habilitado";
                                break;
                                case 'N':
                                $scope.listas[i].activo="Deshabilitado";
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


    $scope.filtro_Mod=function(id_base){
        var val=$('#servidormod').val();
        if(val == '? undefined:undefined ?'){
            val="";
        }
        $.ajax({
            url:"responsables/filtros",
            dataType:"json",
            type:"GET",
            data:{
                'filtro':val,
            },
            success: function(data){
                $('#basemod').empty();

            if (data.status) {
                $('#basemod').append('<option value="0" disabled selected>Base de datos</option>');
                if(val == ""){
                    $('#servidormod').empty();
                    $('#servidormod').append('<option value="0" disabled selected>Servidor</option>');
                    for(ip in data.data){
                        $('#servidormod').append('<option value="'+data.data[ip].servidor+'">'+data.data[ip].servidor+'</option>');
                    }
                }else{
                    for(ip in data.data){
                        if(data.data[ip].base_de_datos){
                            $('#basemod').append('<option value="'+data.data[ip].id_base_de_datos+'">'+data.data[ip].base_de_datos+'</option>');
                        }
                    }
                }
                if(id_base != ""){
                    setTimeout(function(){$('#basemod').val(id_base)},500);
                }
                $('select').material_select('update');

            }else{
                console.log(data.status);
            }
        }
        });
    }
    /*$('#servidormod').on('change',function(){
        $scope.filtro_Mod();
    })*/
    $scope.activarModalInsertar=function(val){
        $scope.filtro_Mod();
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
            $('#titulo').append('<h4>Crear Nuevo Usuario</h4>');
            $scope.tipo="nuevo";
            $('select').material_select('update');
        }
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

    $scope.filtros=function(){
        var val=$('#servidores').val();
        if(val== undefined){
            val="";
        }
        $.ajax({
            url:"responsables/filtros",
            dataType:"json",
            type:"GET",
            data:{
                'filtro':val,
            },
            success: function(data){
                $('#BD').empty();
            if (data.status) {
                $('#BD').append('<option value="" disabled selected>Base de datos</option>');
                if(val == ""){
                    for(ip in data.data){
                        $('#servidores').append('<option value="'+data.data[ip].servidor+'">'+data.data[ip].servidor+'</option>');
                    }
                }else{
                    for(ip in data.data){
                        if(data.data[ip].base_de_datos){
                            $('#BD').append('<option value="'+data.data[ip].id_base_de_datos+'">'+data.data[ip].base_de_datos+'</option>');
                        }
                    }
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
            url:"responsables/detalle",
            dataType:"json",
            type:"GET",
            data:{
                v_id_api:val,
            },
            success: function(data){
                if (data.status) {
                    $('#titulo').empty();
                    $('#nombre_api').val(data.data[0].nombre);
                    $('#prefijo').val(data.data[0].prefijo);
                    $('#descripcion').val(data.data[0].descripcion);
                    setTimeout(function(){$('#servidormod').val("10.0.0.1")},400);
                    $scope.filtro_Mod(data.data[0].id_base_de_datos);
                    $('#titulo').append('<h4>Editar Api</h4>');
                    $scope.tipo="editar";
                    $('select').material_select('update');
                }else{
                    console.log(data.status);
                }
            }
        });
    }
    $scope.correo=function(){
        $.ajax({
            url:"responsables/mail",
            dataType:"json",
            type:"POST",
            data:{
                correo:$('#email').val(),
                pass:$('#psw').val(),
                nom:$('#nombre_res').val(),
            },
            success: function(data){
                if (data.status) {
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
                url:"responsables/eliminar",
                dataType:"json",
                type:"POST",
                data:{
                    v_id_login:usuario[0].id_responsable,
                    v_id_responsableS:val,
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
        console.log($('#msn').val());
        if($scope.tipo == "nuevo"){
            $.ajax({
                url:"responsables/nuevo",
                dataType:"json",
                type:"POST",
                data:{
                    v_id_login:usuario[0].id_responsable,
                    v_usuario:$('#email').val(),
                    v_password:$('#psw').val(),
                    v_nombre:$('#nombre_res').val(),
                    v_apellido_paterno:$('#ape_pa').val(),
                    v_apellido_materno:$('#ape_ma').val(),
                    v_nick:$('#Usuario').val(),
                    v_id_rol:$('#Area_mod').val(),
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
                            $scope.correo();
                            $scope.listar_apis();
                        });
                    }else{
                        console.log(data.status);
                    }
                }
            });
        }else if($scope.tipo == "editar"){
            $.ajax({
                url:"responsables/modificar",
                dataType:"json",
                type:"POST",
                data:{
                    v_id_login:usuario[0].id_responsable,
                    v_id_api:$scope.editar,
                    v_nombre:$('#nombre_api').val(),
                    v_prefijo:$('#prefijo').val() ,
                    v_id_base_de_datos:$('#basemod').val(),
                    v_descripcion:$('#descripcion').val(),
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

    $scope.listar_apis();

});
    //TERMINA BUSCADOR
