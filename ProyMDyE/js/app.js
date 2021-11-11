const formularioProductos = document.querySelector('#producto'),
        listadoProductos = document.querySelector('#listado-productos tbody'), 
        inputBuscador = document.querySelector('#buscar');

eventListeners();

function eventListeners() {
    formularioProductos.addEventListener('submit', leerFormulario);
    // Listener para eliminar el boton
    if(listadoProductos) {
        listadoProductos.addEventListener('click', eliminarProducto);
    }

   // buscador
   inputBuscador.addEventListener('input', buscarProductos);
   
   numeroProductos();
}

function leerFormulario (e) {
    e.preventDefault();
    //console.log(e);
    const idproducto = document.querySelector('#idproducto').value,
    puertoOrigen = document.querySelector('#porigen').value,
    puertoDestino = document.querySelector('#pdestino').value,
    accion = document.querySelector('#accion').value;

    if (idproducto === ""|| puertoOrigen === "" || puertoDestino === "" ) {
        //console.log("Campos incompletos");
        //Texto y clase parámetros
        mostrarNotificacion('Todos los campos son obligatorios','error');
    }
    else {
        //console.log("Campos completos");
        const infoProducto = new FormData();
        infoProducto.append('idproducto', idproducto);
        infoProducto.append('puertoOrigen', puertoOrigen);
        infoProducto.append('puertoDestino', puertoDestino);
        infoProducto.append('accion', accion);
        //console.log(infoProducto);
        if(accion === 'crear'){
            //crear producto
            insertarBD(infoProducto);
        }
        else{ 
            //editar producto
            //Leer id
            const idRegistro = document.querySelector('#id').value;
            infoProducto.append('id', idRegistro);
            actualizarRegistro(infoProducto);
        }
    }
    
}
//Ajax
function insertarBD(datos) {
    //llamado a ajax
    //crear el objeto
    const xhr = new XMLHttpRequest();
    //abrir conexión
    xhr.open('POST', 'inc/modelos/modelos-productos.php', true);//POST Y GET 
    //pasar datos
    xhr.onload = function() {
        if(this.status === 200){
            console.log(xhr.responseText);
            const respuesta = JSON.parse(xhr.responseText);
            //Insertar nuevo producto a la tabla
            const nuevoProducto = document.createElement('tr');
            nuevoProducto.innerHTML = `
            <td>${respuesta.datos.idproducto}</td>
            <td>${respuesta.datos.puertoOrigen}</td>
            <td>${respuesta.datos.puertoDestino}</td>
            `;

            //Crear contenedor para botones
            const contenedorAcciones = document.createElement('td');

            // crear el icono de Editar
            const iconoEditar = document.createElement('i');
            iconoEditar.classList.add('fas', 'fa-pen-square');

            // crea el enlace para editar
            const btnEditar = document.createElement('a');
            btnEditar.appendChild(iconoEditar);
            btnEditar.href = `editar.php?id=${respuesta.datos.id_insertado}`;
            btnEditar.classList.add('btn', 'btn-editar');

               // agregarlo al padre
            contenedorAcciones.appendChild(btnEditar);

               // crear el icono de eliminar
            const iconoEliminar = document.createElement('i');
            iconoEliminar.classList.add('fas', 'fa-trash-alt');

            // crear el boton de eliminar
            const btnEliminar = document.createElement('button');
            btnEliminar.appendChild(iconoEliminar);
            btnEliminar.setAttribute('data-id', respuesta.datos.id_insertado);
            btnEliminar.classList.add('btn', 'btn-borrar');

               // agregarlo al padre
            contenedorAcciones.appendChild(btnEliminar);

               // Agregarlo al tr
            nuevoProducto.appendChild(contenedorAcciones);

               // agregarlo con los productos
            listadoProductos.appendChild(nuevoProducto);       
               
            // Resetear el formulario
            document.querySelector('form').reset();

               // Mostrar la notificacion
            //mostrarNotificacion('Producto Creado Correctamente', 'correcto');
            mostrarNotificacion('Producto creado exitosamente', 'correcto');

            // Actualizar el número
            numeroProductos();
        }
    }
    //enviar datos
    xhr.send(datos);
}
function actualizarRegistro(datos) {
    //Crear objeto
    const xhr = new XMLHttpRequest();
    //Abrir conexión
    xhr.open('POST', 'inc/modelos/modelos-productos.php', true);
    //Leer respuesta
    xhr.onload = function() {
        if(this.status === 200) {
            console.log(xhr.responseText);
            const respuesta = JSON.parse(xhr.responseText);

            if(respuesta.respuesta === 'correcto'){
                // mostrar notificación de Correcto
                mostrarNotificacion('Contacto editado correctamente', 'correcto');
            } else {
                // hubo un error
                mostrarNotificacion('Hubo un error...', 'error');
            }
            // Después de 4 segundos redireccionar
            setTimeout(() => {
                window.location.href = 'index.php';
            }, 4000);
        }
   }
    //Enviar petición
    xhr.send(datos);
}
//Eliminar producto
function eliminarProducto(e) {
    if(e.target.parentElement.classList.contains('btn-borrar')) {
        //Tomar id del producto a eliminar
        const id = e.target.parentElement.getAttribute('data-id');
        //console.log(id);
        const respuesta = confirm('¿Estás seguro?');
        if(respuesta) {
            //console.log('Si');
            //Llamado Ajax
            //Crear objeto
            const xhr = new XMLHttpRequest();
            //Abrir conexión
            xhr.open('GET', `inc/modelos/modelos-productos.php?id=${id}&accion=borrar`, true);
            //xhr.open('GET', `inc/modelos/modelo-contactos.php?id=${id}&accion=borrar`, true);
            //Leer respuesta
            xhr.onload = function() {
                if(this.status === 200) {
                    
                    //const resultado = JSON.parse(xhr.responseText);
                    //Aquí hay un error
                    console.log(xhr.responseText)
                    const resultado = JSON.parse(xhr.responseText);
                    console.log(xhr.responseText)
                    console.log(resultado);
                    if(resultado.respuesta == 'correcto') {
                          // Eliminar el registro del DOM
                          console.log(e.target.parentElement.parentElement.parentElement);
                          e.target.parentElement.parentElement.parentElement.remove();
                          // mostrar Notificación
                          mostrarNotificacion('Producto eliminado', 'correcto');

                          // Actualizar el número
                          numeroContactos();
                    } else {
                          // Mostramos una notificacion
                          mostrarNotificacion('Hubo un error...', 'error' );
                     }

                }
           }
            //Enviar petición
            xhr.send();
        }
    }
}
//Notificación
function mostrarNotificacion(mensaje, clase) {
     const notificacion = document.createElement('div');
     notificacion.classList.add(clase, 'notificacion', 'sombra');
     notificacion.textContent = mensaje;

     formularioProductos.insertBefore(notificacion, document.querySelector('form legend'));
     //Mostrar y ocultar
     setTimeout(() => {
        notificacion.classList.add('visible');
        setTimeout(() => {
            notificacion.classList.remove('visible');
            setTimeout(() => {
                notificacion.remove();
            }, 500)
        }, 3000);
    
    }, 100);
}

