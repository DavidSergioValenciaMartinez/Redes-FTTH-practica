<?php require_once 'views/layouts/header.php'; ?>

<div class="container my-5">
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-balance-scale me-2"></i>
                        Cálculos Balanceados
                    </h4>
                </div>
                <div class="card-body">
                    <?php if (!isset($data['num_naps']) || $data['num_naps'] <= 0): ?>
                        <!-- Initial form to ask for number of NAP boxes -->
                        <form action="<?php echo URL_ROOT; ?>/calculo/seleccionarNaps" method="POST">
                            <div class="mb-3">
                                <label for="num_naps" class="form-label">Número de Cajas NAP</label>
                                <input type="number" step="1" min="1" class="form-control" id="num_naps" name="num_naps" placeholder="Ingrese el número de cajas NAP" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Continuar</button>
                        </form>
                    <?php else: ?>
                        <!-- Dynamic form for calculation -->
                        <form action="<?php echo URL_ROOT; ?>/balanceados/calcularBalanceado" method="POST">
                            <input type="hidden" name="num_naps" value="<?php echo $data['num_naps']; ?>">
                            
                            <!-- Puerto selection -->
                            <div class="mb-4">
                                <label for="id_puerto" class="form-label">Seleccionar Puerto</label>
                                <select class="form-select" id="id_puerto" name="id_puerto" required onchange="cargarDatosPuerto(this)">
                                    <option value="">Seleccione un puerto...</option>
                                    <?php if (isset($data['puertos']) && is_array($data['puertos'])): ?>
                                        <?php foreach($data['puertos'] as $puerto): ?>
                                            <option value="<?php echo $puerto['id_puerto']; ?>"
                                                data-splitter-tipo="<?php echo htmlspecialchars($puerto['splitter_tipo'] ?? ''); ?>"
                                                data-splitter-ratio="<?php echo htmlspecialchars($puerto['splitter_ratio'] ?? ''); ?>"
                                                data-splitter-atenuacion="<?php echo htmlspecialchars($puerto['splitter_atenuacion_db'] ?? ''); ?>">
                                                <?php echo htmlspecialchars($puerto['codigo_caja']) . ' - Puerto ' . htmlspecialchars($puerto['numero_puerto']); ?>
                                                <?php if (!empty($puerto['nombre_cliente'])): ?>
                                                    (<?php echo htmlspecialchars($puerto['nombre_cliente']); ?>)
                                                <?php endif; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                                <div id="infoPuertoSeleccionado"></div>
                                <div class="form-text">Seleccione el puerto para el cual desea realizar el cálculo</div>
                            </div>

                            <?php if (isset($data['num_naps']) && $data['num_naps'] > 0): ?>
                                <?php for ($i = 1; $i <= $data['num_naps']; $i++): ?>
                                    <h5 class="mt-4">Caja NAP <?php echo $i; ?></h5>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="distancia_fo_<?php echo $i; ?>" class="form-label">Distancia F.O. (m)</label>
                                            <input type="number" step="0.01" class="form-control" id="distancia_fo_<?php echo $i; ?>" name="naps[<?php echo $i; ?>][distancia_fo]" placeholder="Distancia en metros" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="cable_dropp_<?php echo $i; ?>" class="form-label">Cable Dropp (m)</label>
                                            <input type="number" step="0.01" class="form-control" id="cable_dropp_<?php echo $i; ?>" name="naps[<?php echo $i; ?>][cable_dropp]" placeholder="Distancia en metros" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="fusiones_fo_<?php echo $i; ?>" class="form-label">Fusiones F.O.</label>
                                            <input type="number" step="1" class="form-control" id="fusiones_fo_<?php echo $i; ?>" name="naps[<?php echo $i; ?>][fusiones_fo]" value="0" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="acopladores_<?php echo $i; ?>" class="form-label">Acopladores</label>
                                            <input type="number" step="1" class="form-control" id="acopladores_<?php echo $i; ?>" name="naps[<?php echo $i; ?>][acopladores]" value="0" required>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="cantidad_splitters_<?php echo $i; ?>" class="form-label">Cantidad de Splitters</label>
                                        <input type="number" min="1" max="10" class="form-control cantidad-splitters" id="cantidad_splitters_<?php echo $i; ?>" name="naps[<?php echo $i; ?>][cantidad_splitters]" value="1" data-nap-index="<?php echo $i; ?>" required>
                                    </div>
                                    <div id="splitters_container_<?php echo $i; ?>">
                                        <!-- Aquí se insertarán los selects de ratio de splitter dinámicamente -->
                                    </div>
                                    <hr>
                                <?php endfor; ?>

                                <div class="mb-3">
                                    <label for="nivel_insercion" class="form-label">Nivel de Inserción (dBm)</label>
                                    <input type="number" step="0.01" class="form-control" id="nivel_insercion" name="nivel_insercion" placeholder="Ingrese el nivel de inserción" value="-5" required>
                                </div>

                                <button type="submit" class="btn btn-primary">Calcular Total</button>
                            <?php endif; ?>
                        </form>

                        <!-- Display calculation result here -->
                        <?php if (isset($data['atenuacion_parcial_total'])): ?>
                            <div class="mt-4 alert alert-success">
                                <h5>Resultado del Cálculo</h5>
                                <ul>
                                    <li>Atenuación Parcial Total: <strong><?php echo htmlspecialchars($data['atenuacion_parcial_total']); ?> dB</strong></li>
                                    <li>Atenuación Total Cliente: <strong><?php echo htmlspecialchars($data['atenuacion_total_cliente_db']); ?> dB</strong></li>
                                    <li>Atenuación Total Caja NAP: <strong><?php echo htmlspecialchars($data['atenuacion_total_caja_nap_db']); ?> dB</strong></li>
                                </ul>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// Mostrar solo para el cliente
