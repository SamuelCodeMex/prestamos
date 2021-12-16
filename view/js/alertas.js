
/*
const formulariosAjax = document.querySelectorAll(".formularioAjax");

function enviarFormularioAjax(e){
  e.preventDefault();
  console.log("enviarFormularioAjax");
  let data = new FormData(this);
  let method = this.getAttribute("method");
  let action = this.getAttribute("action");
  let tipo = this.getAttribute("data-form");
  console.log('data::'+JSON.stringify(data));
  console.log('met::'+method);
  console.log('action::'+action);
  console.log('tipo::'+tipo);
  let encabezados = new Headers();
  let config = {
      method:method,
      headers: encabezados,
      mode:'cors',
      cache: 'no-cahe',
      body: data
  }
  let texto_alerta;
  if(tipo === 'save'){
      texto_alerta = "Los datos quedarán guardados en el sistema.";
  }else if(tipo === 'delete'){
    texto_alerta = "Los datos serán eliminados completamente del sistema.";
  }else if(tipo === 'update'){
    texto_alerta = "Los datos del sistema serán actualizados.";
  }else if(tipo === 'search'){
    texto_alerta = "¿Se eliminará el término de búsqueda y tendrás que escribir uno nuevo ";
  }else if(tipo === 'loadn'){
    texto_alerta = "¿Desea remover los datos seleccionados para préstamos o reservaciones?";
  }else{
    texto_alerta = "¿Quieres realizar la operación solicitada?";
  }
  Swal.fire({
    type: 'question',
    title: '¿Estás seguro?',
    text: texto_alerta,
    confirmButtonText: 'Aceptar',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonText: 'Aceptar',
    cancelButtonColor: '#d33',
  }).then((result) => {
    if (result.isConfirmed) {
       console.log('respuesta de swal');
       fetch(action,config)
       .then(respuesta => respuesta.json())
       .then(respuesta => {
           console.log('Respuesta Servidor::'.respuesta);
           return alertasAjax(respuesta);
       })
    }
  })
}

formulariosAjax.forEach(formularios => {
    formularios.addEventListener("submit",enviarFormularioAjax);
});

function alertasAjax(alerta){
    if(alerta.alerta == "simple"){
        Swal.fire({
            type: alerta.tipo,
            title: alerta.titulo,
            text: alerta.texto,
            confirmButtonText: alerta.aceptar
          });
    }else if(alerta.alerta === "recargar"){
        Swal.fire({
            type: alerta.tipo,
            title: alerta.titulo,
            text: alerta.texto,
            confirmButtonText: alerta.aceptar,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
          }).then((result) => {
            if (result.isConfirmed) {
               location.reload();
            }
          })
    }else if(alerta.alerta === "limpiar" ){
        Swal.fire({
            type: alerta.tipo,
            title: alerta.titulo,
            text: alerta.texto,
            confirmButtonText: alerta.aceptar,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
          }).then((result) => {
            if (result.isConfirmed) {
               document.querySelector(".formularioAjax").reset();
            }
          })
    }else if(alerta.alerta === "redireccionar"){
        window.location.hre = alerta.url;
    }
}*/
const formularios_ajax = document.querySelectorAll(".formularioAjax");

function enviar_formulario_ajax(e){
	e.preventDefault();

	let data = new FormData(this);
	let method = this.getAttribute("method");
	let action = this.getAttribute("action");
	let tipo = this.getAttribute("data-form");

	let encabezados = new Headers();

	let config = {
		method: method,
		headers: encabezados,
		mode: 'cors',
		cache: 'no-cache',
		body: data
	}

	let texto_alerta;

	if(tipo==="save"){
		texto_alerta="Los datos quedarán guardados en el sistema";
	}else if(tipo==="delete"){
		texto_alerta="Los datos serán eliminados completamente del sistema";
	}else if(tipo==="update"){
		texto_alerta="Los datos del sistema serán actualizados";
	}else if(tipo==="search"){
		texto_alerta="Se eliminará el término de búsqueda y tendrás que escribir uno nuevo";
	}else if(tipo==="loans"){
		texto_alerta="Desea remover los datos seleccionados para préstamos o reservaciones";
	}else{
		texto_alerta="Quieres realizar la operación solicitada";
	}

	Swal.fire({
		title: '¿Estás seguro?',
		text: texto_alerta,
		type: 'question',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Aceptar',
		cancelButtonText: 'Cancelar'
	}).then((result) => {
		if(result.value){
			fetch(action,config)
			.then(respuesta => respuesta.json())
			.then(respuesta => {
				return alertas_ajax(respuesta);
			});
		}
	});

}

formularios_ajax.forEach(formularios => {
	formularios.addEventListener("submit", enviar_formulario_ajax);
});

function alertas_ajax(alerta){
	if(alerta.Alerta==="simple"){
		Swal.fire({
			title: alerta.Titulo,
			text: alerta.Texto,
			type: alerta.Tipo,
			confirmButtonText: 'Aceptar'
		});
	}else if(alerta.Alerta==="recargar"){
		Swal.fire({
			title: alerta.Titulo,
			text: alerta.Texto,
			type: alerta.Tipo,
			confirmButtonText: 'Aceptar'
		}).then((result) => {
			if(result.value){
				location.reload();
			}
		});
	}else if(alerta.Alerta==="limpiar"){
		Swal.fire({
			title: alerta.Titulo,
			text: alerta.Texto,
			type: alerta.Tipo,
			confirmButtonText: 'Aceptar'
		}).then((result) => {
			if(result.value){
				document.querySelector(".formularioAjax").reset();
			}
		});
	}else if(alerta.Alerta==="redireccionar"){
		window.location.href=alerta.URL;
	}
}