function buscarProductos(e) {
    const expresion = new RegExp(e.target.value, "i" );
          registros = document.querySelectorAll('tbody tr');

          registros.forEach(registro => {
            registro.style.display = 'none';

               /*if(registro.childNodes[1].textContent.replace(/\s/g, " ").search(expresion) != -1 ){
                    registro.style.display = 'table-row';
               }*/
            if (registro.childNodes[1].textContent.replace(/\s/g, " ").search(expresion) != -1 ||
            registro.childNodes[3].textContent.replace(/\s/g, " ").search(expresion) != -1 ||
            registro.childNodes[5].textContent.replace(/\s/g, " ").search(expresion) != -1) {
                registro.style.display = 'table-row';
            }
            numeroProductos();
        })
}
//Muestra el número de productos
function numeroProductos() {
    const totalProductos = document.querySelectorAll('tbody tr'),
        contenedorNumero = document.querySelector('.total-productos span');
    //console.log(totalProductos.length);
    let total = 0;
    totalProductos.forEach(producto => {
        //console.log(producto.style.display);
        if(producto.style.display === '' || producto.style.display === 'table-row' ) {
            total++;
        }
    });

    //console.log(total);
    contenedorNumero.textContent = total;
}
/*function ShPath() {
    const graph = {
        A: {B: 567037},
        B: {A:567037, C: 566529, D:409730},
        C: {B: 566529},
        D: {B:409730, E:476762},
        E: {D:476762, G:265277, H:275028, F:555422},
        F: {E:555422, J:516005, T:288834},
        G: {E:265277, L:686199},
        H: {E:275028, I:650087, J:692619},
        I: {H:650087, R:653610, J:397510},
        J: {F:516005, T:617767, H:692619, I:397510, L:697422, K:733963},
        K: {J:733963, L:449313, P:542097, Q:419728, M:527865},
        L: {J:697422, G:686199, K:449313, M:454552},
        M: {L:454552, K:527865, O:482442},
        N: {O:424932},
        O: {M:482442, N:424932, P:486424},
        P: {O:486424, K:542097},
        Q: {K:419728},
        R: {I:653610, S:658998},
        S: {R:658998},
        T: {F:288834,J:617767}
      };
}*/