<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<?php $usuarioRegistrado = isset($_SESSION['user_id']); ?>
<?php $esAdmin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'; ?>
<div class="container my-5">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div class="d-flex align-items-center gap-2">
            <i class="fas fa-headset fa-lg text-primary"></i>
            <span class="small">Soporte al cliente<br><strong>+591-74380719</strong></span>
        </div>
        <h1 class="fw-bold text-center flex-grow-1 mb-0" style="letter-spacing:1px; font-size:2.2rem;">NUESTRO CATALOGO</h1>
        <div style="position:relative;">
            <button id="carritoBtn" class="btn btn-outline-primary position-relative" style="border-radius:50%; width:48px; height:48px;" data-bs-toggle="modal" data-bs-target="#modalCompra">
                <i class="fas fa-shopping-cart fa-lg"></i>
                <span id="cart-count" class="badge bg-danger position-absolute top-0 start-100 translate-middle">0</span>
            </button>
        </div>
        <?php if ($esAdmin): ?>
            <a href="<?php echo URL_ROOT; ?>/catalogo/crear" class="btn btn-success ms-2">
                <i class="fas fa-plus"></i> Nuevo Producto
            </a>
        <?php endif; ?>
    </div>
    <div class="row mb-4 g-3 text-center">
        <div class="col-6 col-md-3">
            <div class="benefit-banner h-100 py-3 px-2">
                <i class="fas fa-plane fa-2x mb-2 text-primary"></i>
                <div class="fw-bold">Envío gratuito</div>
                <small class="text-muted">Pedidos &gt; Bs 300</small>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="benefit-banner h-100 py-3 px-2">
                <i class="fas fa-undo fa-2x mb-2 text-primary"></i>
                <div class="fw-bold">Contrareembolso</div>
                <small class="text-muted">Devolución garantizada</small>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="benefit-banner h-100 py-3 px-2">
                <i class="fas fa-gift fa-2x mb-2 text-primary"></i>
                <div class="fw-bold">Tarjeta regalo</div>
                <small class="text-muted">Bonos especiales</small>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="benefit-banner h-100 py-3 px-2">
                <i class="fas fa-headset fa-2x mb-2 text-primary"></i>
                <div class="fw-bold">Soporte 24/7</div>
                <small class="text-muted">+591-74380719</small>
            </div>
        </div>
    </div>
    <h2 class="text-center my-4 fw-bold">Mejores Categorías</h2>
    <div class="row mb-5 g-3">
        <div class="col-md-3">
            <div class="cat-card position-relative overflow-hidden rounded-4 shadow-sm h-100">
                <img src="<?php echo URL_ROOT; ?>/public/img/categoria-nap-user.jpg" class="w-100 h-100" style="object-fit:cover;filter:brightness(0.7);">
                <div class="cat-overlay position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-center align-items-center">
                    <h3 class="fw-bold text-white mb-2" style="text-shadow:0 2px 8px #000;">Cajas NAP</h3>
                    <a href="#" class="btn btn-light btn-sm btn-vermas-categoria" data-tipo="caja_nap">Ver más</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="cat-card position-relative overflow-hidden rounded-4 shadow-sm h-100">
                <img src="<?php echo URL_ROOT; ?>/public/img/categoria-conectores-user.jpg" class="w-100 h-100" style="object-fit:cover;filter:brightness(0.7);">
                <div class="cat-overlay position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-center align-items-center">
                    <h3 class="fw-bold text-white mb-2" style="text-shadow:0 2px 8px #000;">Conectores</h3>
                    <a href="#" class="btn btn-light btn-sm btn-vermas-categoria" data-tipo="conector">Ver más</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="cat-card position-relative overflow-hidden rounded-4 shadow-sm h-100">
                <img src="<?php echo URL_ROOT; ?>/public/img/categoria-cables-user.jpg" class="w-100 h-100" style="object-fit:cover;filter:brightness(0.7);">
                <div class="cat-overlay position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-center align-items-center">
                    <h3 class="fw-bold text-white mb-2" style="text-shadow:0 2px 8px #000;">Cables</h3>
                    <a href="#" class="btn btn-light btn-sm btn-vermas-categoria" data-tipo="cable">Ver más</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="cat-card position-relative overflow-hidden rounded-4 shadow-sm h-100">
                <img src="<?php echo URL_ROOT; ?>/public/img/categoria-herramientas-user.jpg" class="w-100 h-100" style="object-fit:cover;filter:brightness(0.7);">
                <div class="cat-overlay position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-center align-items-center">
                    <h3 class="fw-bold text-white mb-2" style="text-shadow:0 2px 8px #000;">Herramientas</h3>
                    <a href="#" class="btn btn-light btn-sm btn-vermas-categoria" data-tipo="herramienta">Ver más</a>
                </div>
            </div>
        </div>
    </div>
    <h2 class="text-center my-4 fw-bold">Mejores Productos</h2>
    <div class="d-flex justify-content-center mb-4 gap-2 flex-wrap">
        <button class="btn tab-btn active" id="tab-destacados">Destacados</button>
        <button class="btn tab-btn" id="tab-recientes">Más Recientes</button>
        <button class="btn tab-btn" id="tab-vendidos">Mejores Vendidos</button>
        <button class="btn btn-outline-secondary ms-2" id="btn-mostrar-todos" type="button">Mostrar todos</button>
    </div>
    <div id="productos-lista" class="row g-4">
        <?php foreach($data['productos'] as $producto): ?>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 producto-item"
                 data-tipo="<?php echo strtolower($producto['tipo_producto']); ?>"
                 data-grupo="<?php echo isset($producto['grupo']) ? strtolower($producto['grupo']) : ''; ?>"
                 data-destacado="<?php echo !empty($producto['destacado']) ? '1' : '0'; ?>"
                 data-reciente="<?php echo !empty($producto['reciente']) ? '1' : '0'; ?>"
                 data-vendido="<?php echo !empty($producto['vendido']) ? '1' : '0'; ?>">
                <div class="product-card card h-100 shadow-sm border-0 position-relative rounded-4 overflow-hidden">
                    <?php if (!empty($producto['descuento'])): ?>
                        <span class="badge bg-warning text-dark position-absolute top-0 start-0 m-2 fs-6">-<?php echo intval($producto['descuento']); ?>%</span>
                    <?php endif; ?>
                    <?php if (!empty($producto['imagen'])): ?>
                        <img src="<?php echo URL_ROOT . '/public/img/productos/' . htmlspecialchars($producto['imagen']); ?>" class="card-img-top p-3" alt="Imagen del producto" style="height:170px; object-fit:contain;">
                    <?php else: ?>
                        <img src="<?php echo URL_ROOT . '/public/img/productos/placeholder.png'; ?>" class="card-img-top p-3" alt="Sin imagen" style="height:170px; object-fit:contain;">
                    <?php endif; ?>
                    <div class="card-body d-flex flex-column p-3">
                        <div class="mb-2 text-center">
                            <span class="text-warning">
                                <?php for($i=0;$i<5;$i++): ?>
                                    <i class="fas fa-star<?php echo ($i < ($producto['estrellas'] ?? 4)) ? '' : '-o'; ?>"></i>
                                <?php endfor; ?>
                            </span>
                        </div>
                        <h6 class="text-primary mb-1 text-uppercase text-center small"><?php echo $producto['tipo_producto']; ?></h6>
                        <h5 class="card-title mb-2 fw-bold text-center" style="min-height:48px;"> <?php echo $producto['nombre']; ?> </h5>
                        <div class="mb-2 text-center">
                            <span class="fw-bold fs-5 text-success">Bs <?php echo number_format($producto['precio'], 2); ?></span>
                            <?php if (!empty($producto['precio_original'])): ?>
                                <span class="text-muted text-decoration-line-through ms-2">Bs <?php echo number_format($producto['precio_original'], 2); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="mb-2">
                            <button class="btn btn-outline-primary w-100 add-to-cart-btn rounded-pill" data-id="<?php echo $producto['id_producto']; ?>">
                                <i class="fas fa-shopping-basket me-1"></i>Agregar al carrito
                            </button>
                        </div>
                        <?php if ($esAdmin): ?>
                            <div class="mt-auto d-flex gap-2">
                                <a href="<?php echo URL_ROOT; ?>/catalogo/ver/<?php echo $producto['id_producto']; ?>" class="btn btn-outline-primary btn-sm flex-fill">Ver</a>
                                <a href="<?php echo URL_ROOT; ?>/catalogo/editar/<?php echo $producto['id_producto']; ?>" class="btn btn-outline-warning btn-sm flex-fill">Editar</a>
                                <a href="<?php echo URL_ROOT; ?>/catalogo/eliminar/<?php echo $producto['id_producto']; ?>" class="btn btn-outline-danger btn-sm flex-fill" onclick="return confirm('¿Seguro que deseas eliminar este producto?');">Eliminar</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <!-- Carrito simulado y modal de compra se implementarán en el siguiente paso -->
