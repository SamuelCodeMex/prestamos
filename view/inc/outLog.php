<script>
    let btn_salir = document.querySelector(".btn-exit-sys");
    btn_salir.addEventListener('click',function(e){
        e.preventDefault();
        Swal.fire({
			title: '¿Quieres salir del sistema?',
			text: 'La sesión actual se cerrará y saldrás del sistema',
			type: 'question',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Si, Salir',
			cancelButtonText: 'No, Cancelar'
		}).then((result) => {
			if (result.value) {
                //window.location="index.html";
                let url = "<?php echo SERVERURL;?>ajax/loginAjax.php";
                let token = "<?php echo $lo->encryption($_SESSION['hmn_token']);?>"; //seguimo en plantilla
                let usuario = "<?php echo $lo->encryption($_SESSION['hmn_usuario']);?>";
                let data = new FormData();
                data.append("token",token);
                data.append("usuario",usuario);
                fetch(url,{
                    method: 'POST',
                    body: data
                })
                .then(respuesta => respuesta.json())
                .then(respuesta => {
                    return alertas_ajax(respuesta);
                });   
			}
            
		});
    });
</script>