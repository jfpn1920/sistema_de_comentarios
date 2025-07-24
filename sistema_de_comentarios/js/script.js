//-----------------------------------------//
//--|funcionalidad_sistema_de_comentario|--//
//-----------------------------------------//
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('form-comentario');
    const nombreInput = document.getElementById('nombre');
    const mensajeInput = document.getElementById('mensaje');
    const listaComentarios = document.getElementById('lista-comentarios');
    //------------------------------------------------//
    //--|cargar_y_envio_de_datos_de_los_comentarios|--//
    //------------------------------------------------//
    cargarComentarios();
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        const nombre = nombreInput.value.trim();
        const mensaje = mensajeInput.value.trim();
        if (nombre === '' || mensaje === '') {
            alert('Por favor, completa todos los campos.');
            return;
        }
        fetch('../php/guardar_comentario.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `nombre=${encodeURIComponent(nombre)}&mensaje=${encodeURIComponent(mensaje)}`
        })
        .then(response => response.text())
        .then(data => {
            console.log('Respuesta del servidor:', data);
            cargarComentarios();
            form.reset();
        })
        .catch(error => {
            console.error('Error al enviar el comentario:', error);
        });
    });
    //------------------------------------------------//
    //--|cargar_comentarios_si_existen_o_no_existen|--//
    //------------------------------------------------//
    async function cargarComentarios() {
        try {
            const response = await fetch('../php/obtener_comentarios.php');
            const contentType = response.headers.get('content-type');
            if (!contentType || !contentType.includes('application/json')) {
                throw new Error('Respuesta no es JSON. Respuesta recibida: ' + await response.text());
            }
            const data = await response.json();
            listaComentarios.innerHTML = '';
            if (data.length === 0) {
                listaComentarios.innerHTML = '<p>No hay comentarios aún.</p>';
                return;
            }
            data.forEach(comentario => {
                const div = document.createElement('div');
                div.classList.add('comentario');
                div.innerHTML = `
                    <strong>${comentario.nombre}</strong>
                    <p>${comentario.mensaje}</p>
                `;
                listaComentarios.appendChild(div);
            });
        } catch (error) {
            console.error('Error al convertir JSON o al procesar la respuesta:', error);
            listaComentarios.innerHTML = '<p>Error al cargar comentarios.</p>';
        }
    }
});