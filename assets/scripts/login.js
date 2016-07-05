var usuario;

function login(){
    $.ajax({
        url:"login_controller/postlogin",
        dataType:"json",
        type:"POST",
        data:{
            'user':$('#user').val(),
            'pass':$('#pass').val(),
        },
        success: function(data){
            if (data.status) {
                usuario=data.data;
                localStorage.setItem('log',JSON.stringify(usuario));

                window.location="/api";
            }else{
                swal('Error','Colocar credenciales validas','error')
            }
        }
    });
}
