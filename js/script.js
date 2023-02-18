 //peticion ajax para que el carrito se actualice solo
 function addProduct(id, token){
  let url='clases/carrito.php';
  let formData = new FormData();
  formData.append('id', id)
  formData.append('token', token)

  fetch(url, {
    method:'POST',
    body: formData,
    mode: 'cors'
  }).then(response => response.json())
  .then(data => {
    if(data.ok){
      actualizarContadorCarrito(data.numero)
    }
  })
}

function actualizarContadorCarrito(numero) {
  let elemento = document.getElementById("num_cart")
  elemento.innerHTML = numero
}