$(function(){
    login();
})

const login = () => {
    $("#formLogin").submit(function(e){
        e.preventDefault();
        const data = $(this).serialize();
        $.ajax({
            url: 'controller/usuario.php',
            method: 'POST',
            data: data,
            success: function(data){
                
                var response = JSON.parse(data);
                if (response.status == "success") {
                    window.location = response.url;
                }
                if (response.status == "error") {
                    Swal.fire({
                        icon: "error",
                        title: "Lo sentimos",
                        text: response.message          
                      });
                    /*Swal.fire({
                        title: 'Error!',
                        text: response.message,
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    })*/
                }
                
            }
        })
    })
}