if (isset($_SESSION['user_role']) && in_array($_SESSION['user_role'], ['cliente', 'client'])): ?>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow text-center">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-balance-scale me-2"></i> Verificación de Atenuación</h5>
                    </div>
                    <div class="card-body">
                        <?php if (isset($data['puerto_cliente'])): ?>
                            <p class="mb-2"><strong>Puerto:</strong> <?php echo htmlspecialchars($data['puerto_cliente']['nombre']); ?></p>
                            <p class="mb-2"><strong>Caja NAP:</strong> <?php echo htmlspecialchars($data['puerto_cliente']['caja_nap']); ?></p>
                            <?php if (isset($data['puerto_cliente']['atenuacion_total'])): ?>
                                <p class="mb-2"><strong>Atenuación Total:</strong> <?php echo htmlspecialchars($data['puerto_cliente']['atenuacion_total']); ?> dB</p>
                            <?php else: ?>
                                <div class="alert alert-info text-center my-4" role="alert" style="font-size:1.1em;">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Aún no hay un cálculo de atenuación disponible para su puerto. Por favor, contacte a soporte para más información.
                                </div>
                            <?php endif; ?>
                        <?php else: ?>
                            <div class="alert alert-info text-center my-4" role="alert" style="font-size:1.1em;">
                                <i class="fas fa-info-circle me-2"></i>
                                No se encontró un puerto asignado a su usuario.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
<script>
function cargarDatosPuerto(select) {
    var option = select.options[select.selectedIndex];
    if (!option) return;
    var splitterTipo = option.getAttribute('data-splitter-tipo');
    var splitterRatio = option.getAttribute('data-splitter-ratio');
    var splitterAtenuacion = option.getAttribute('data-splitter-atenuacion');
    
    // Autocompletar splitter tipo y ratio en todos los NAPs
    document.querySelectorAll('.splitter-tipo').forEach(function(sel) {
        if (splitterTipo) sel.value = splitterTipo;
    });
    document.querySelectorAll('.splitter-ratio').forEach(function(sel) {
        if (splitterRatio) sel.value = splitterRatio;
    });
    
    // Mostrar mensaje de atenuación
    var infoDiv = document.getElementById('infoPuertoSeleccionado');
    if (splitterAtenuacion) {
        infoDiv.innerHTML = `<div class='alert alert-info mt-3'>Atenuación del splitter: <strong>${splitterAtenuacion} dB</strong></div>`;
    } else {
        infoDiv.innerHTML = '';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Para cada caja NAP, inicializar los selects de splitters
    document.querySelectorAll('.cantidad-splitters').forEach(function(input) {
        function renderSplitters(napIndex, cantidad) {
            var container = document.getElementById('splitters_container_' + napIndex);
            container.innerHTML = '';
            for (var j = 1; j <= cantidad; j++) {
                var accordionId = 'accordion_splitter_' + napIndex + '_' + j;
                var collapseId = 'collapse_splitter_' + napIndex + '_' + j;
                container.innerHTML += `
                <div class="accordion mb-2" id="${accordionId}">
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="heading_${accordionId}">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#${collapseId}" aria-expanded="false" aria-controls="${collapseId}">
                        Splitter #${j}
                      </button>
                    </h2>
                    <div id="${collapseId}" class="accordion-collapse collapse" aria-labelledby="heading_${accordionId}" data-bs-parent="#${accordionId}">
                      <div class="accordion-body">
                        <label for="splitter_ratio_${napIndex}_${j}" class="form-label">Ratio del Splitter</label>
                        <select class="form-select" id="splitter_ratio_${napIndex}_${j}" name="naps[${napIndex}][splitters][${j}][ratio]" required>
                          <option value="">Seleccione el ratio</option>
                          <option value="1:2">1:2</option>
                          <option value="1:4">1:4</option>
                          <option value="1:8">1:8</option>
                          <option value="1:16">1:16</option>
                          <option value="1:32">1:32</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                `;
            }
        }
        // Inicializar con el valor por defecto
        renderSplitters(input.dataset.napIndex, input.value);
        // Escuchar cambios
        input.addEventListener('input', function() {
            var cantidad = parseInt(this.value) || 1;
            renderSplitters(this.dataset.napIndex, cantidad);
        });
    });
});

async function checkInternetConnection() {
  try {
    const online = window.navigator.onLine;
    if (!online) return false;
    // Prueba rápida a un endpoint público
    await fetch('https://fast.com', {mode: 'no-cors'});
    return true;
  } catch {
    return false;
  }
}

async function runFastSpeedTest() {
  // Obtener los endpoints de Fast.com
  const resp = await fetch('https://api.fast.com/netflix/speedtest/v2?https=true&token=YXNkZmFzZGxmbnNkYWZoYXNkZmhrYWxm', {mode: 'cors'});
  const data = await resp.json();
  // Aquí puedes simular descargas a los endpoints y medir el tiempo para calcular la velocidad
  // Por simplicidad, puedes mostrar un mensaje de que la prueba está en curso y luego mostrar un resultado simulado
  // Para una integración real, se recomienda usar la librería mencionada arriba en backend o Node.js
}

document.getElementById('btnSpeedtest').addEventListener('click', function() {
  window.open('https://www.speedtest.net', '_blank');
});
</script>
<?php endif; ?>

<?php require_once 'views/layouts/footer.php'; ?>