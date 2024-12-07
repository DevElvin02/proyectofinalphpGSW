adocument.addEventListener('DOMContentLoaded', function() {
    const agregarCarritoBtns = document.querySelectorAll('.agregar-carrito');

    agregarCarritoBtns.forEach(btn => {
        btn.addEventListener('click', function(event) {
            event.preventDefault(); // Evitar el comportamiento por defecto del enlace
            Swal.fire({
                title: "¡Buen trabajo!",
                text: "¡Has agregado el producto al carrito!",
                icon: "success"
            });
        });
    });
});


document.querySelector('a[href^="#lista-1"]').addEventListener('click', function(event) {
    event.preventDefault();
    const targetId = this.getAttribute("href");
    const targetElement = document.querySelector(targetId);

    window.scrollTo({
        top: targetElement.offsetTop,
        behavior: "smooth"
    });
});

const carrito = document.getElementById('carrito');
const elemento1 = document.getElementById('lista-1')
const lista = document.querySelector('#lista-carrito tbody');
const vaciarCarrito = document.getElementById('vaciar-carrito');

cargarEventListener();

function cargarEventListener() {
    elemento1.addEventListener('clic', comprarElemento);
    carrito.addEventListener('click', eliminarElemento);
    vaciarCarritoBtn.addEventListener('click', vaciarCarrito);
}

function comprarElemento(e) {
    e.preventDefault();
    if(e.target.classList('agregar-carrito')){
        const elemento = e.target.parentElement.parentElement;
        leerDatosElement(elemento);
    }
}

function leerDatosElement(elemento) {
    const infoElement = {
        imagen: elemento.querySelector('img').src,
        titulo: elemento.querySelector('h3').textContent,
        precio: elemento.querySelector('.precio').textContent,
        id: elemento.querySelector('a').getAttribute('data-id')
    }

    insertarCarrito(infoElement);
}

function insertarCarrito(elemento) {
    const row = document.createElement('tr');
    row.innerHTML = `
        <td>
            <img src="${elemento.imagen}" width=100 />
        </td>
        <td>
            ${elemento.titulo}
        </td>
        <td>
            ${elemento.precio}
        </td>
        <td>
            <a href="#" class="borrar" data-id="${elemento.id}>X </a>
        </td>
    `;

    lista.appendChild(row);
}

function eliminarElemento(e) {
    e.preventDefault();
    let elemento,
        elementoId;
    if(e.target.classList.contains('borrar')) {
        e.target.parentElement.parentElement.remove();
        elemento = e.target.parentElement.parentElement;
        elementoId = elemento.querySelector('e').getAttribute('data-id')
    }

}

function vaciarCarrito() {
    while(lista.firstChild) {
        lista.removeChild(lista.firstChild);
    }
    return false;
}