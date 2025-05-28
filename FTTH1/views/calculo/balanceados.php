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
                                        <label for="splitter_tipo_<?php echo $i; ?>" class="form-label">Tipo de Splitter</label>
                                        <select class="form-select splitter-tipo" id="splitter_tipo_<?php echo $i; ?>" name="naps[<?php echo $i; ?>][splitter_tipo]" required>
                                            <option value="">Seleccione el tipo de splitter</option>
                                            <option value="balanceado">Balanceado</option>
                                            <option value="desbalanceado">Desbalanceado</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="splitter_ratio_<?php echo $i; ?>" class="form-label">Ratio del Splitter</label>
                                        <select class="form-select splitter-ratio" id="splitter_ratio_<?php echo $i; ?>" name="naps[<?php echo $i; ?>][splitter_ratio]" required>
                                            <option value="">Seleccione el ratio</option>
                                            <option value="1:2">1:2</option>
                                            <option value="1:4">1:4</option>
                                            <option value="1:8">1:8</option>
                                            <option value="1:16">1:16</option>
                                        </select>
                                    </div>
                                    <hr>
                                <?php endfor; ?>

                                <div class="mb-3">
                                    <label for="nivel_insercion" class="form-label">Nivel de Inserción (dBm)</label>
                                    <input type="number" step="0.01" class="form-control" id="nivel_insercion" name="nivel_insercion" placeholder="Ingrese el nivel de inserción" required>
                                </div>

                                <button type="submit" class="btn btn-primary">Calcular Total</button>
                            <?php endif; ?>
                        </form>

                        <!-- Display calculation result here -->
                        <?php if (isset($data['atenuacion_total_db'])): ?>
                            <div class="mt-4 alert alert-success">
                                <h5>Resultado del Cálculo</h5>
                                <p>Atenuación Total: <strong><?php echo htmlspecialchars($data['atenuacion_total_db']); ?> dB</strong></p>
                                <p>Atenuación Total CLIENTE: <strong><?php echo htmlspecialchars($data['atenuacion_total_cliente_db'] ?? 'N/A'); ?> dBm</strong></p>
                                <p>Atenuación Total CAJA NAP: <strong><?php echo htmlspecialchars($data['atenuacion_total_caja_nap_db'] ?? 'N/A'); ?> dBm</strong></p>

                                <!-- Canvas for the gauge chart -->
                                <canvas id="gauge_chart_canvas" style="width: 400px; height: 200px;"></canvas>

                                <script src="https://cdn.jsdelivr.net/npm/gauge-js@1.3.7/dist/gauge.min.js"></script>
                                <script type="text/javascript">
                                    document.addEventListener('DOMContentLoaded', function() {
                                        var dataValue = <?php echo json_encode($data['atenuacion_total_db']); ?>;
                                        console.log('Atenuación Total DB value for gauge.js:', dataValue);

                                        if (dataValue !== null && !isNaN(dataValue)) {
                                            var opts = {
                                                angle: 0.15, // The span of the gauge arc
                                                lineWidth: 0.44, // The line thickness
                                                radiusScale: 1, // Relative radius
                                                pointer: {
                                                    length: 0.6, // Relative to gauge radius
                                                    strokeWidth: 0.035, // The thickness
                                                    color: '#000000' // Fill color
                                                },
                                                limitMax: false, // If false, max value increases automatically if value > maxValue
                                                limitMin: false, // If true, the min value of the gauge will be fixed
                                                colorStart: '#6FADCF', // Colors
                                                colorStop: '#8FC0DA', // just experiment with them
                                                strokeColor: '#E0E0E0', // to see which ones work best for you
                                                generateGradient: true,
                                                highDpiSupport: true, // High resolution support
                                                staticZones: [
                                                    {strokeStyle: "#00a9ff", min: 0, max: 50}, // Blue zone
                                                    {strokeStyle: "#00c3ff", min: 50, max: 100}, // Lighter blue zone
                                                    {strokeStyle: "#00e2ff", min: 100, max: 250}, // Cyan zone
                                                    {strokeStyle: "#00ffc3", min: 250, max: 500}, // Green zone
                                                    {strokeStyle: "#4d4dff", min: 500, max: 1000}  // Dark blue zone
                                                ],
                                                renderTicks: {
                                                    divisions: 8, // Number of major divisions (0, 5, 10, 50, 100, 250, 500, 750, 1000 - 9 points, so 8 divisions)
                                                    divWidth: 1.1,
                                                    divLength: 0.7,
                                                    divColor: '#333333',
                                                    subDivisions: 2, // Minor ticks between major ones (e.g., between 0 and 5)
                                                    subLength: 0.5,
                                                    subWidth: 0.6,
                                                    subColor: '#666666'
                                                },
                                                staticLabels: {
                                                    font: "10px sans-serif",
                                                    labels: [0, 5, 10, 50, 100, 250, 500, 750, 1000],
                                                    color: "#000000",
                                                    fractionDigits: 0
                                                }
                                            };

                                            var target = document.getElementById('gauge_chart_canvas'); // your canvas element
                                            var gauge = new Gauge(target).setOptions(opts); // create sexy gauge!

                                            gauge.maxValue = 1000; // set max gauge value based on image
                                            gauge.setMinValue(0); // set min gauge value
                                            gauge.animationSpeed = 32; // set animation speed (32 is default value)
                                            gauge.set(dataValue); // set actual value
                                        } else {
                                            console.error('Invalid dataValue for gauge.js chart:', dataValue);
                                        }
                                    });
                                </script>

                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

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
</script>

<?php require_once 'views/layouts/footer.php'; ?>