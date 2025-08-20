
let tbodyPersonas = document.getElementById("tbodyPersonas");
let listaPersonas = null;
let formularioCrearUsuario = document.getElementById("formularioCrearUsuario");

formularioCrearUsuario.addEventListener("submit", function (event) {
	event.preventDefault(); 
	registrarUsuario();
});

function base_url(texto){
	return "http://localhost/26-ProyectoMVC-Origin/index.php/"+texto;
}

function registrarUsuario() {
	// console.log("realizando peticion a la API para registrar usuario. ");

	let datos = new FormData(formularioCrearUsuario);
	let configuracion = {
							method: "POST",
							headers: {"Accept": "application/json"},
							body: datos,
	                    };
	fetch(base_url('admin/Usuario/insertarUsuario'), configuracion)
	.then(resp => resp.json())
	.then(data => {
		console.log("se recibe de la API insertar");
		console.log(data);
		if (data.status && data.message=="OK##INSERT") {
			Swal.fire({
				title: 'USUARIO INSERTADO',
				text: "SE A CREADO CON EXITO, PUEDE INGRESAR AL SISTEMA", 
				icon: 'success',
				confirmButtonText: 'ENTENDIDO',
				confirmButtonColor: '#3085d6',
			});
			document.getElementById("campo_cedula").value ="";
			document.getElementById("campo_nombre").value ="";
			document.getElementById("campo_apellido").value ="";
			document.getElementById("campo_telefono").value ="";
			document.getElementById("campo_direccion").value ="";
			document.getElementById("campo_cedula").value ="";
			document.getElementById("campo_tipo").value ="";
			cargarPersonas();
		}
		if (data.status && data.message=="ERROR##DUPLICADO") {
			Swal.fire({
				title: 'ERROR DUPLICADO',
				text: "ES POSIBLE QUE LA CEDULA O EL EMAIL ESTEN REGISTRADOS",
				icon: 'error',
				confirmButtonText: 'ENTENDIDO',
				confirmButtonColor: '#d33',
			});
		}
		if (data.status && data.message=="ERROR##DATOS##VACIOS") {
			Swal.fire({
				title: 'ERROR DATOS VACIOS',
				text: "",
				icon: 'error',
				confirmButtonText: 'ENTENDIDO',
				confirmButtonColor: '#d33',
			});
		}
	});
}

/*function cargarPersonas(){
	fetch( base_url("admin/Usuario/getListaUsuarios") )
	.then( res => res.json() )
	.then( data => {
		
		listaPersonas = data;
		tbodyPersonas.innerHTML = "";
		for (var i = 0; i < data.length; i++) {
			html_tr = `
						<tr>
				            <td>${ data[i].cedula }</td>
				            <td>${ data[i].nombres }</td>
				            <td>${ data[i].apellidos }</td>
				            <td>${ data[i].telefono }</td>
				            <td>${ data[i].direccion }</td>
				            <td>${ data[i].email }</td>
				            <td>
				            	<button class="btn btn-primary" onclick="abrirModalEditar(${i})" >
				            		Editar
				            	</button>
				            	<button class="btn btn-danger" onclick="confirmarEliminacion(${i})">
				            		Eliminar
				            	</button>
				            </td>
				        </tr>
					  `;
			tbodyPersonas.innerHTML += html_tr;
		}

	});
}*/

function abrirModalEditar(indice){
	console.log( "Abriendo modal para editar a:" );
	console.log( listaPersonas[indice] );
}

function confirmarEliminacion(indice){
	console.log( "Abriendo confirmacion para eliminar a:" );
	console.log( listaPersonas[indice] );
}


cargarPersonas();
