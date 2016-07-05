
    var url = window.location.href;
    id_puesto = url.substring(url.lastIndexOf('/') + 1);

    $('#folio').prop('disabled','disabled');
    $('#dias').prop('disabled','disabled');
    $('#tianguis').prop('disabled','disabled');
    $('#ubicacion').prop('disabled','disabled');
    $('#calle').prop('disabled','disabled');
    $('#calle2').prop('disabled','disabled');
    var giro="";
    var zona="";
    var linea="";
    var situacion_1="";
    var administrador="";
    var id_tianguis="";
    $(document).ready(function(){
        $.ajax({
            url: "/llenar_info",
            type: "GET",
            dataType: "json",
            cache: true,
            data: {
                'id_puesto': id_puesto,
            },
            success: function (data) {
                if (data.status)
                {
                    id_tianguis=data.data[0].id_cat_tianguis;
                    var suplente1=data.data[0].nombre_s1+' '+data.data[0].apellido_paterno_s1+' '+data.data[0].apellido_materno_s1;
                    var suplente2=data.data[0].nombre_s2+' '+data.data[0].apellido_paterno_s2+' '+data.data[0].apellido_materno_s2;
                    var permisionario=data.data[0].nombre+' '+data.data[0].apellido_paterno+' '+data.data[0].apellido_materno;

                    if(data.data[0].ubicacion.split(',').length == 2){
                        var ubicacion=data.data[0].ubicacion.split(',')[0];
                        var calle1=data.data[0].ubicacion.split(',')[1];
                        var calle2=data.data[0].ubicacion.split(',')[1].split('Y')[1];
                    }else{
                        var ubicacion=data.data[0].ubicacion.split(',')[0];
                        var calle1=data.data[0].ubicacion.split(',')[1];
                        var calle2="";
                        for(var x=2; x< data.data[0].ubicacion.split(',').length ; x++){
                            calle2 += data.data[0].ubicacion.split(',')[x];
                        }
                    }
                    $('#folio').prop('value',data.data[0].folio);
                    $('select[name=dias]').val(data.data[0].dia);
                    $('#tianguis').prop('value',data.data[0].nombre_tianguis);
                    $('select[name=permisionario]').append('<option value="'+permisionario+'">'+permisionario+'</option>');
                    $('select[name=permisionario]').val(permisionario);
                    linea=data.data[0].id_cat_linea;
                    zona=data.data[0].id_cat_zona;
                    $('#inicia').prop('value',data.data[0].inicia);
                    $('select[name=ubicacion]').append('<option value="'+ubicacion+'">'+ubicacion+'</option>');
                    $('select[name=ubicacion]').val(ubicacion);
                    $('#termina').prop('value',data.data[0].termina);
                    $('#longitud').prop('value',data.data[0].longitud);
                    $('#longitud').append(data.data[0].longitud+'m');
                    $('select[name=calle]').append('<option value="'+calle1+'">'+calle1+'</option>');
                    $('select[name=calle]').val(calle1);
                    $('select[name=calle2]').append('<option value="'+calle2+'">'+calle2+'</option>');
                    $('select[name=calle2]').val(calle2);
                    giro=data.data[0].id_cat_giro;
                    situacion_1=data.data[0].situacion;
                    administrador=5;
                    $('#suplente1').prop('value',suplente1);
                    //$('#descuento').val();
                    $('#suplente2').prop('value',suplente2);
                    //$('#motivo').val();
                    //$('#administrador').val();
                    $('#tarjeton').prop('value',data.data[0].tarjeton);
                    if(data.data[0].activo=="S"){
                        $("#activo").click();
                    }

                    $('#comentario').val(data.data[0].observaciones);
                    traer_linea_zona();
                    traer_giro();
                    traer_situacion();
                    traer_administrador();
                }
                else
                {
                    console.log(data.data[0].mensaje);
                }
            }
        });

    function traer_giro(){
        $.ajax({
            url: "/cat_giro",
            type: "GET",
            dataType: "json",
            cache: true,
            success: function (data) {
                if (data.status)
                {
                    for(i in data.data){
                        $('select[name=giro]').append('<option value="'+data.data[i].id_cat_giro+'">'+data.data[i].nombre+'</option>');
                    }
                    $('select[name=giro]').val(giro);
                }
                else
                {
                    console.log(data.data[0].mensaje);
                }
            }
        });
    }
    function traer_situacion(){
        $.ajax({
            url: "/cat_situacion",
            type: "GET",
            dataType: "json",
            cache: true,
            success: function (data) {
                if (data.status)
                {
                    for(i in data.data){
                        $('select[name=situacion]').append('<option value="'+data.data[i].situacion+'">'+data.data[i].detalle+'</option>');
                    }
                    $('select[name=situacion]').val(situacion_1);
                }
                else
                {
                    console.log(data.data[0].mensaje);
                }
            }
        });
    }
    function traer_administrador(){
        $.ajax({
            url: "/cat_administrador",
            type: "GET",
            dataType: "json",
            cache: true,
            success: function (data) {
                if (data.status)
                {
                    for(i in data.data){
                        $('select[name=administrador]').append('<option value="'+data.data[i].id_administrador+'">'+data.data[i].nombre_completo+'</option>');
                    }
                    $('select[name=administrador]').val(administrador);
                }
                else
                {
                    console.log(data.data[0].mensaje);
                }
            }
        });
    }

    function traer_linea_zona(id_zona,id_linea){
        if(id_zona == null){
            id_zona=0;
        }
        if(id_linea == null){
            id_linea=0;
        }
        $.ajax({
            url: "/cat_zona_linea",
            type: "GET",
            dataType: "json",
            cache: true,
            data: {
                'id_tianguis': id_tianguis,
                'id_zona':id_zona,
                'id_linea':id_linea,
            },
            success: function (data) {
                if (data.status){
                    var zona_temp="";
                    if(id_zona == 0 && id_linea == 0){
                        for(i in data.data){
                            $('select[name=linea]').append('<option value="'+data.data[i].id_cat_linea+'">'+data.data[i].linea+'</option>');
                            if(zona_temp != data.data[i].zona){
                                $('select[name=zona]').append('<option value="'+data.data[i].id_cat_zona+'">'+data.data[i].zona+'</option>');
                                zona_temp=data.data[i].zona;
                            }
                        }
                        $('select[name=linea]').val(linea);
                        $('select[name=zona]').val(zona);
                    }else if(id_zona == 0 && id_linea != 0){
                        $('#ubicacion').empty();
                        $('#calle').empty();
                        $('#calle2').empty();

                        if(data.data[0].ubicacion.split(',').length == 2){
                            var ubicacion=data.data[0].ubicacion.split(',')[0];
                            var calle1=data.data[0].ubicacion.split(',')[1];
                            var calle2=data.data[0].ubicacion.split(',')[1].split('Y')[1];
                        }else{
                            var ubicacion=data.data[0].ubicacion.split(',')[0];
                            var calle1=data.data[0].ubicacion.split(',')[1];
                            var calle2="";
                            for(var x=2; x< data.data[0].ubicacion.split(',').length ; x++){
                                calle2 += data.data[0].ubicacion.split(',')[x];
                            }
                        }

                        $('select[name=ubicacion]').append('<option value="'+ubicacion+'">'+ubicacion+'</option>');
                        $('select[name=calle]').append('<option value="'+calle1+'">'+calle1+'</option>');
                        $('select[name=calle2]').append('<option value="'+calle2+'">'+calle2+'</option>');

                        $('select[name=ubicacion]').val(ubicacion);
                        $('select[name=calle]').val(calle1);
                        $('select[name=calle2]').val(calle2);
                    }else{
                        $('#linea').empty();
                        $('select[name=linea]').append('<option value="0">linea</option>');
                        for(i in data.data){
                            $('select[name=linea]').append('<option value="'+data.data[i].id_cat_linea+'">'+data.data[i].linea+'</option>');
                        }

                        $('select[name=linea]').val(0);
                    }

                }
                else
                {
                    console.log(data.data[0].mensaje);
                }
            }
        });
    }


    $('#zona').change(function(){
        traer_linea_zona($('#zona').val(),0);
    });
    $('#linea').change(function(){
        traer_linea_zona(0,$('#linea').val());
    });
    $('#inica').focusout(function(){
        $('#termina').focus();
    });

    $('#termina').focusout(function(){
        var inicia = $('#inicia').val();
        var termina = $('#termina').val();

        var cont = termina.length;
        var count=0;
        for(var x=0; x<cont;x++){
            if(termina.split('')[x]=="."){
                count++;
            }
        }
        if(count >=2 ){
            swal("¡Atención!", "Formato no valido", "warning");
            $('#termina').prop('value',0);
        }else{
            if(inicia > termina){
                swal("¡Atención!", "Inicia no puede ser mayor que termina", "warning");
            }else{
                var operacion= termina-inicia;
                $('#longitud').empty();
                $('#longitud').append(operacion.toFixed(2)+'m');
                $('#longitud').prop('value',operacion.toFixed(2));
            }
        }
    });

    $('#inicia').focusout(function(){
        var inicia = $('#inicia').val();
        var termina = $('#termina').val();

        var cont = inicia.length;
        var count=0;
        for(var x=0; x<cont;x++){
            if(inicia.split('')[x]=="."){
                count++;
            }
        }
        if(count >=2 ){
            swal("¡Atención!", "Formato no valido", "warning");
            $('#inicia').prop('value',0);
        }else{
            if(inicia > termina){
                swal("¡Atención!", "Inicia no puede ser mayor que termina", "warning");
            }else{
                var operacion= termina-inicia;
                $('#longitud').empty();
                $('#longitud').append(operacion.toFixed(2)+'m');
                $('#longitud').prop('value',operacion.toFixed(2));
            }
        }
    });
});

    function validarletras(e){
       key = e.keyCode || e.which;
       tecla = String.fromCharCode(key).toLowerCase();
       letras = " abcdefghijklmnñopqrstuvwxyz";
       especiales = "8-37-39-46-32";

       tecla_especial = false
       for(var i in especiales){
            if(key == especiales[i]){
                tecla_especial = true;
                break;
            }
        }

        if(letras.indexOf(tecla)==-1 && !tecla_especial){
            return false;
        }
    }

    function numeric(e){
       key = e.keyCode || e.which;
       tecla = String.fromCharCode(key).toLowerCase();
       letras = "0123456789";
       especiales = "8-37-39-46";

       tecla_especial = false
       for(var i in especiales){
            if(key == especiales[i]){
                tecla_especial = true;
                break;
            }
        }

        if(letras.indexOf(tecla)==-1 && !tecla_especial){
            return false;
        }
    }

    function validar(evt)
    {
    var nav4 = window.Event ? true : false;
    var key = nav4 ? evt.which : evt.keyCode;
    return (key <= 13 || key==46 || (key >= 38 && key <= 57));

    }