</div>
<!-- Modal de Compra -->
<div class="modal fade" id="modalCompra" tabindex="-1" aria-labelledby="modalCompraLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content" style="background:#fcf8f3;">
      <div class="modal-header border-0 pb-0">
        <h4 class="modal-title fw-bold w-100 text-center" id="modalCompraLabel">Tu Carrito</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body pt-0">
        <div class="row g-4">
          <div class="col-md-6">
            <div class="p-3 rounded-3 bg-white shadow-sm h-100">
              <h5 class="fw-bold mb-3">Resumen del Carrito</h5>
              <div id="carritoResumen"></div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="p-3 rounded-3 bg-white shadow-sm h-100">
              <h5 class="fw-bold mb-3">Detalles de la Compra</h5>
              <form id="formCompra">
                <div class="mb-3">
                  <label for="nombreCompleto" class="form-label">Nombre Completo</label>
                  <input type="text" class="form-control" id="nombreCompleto" name="nombreCompleto" required>
                </div>
                <div class="mb-3">
                  <label for="direccion" class="form-label">Dirección</label>
                  <input type="text" class="form-control" id="direccion" name="direccion" required>
                </div>
                <div class="mb-3">
                  <label for="ciudad" class="form-label">Ciudad</label>
                  <input type="text" class="form-control" id="ciudad" name="ciudad" required>
                </div>
                <div class="mb-3">
                  <label for="pais" class="form-label">País</label>
                  <select class="form-select" id="pais" name="pais" required>
                    <option value="">Seleccione un país</option>
                    <option value="Bolivia">Bolivia</option>
                    <option value="Argentina">Argentina</option>
                    <option value="Brasil">Brasil</option>
                    <option value="Chile">Chile</option>
                    <option value="Perú">Perú</option>
                    <option value="Otro">Otro</option>
                  </select>
                </div>
                <div class="mb-3">
                  <label for="codigoPostal" class="form-label">Código Postal</label>
                  <input type="text" class="form-control" id="codigoPostal" name="codigoPostal" required>
                </div>
                <div class="mb-3">
                  <label for="numeroTarjeta" class="form-label">Número de Tarjeta</label>
                  <input type="text" class="form-control" id="numeroTarjeta" name="numeroTarjeta" required>
                </div>
                <div class="mb-3">
                  <label for="expiracion" class="form-label">Fecha de Expiración</label>
                  <input type="text" class="form-control" id="expiracion" name="expiracion" placeholder="MM/AA" required>
                </div>
                <div class="mb-3">
                  <label for="cvv" class="form-label">CVV</label>
                  <input type="text" class="form-control" id="cvv" name="cvv" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Pagar</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<style>
