
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
                        if($('#txt_buscador').val()==""){
                            setTimeout(function(){$('input.col.s12.tt-hint').val('')},100);
                        }
                        $scope.nod = false;
                    }
                    if(data==""){
                        $scope.ocultar=true;
                        $scope.pag_total=1; 
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
            $('#Usuario').val("");
            $('#nombre_res').val("");
            $('#ape_pa').val("");
            $('#ape_ma').val("");
            $('#Area_mod').val("0");
            $('#email').val("");
            $('#password').val("");
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
                v_id_responsables:val,
            },
            success: function(data){
                if (data.status) {
                    $('#titulo').empty();
                    $('#Usuario').val(data.data[0].nick);
                    $('#nombre_res').val(data.data[0].nombre);
                    $('#ape_pa').val(data.data[0].apellido_paterno);
                    $('#ape_ma').val(data.data[0].apellido_materno);
                    $('#Area_mod').val(data.data[0].id_rol);
                    $('#email').val(data.data[0].usuario);
                    $('#email').attr('disabled',"disabled");
                    $('#titulo').append('<h4>Activar Usuario</h4>');
                    $scope.tipo="editar";
                    $('select').material_select('update');
                }else{
                    swal("Alerta",data.data,"warning");
                }
            }
        });
    }
    $scope.correo=function(val){
        $.ajax({
            url:"responsables/mail",
            dataType:"json",
            type:"POST",
            data:{
                correo:$('#email').val(),
                pass:val,
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
                        swal('Alerta',data.data,"warning");
                    }
                }
            });
        });
    }
    $scope.nuevo=function(){
        if($scope.tipo == "nuevo"){
            if($('#email').val()=="" || $('#nombre_res').val()=="" || $('#ape_pa').val()=="" || $('#ape_ma').val()=="" || $('#Usuario').val()=="" || $('#Area_mod').val()==""){
                swal('Alerta',"Completar todos los campos","warning");
            }else{
                var pass=Math.floor((Math.random() * 1000000) + 1);
                $.ajax({
                    url:"responsables/nuevo",
                    dataType:"json",
                    type:"POST",
                    data:{
                        v_id_login:usuario[0].id_responsable,
                        v_usuario:$('#email').val(),
                        v_password:pass,
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
                                $scope.correo(pass);
                                $scope.listar_apis();
                            });
                        }else{
                            swal('Alerta',data.data,"warning");
                        }
                    }
                });

            }
        }else if($scope.tipo == "editar"){
            if($('#email').val()=="" || $('#nombre_res').val()=="" || $('#ape_pa').val()=="" || $('#ape_ma').val()=="" || $('#Usuario').val()=="" || $('#Area_mod').val()==""){
                swal('Alerta',"Completar todos los campos","warning");
            }else{
                var pass=Math.floor((Math.random() * 1000000) + 1);
                $.ajax({
                    url:"responsables/nuevo",
                    dataType:"json",
                    type:"POST",
                    data:{
                        v_id_login:usuario[0].id_responsable,
                        v_usuario:$('#email').val(),
                        v_password:pass,
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
                                text: "Se activo usuario correctamente!!",
                                type: 'success',
                                showCancelButton: false,
                                confirmButtonColor: "#DD6B55",
                                confirmButtonText: "Aceptar",
                                closeOnConfirm: true
                            },
                            function(){
                                $scope.correo(pass);
                                $scope.listar_apis();
                            });
                        }else{
                            swal('Alerta',data.data,"warning");
                        }
                    }
                });

            }
        }
    }

    $scope.listar_apis();

});
    //TERMINA BUSCADOR