function cancelar(){
    swal({
      title: "¡Seguro!",
      text: "No se guardarán cambios",
      type: "warning",
      showCancelButton: false,
      confirmButtonColor: "#3A9C95",
      confirmButtonText: "Aceptar",
      closeOnConfirm: false
    },
    function(){
        window.location='/listado_tianguis'
    });
}


function guardar(){
    var folio = $('#folio').val();
    var dia = $('#dias').val();
    var tianguis = $('#tianguis').val();
    var permisionario = $('#permisionario').val();
    if(permisionario.split(' ').length > 4){
        var nombre1=permisionario.split(' ')[0]+' '+permisionario.split(' ')[1];
        var apellido_pa=permisionario.split(' ')[2];
        var apellido_ma="";
        for(var x=3;x<permisionario.split(' ').length;x++){
            apellido_ma+=permisionario.split(' ')[x]+"";
        }
    }else if(permisionario.split(' ').length == 4){
        var nombre1=permisionario.split(' ')[0]+' '+permisionario.split(' ')[1];
        var apellido_pa=permisionario.split(' ')[2];
        var apellido_ma=permisionario.split(' ')[3];
    }else{
        var nombre1=permisionario.split(' ')[0];
        var apellido_pa=permisionario.split(' ')[1];
        var apellido_ma=permisionario.split(' ')[2];
    }

    var suplente_1 = $('#suplente1').val();
    if(suplente_1.split(' ').length > 4){
        var nombre_s1=suplente_1.split(' ')[0]+' '+suplente_1.split(' ')[1];
        var apellido_pa_s1=suplente_1.split(' ')[2];
        var apellido_ma_s1="";
        for(var x=3;x<suplente_1.split(' ').length;x++){
            apellido_ma_s1+=suplente_1.split(' ')[x]+" ";
        }
    }else if(suplente_1.split(' ').length == 4){
        var nombre_s1=suplente_1.split(' ')[0]+' '+suplente_1.split(' ')[1];
        var apellido_pa_s1=suplente_1.split(' ')[2];
        var apellido_ma_s1=suplente_1.split(' ')[3];
    }else{
        var nombre_s1=suplente_1.split(' ')[0];
        var apellido_pa_s1=suplente_1.split(' ')[1];
        var apellido_ma_s1=suplente_1.split(' ')[2];
    }

    var suplente_2 = $('#suplente2').val();
    if(suplente_2.split(' ').length > 4){
        var nombre_s2=suplente_2.split(' ')[0]+' '+suplente_2.split(' ')[1];
        var apellido_pa_s2=suplente_2.split(' ')[2];
        var apellido_ma_s2="";
        for(var x=3;x<suplente_2.split(' ').length;x++){
            apellido_ma_s2+=suplente_2.split(' ')[x]+"";
        }
    }else if(suplente_2.split(' ').length == 4){
        var nombre_s2=suplente_2.split(' ')[0]+' '+suplente_2.split(' ')[1];
        var apellido_pa_s2=suplente_2.split(' ')[2];
        var apellido_ma_s2=suplente_2.split(' ')[3];
    }else{
        var nombre_s2=suplente_2.split(' ')[0];
        var apellido_pa_s2=suplente_2.split(' ')[1];
        var apellido_ma_s2=suplente_2.split(' ')[2];
    }

    var linea = $('#linea').val();
    var zona = $('#zona').val();
    var inicia = $('#inicia').val();
    var ubicacion = $('#ubicacion').val()+" "+$('#calle').val()+$('#calle2').val() ;
    var termina = $('#termina').val();
    var longitud = $('#longitud').val();
    var giro = $('#Giro').val();
    var situacion = $('#Situacion').val();
    //$('#descuento').val();
    //$('#motivo').val();
    var administrador = $('#administrador').val();
    var tarjeton = $('#tarjeton').val();
    if( $('#activo').attr('checked') ) {
        var activo='S';
    }else{
        var activo='N';
    }
    var comentario = $('#comentario').val();
    if (folio.length < 1 || tianguis.length < 1 || suplente_1.length < 1 || suplente_2.length < 1 || comentario.length < 1 || permisionario == 0 || linea == 0 || zona == 0 || inicia.length < 1 || ubicacion == 0 || termina.length < 1 || giro == 0 || situacion == 0 || tarjeton.length < 1 || administrador == 0)
        {
            swal("¡Atención!", "Completa todos los campos", "warning");
        }else{
            $.ajax({
                url: "/guardar",
                type: "POST",
                dataType: "json",
                cache: true,
                data: {
                    'id_puesto':id_puesto,
                    'id_cat_tianguis':id_tianguis,
                    'id_cat_zona':zona,
                    'id_cat_linea':linea,
                    'id_cat_giro':giro,
                    'situacion':situacion,
                    'nombre':nombre1,
                    'apellido_paterno':apellido_pa,
                    'apellido_materno':apellido_ma,
                    'inicia':$('#inicia').val(),
                    'termina':$('#termina').val(),
                    'observaciones':$('#comentario').val(),
                    'nombre_s1':nombre_s1,
                    'apellido_paterno_s1':apellido_pa_s1,
                    'apellido_materno_s1':apellido_ma_s1,
                    'nombre_s2':nombre_s2,
                    'apellido_paterno_s2':apellido_pa_s2,
                    'apellido_materno_s2':apellido_ma_s2,
                    'tarjeton':$('#tarjeton').val(),
                    'activo':activo,

                },
                success: function (data) {
                    if (data.status)
                    {
                        swal({
                          title: "¡Correcto!",
                          text: "La informacion se guardo correctamente",
                          type: "success",
                          showCancelButton: false,
                          confirmButtonColor: "#3A9C95",
                          confirmButtonText: "Aceptar",
                          closeOnConfirm: false
                        },
                        function(){
                            window.location='/listado_tianguis'
                        });
                    }
                    else
                    {
                        console.log(data.data[0].mensaje);
                    }
                }
            });
        }
}
