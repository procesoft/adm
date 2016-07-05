$('#login_username, #login_pass').keypress(function (event) {
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if (keycode == '13') {
        log();
    }
});


function log(){
    usuario=$('#login_username').val();
    pass=$('#login_pass').val();
    $.ajax({
        url: "/login",
        type: "POST",
        dataType: "json",
        cache: true,
        data: {
            'username': usuario,
            'password': pass
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert("Status: " + textStatus);
            alert("Error: " + errorThrown);
        },
        success: function (data) {
            if (data.status)
            {
                window.location.href ='listado_tianguis';
            }
            else
            {
                if(data.data[0].tipo=='U'){
                    $(".alert").show();
                    $("#texto").html("Usuario no existe");
                }else{
                    $(".alert").show();
                    $("#texto").html("Usuario o contraseña incorrecto");
                }
            }
        }
    });
}