.benefit-banner {
    background: #fff;
    border-radius: 1rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    transition: box-shadow .2s;
}
.benefit-banner:hover {
    box-shadow: 0 4px 16px rgba(0,0,0,0.10);
}
.cat-card {
    min-height: 220px;
    cursor: pointer;
    border-radius: 1.5rem;
    transition: box-shadow .2s, transform .2s;
}
.cat-card:hover {
    box-shadow: 0 8px 32px rgba(0,0,0,0.15);
    transform: translateY(-4px) scale(1.03);
}
.cat-overlay {
    background: linear-gradient(180deg,rgba(0,0,0,0.3) 0%,rgba(0,0,0,0.7) 100%);
    border-radius: 1.5rem;
}
.tab-btn {
    border-radius: 2rem;
    font-weight: 500;
    padding: 0.5rem 1.5rem;
    background: #f8f9fa;
    border: 1px solid #ddd;
    transition: background .2s, color .2s;
}
.tab-btn.active, .tab-btn:focus {
    background: #007bff;
    color: #fff;
    border-color: #007bff;
}
.tab-btn:not(.active):hover {
    background: #e9ecef;
    color: #007bff;
}
.product-card {
    border-radius: 1.5rem;
    transition: box-shadow .2s, transform .2s;
    background: #fff;
}
.product-card:hover {
    box-shadow: 0 8px 32px rgba(0,0,0,0.12);
    transform: translateY(-4px) scale(1.03);
}
#cart-count {
    min-width: 24px;
    min-height: 24px;
    font-size: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
}
.shopping-list-cart {
    min-width: 350px;
    max-width: 440px;
    margin-left: auto;
}
.modal-content { border-radius: 1.5rem; }
#modalCompra .modal-body { background: #fcf8f3; }
#modalCompra .form-label { font-weight: 500; }
#modalCompra input, #modalCompra select { background: #fcf8f3; border-radius: 0.5rem; }
#modalCompra .list-group-item { background: transparent; }
#modalCompra .list-group-item img { border-radius: 0.75rem; background: #f8f9fa; }
#modalCompra .btn-outline-secondary { border-radius: 50%; }
#modalCompra .btn-danger { border-radius: 50%; }
.btn-cantidad-anim {
    transition: transform 0.15s cubic-bezier(.4,2,.6,1), background 0.15s;
}
.btn-animar-cantidad {
    transform: scale(1.25);
    background: #e0f0ff !important;
    color: #007bff !important;
    box-shadow: 0 0 0 2px #b6e0ff;
}
</style>
<?php require_once __DIR__ . '/../layouts/footer.php'; ?> 
<script>
// Utilidad para obtener productos del carrito
function getCarrito() {
    return JSON.parse(localStorage.getItem('carrito')) || [];
}
// Guardar productos en el carrito
function setCarrito(carrito) {
    localStorage.setItem('carrito', JSON.stringify(carrito));
}
// Actualizar contador del carrito
function actualizarContadorCarrito() {
    const carrito = getCarrito();
    document.getElementById('cart-count').textContent = carrito.reduce((acc, item) => acc + item.cantidad, 0);
}
// Agregar producto al carrito
function agregarAlCarrito(producto) {
    let carrito = getCarrito();
    const index = carrito.findIndex(item => item.id === producto.id);
    if (index !== -1) {
        carrito[index].cantidad += 1;
    } else {
        producto.cantidad = 1;
        carrito.push(producto);
    }
    setCarrito(carrito);
    actualizarContadorCarrito();
}
// Animación para los botones + y - del carrito
function animarBotonCantidad(btn) {
    btn.classList.add('btn-animar-cantidad');
    setTimeout(() => btn.classList.remove('btn-animar-cantidad'), 180);
}
// Cambiar cantidad de un producto
function cambiarCantidadCarrito(idx, delta) {
    let carrito = getCarrito();
    carrito[idx].cantidad += delta;
    if (carrito[idx].cantidad <= 0) {
        carrito.splice(idx, 1);
    }
    setCarrito(carrito);
    mostrarCarritoEnModal();
    actualizarContadorCarrito();
}
// Delegar animación a los botones + y -
document.addEventListener('click', function(e) {
    if (e.target.matches('.btn-cantidad-anim')) {
        animarBotonCantidad(e.target);
    }
});
// Mostrar productos en el modal
function mostrarCarritoEnModal() {
    const carrito = getCarrito();
    let html = '';
    if (carrito.length === 0) {
        html = '<p class="text-center text-muted">No hay productos en el carrito.</p>';
    } else {
        html = '<ul class="list-group list-group-flush">';
        carrito.forEach((item, idx) => {
            let precioUnitario = parseFloat(item.precio);
            if (isNaN(precioUnitario)) precioUnitario = 0;
            let subtotal = precioUnitario * item.cantidad;
            html += `<li class="list-group-item d-flex align-items-center border-0 border-bottom py-3">
                        <img src="${item.imagen}" alt="img" style="width:64px;height:64px;object-fit:contain;margin-right:16px;">
                        <div class="flex-grow-1">
                          <div class="fw-bold">${item.nombre}</div>
                          <div class="small text-muted">Bs ${precioUnitario.toFixed(2)} x 
                            <button class='btn btn-sm btn-outline-secondary px-2 py-0 me-1 btn-cantidad-anim' onclick='cambiarCantidadCarrito(${idx}, -1)'>-</button>
                            <span class='mx-1'>${item.cantidad}</span>
                            <button class='btn btn-sm btn-outline-secondary px-2 py-0 ms-1 btn-cantidad-anim' onclick='cambiarCantidadCarrito(${idx}, 1)'>+</button>
                          </div>
                        </div>
                        <div class="fw-bold ms-2">Bs ${subtotal.toFixed(2)}</div>
                        <button class='btn btn-sm btn-danger ms-2' onclick='eliminarDelCarrito(${idx})' title='Eliminar'><i class='fas fa-trash'></i></button>
                    </li>`;
        });
        let total = carrito.reduce((acc, item) => {
            let precio = parseFloat(item.precio);
            if (isNaN(precio)) precio = 0;
            return acc + (precio * item.cantidad);
        }, 0);
        html += '</ul>';
        html += `<hr><div class="d-flex justify-content-between align-items-center px-2 fw-bold fs-5"><span>Total:</span><span>Bs ${total.toFixed(2)}</span></div>`;
    }
    document.getElementById('carritoResumen').innerHTML = html;
}
// Eliminar producto del carrito
function eliminarDelCarrito(idx) {
    let carrito = getCarrito();
    carrito.splice(idx, 1);
    setCarrito(carrito);
    mostrarCarritoEnModal();
    actualizarContadorCarrito();
}
// Al cargar la página, actualizar el contador
actualizarContadorCarrito();
// Asignar eventos a los botones 'Agregar al carrito'
document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const card = btn.closest('.product-card');
        const id = btn.getAttribute('data-id');
        const nombre = card.querySelector('.card-title').textContent.trim();
        const precio = card.querySelector('.text-success').textContent.replace('Bs', '').trim();
        // Obtener la imagen
        let img = card.querySelector('img.card-img-top');
        let imagen = img ? img.getAttribute('src') : '';
        agregarAlCarrito({ id, nombre, precio: parseFloat(precio), imagen });
    });
});
// Mostrar productos en el modal al abrirlo
document.getElementById('modalCompra').addEventListener('show.bs.modal', mostrarCarritoEnModal);
// Filtrado de productos por grupo (categoría)
function filtrarPorCategoria(tipo) {
    document.querySelectorAll('.producto-item').forEach(item => {
        // Si tipo es 'cable', mostrar splitter, conector y cable
        if (tipo === 'cable') {
            const tiposCable = ['splitter', 'conector', 'cable'];
            if (tiposCable.includes(item.getAttribute('data-tipo'))) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        } else if (tipo === 'herramienta') {
            // Si tipo es 'herramienta', mostrar solo 'otro'
            if (item.getAttribute('data-tipo') === 'otro') {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        } else {
            // Filtro normal
            if (item.getAttribute('data-tipo') === tipo) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        }
    });
    // Quitar selección de tabs
    tabDestacados.classList.remove('active');
    tabRecientes.classList.remove('active');
    tabVendidos.classList.remove('active');
}
// Filtrado por destacados, recientes, vendidos
function filtrarPorGrupo(grupo) {
    document.querySelectorAll('.producto-item').forEach(item => {
        let mostrar = false;
        if (grupo === 'destacados') mostrar = item.getAttribute('data-destacado') === '1';
        if (grupo === 'recientes') mostrar = item.getAttribute('data-reciente') === '1';
        if (grupo === 'vendidos') mostrar = item.getAttribute('data-vendido') === '1';
        if (mostrar) {
            item.style.display = '';
        } else {
            item.style.display = 'none';
        }
    });
}
// Mostrar todos
function mostrarTodosProductos() {
    document.querySelectorAll('.producto-item').forEach(item => {
        item.style.display = '';
    });
    // Quitar selección de tabs
    tabDestacados.classList.remove('active');
    tabRecientes.classList.remove('active');
    tabVendidos.classList.remove('active');
}
// Eventos para tabs
const tabDestacados = document.getElementById('tab-destacados');
const tabRecientes = document.getElementById('tab-recientes');
const tabVendidos = document.getElementById('tab-vendidos');
tabDestacados.addEventListener('click', function() {
    filtrarPorGrupo('destacados');
    tabDestacados.classList.add('active');
    tabRecientes.classList.remove('active');
    tabVendidos.classList.remove('active');
});
tabRecientes.addEventListener('click', function() {
    filtrarPorGrupo('recientes');
    tabDestacados.classList.remove('active');
    tabRecientes.classList.add('active');
    tabVendidos.classList.remove('active');
});
tabVendidos.addEventListener('click', function() {
    filtrarPorGrupo('vendidos');
    tabDestacados.classList.remove('active');
    tabRecientes.classList.remove('active');
    tabVendidos.classList.add('active');
});
// Por defecto mostrar destacados
filtrarPorGrupo('destacados');
// Eventos para "Ver más" de categorías
// Usar delegación para todos los botones de categoría
document.querySelectorAll('.btn-vermas-categoria').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        const tipo = btn.getAttribute('data-tipo');
        filtrarPorCategoria(tipo);
    });
});
// Evento para botón "Mostrar todos"
document.getElementById('btn-mostrar-todos').addEventListener('click', function() {
    mostrarTodosProductos();
});
</script> 