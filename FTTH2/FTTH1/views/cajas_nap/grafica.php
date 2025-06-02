<?php require_once 'views/layouts/header.php'; ?>
<div class="container my-4">
    <h2>Gráfica de Puertos de Caja NAP</h2>
    <form method="get" action="<?php echo URL_ROOT; ?>/cajas_nap/grafica" class="mb-4">
        <div class="row g-2 align-items-end">
            <div class="col-md-6">
                <label for="id_caja" class="form-label">Selecciona una Caja NAP:</label>
                <select class="form-select" id="id_caja" name="id_caja" required>
                    <option value="">Seleccione...</option>
                    <?php foreach($data['cajas'] as $caja): ?>
                        <option value="<?php echo $caja['id_caja']; ?>" <?php if(isset($data['cajaSeleccionada']) && $data['cajaSeleccionada']['id_caja'] == $caja['id_caja']) echo 'selected'; ?>>
                            <?php echo $caja['codigo_caja'] . ' - ' . $caja['ubicacion']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Ver gráfica</button>
            </div>
        </div>
    </form>

    <?php if (isset($data['cajaSeleccionada'])): ?>
        <div class="mb-3">
            <h5>Caja: <?php echo $data['cajaSeleccionada']['codigo_caja']; ?> | Total de Puertos: <?php echo $data['cajaSeleccionada']['total_puertos']; ?></h5>
        </div>
        <div class="mb-4">
            <div class="d-flex flex-wrap" style="gap:8px;">
                <?php
                // Crear un mapa de puertos existentes por numero_puerto
                $puertosMap = [];
                foreach ($data['puertos'] as $puerto) {
                    $puertosMap[$puerto['numero_puerto']] = $puerto;
                }
                $total = (int)$data['cajaSeleccionada']['total_puertos'];
                for ($i = 1; $i <= $total; $i++):
                    $isOcupado = false;
                    $hojaTecnicaId = null;
                    if (isset($puertosMap[$i])) {
                        $puerto = $puertosMap[$i];
                        $color = $puerto['estado'] === 'ocupado' ? '#dc3545' : ($puerto['estado'] === 'disponible' ? '#198754' : '#ffc107');
                        $estado = ucfirst($puerto['estado']);
                        $tooltip = "Puerto {$puerto['numero_puerto']}: $estado";
                        if ($puerto['estado'] === 'ocupado') {
                            $isOcupado = true;
                            if (!empty($puerto['nombre_cliente'])) {
                                $tooltip .= "\nCliente: " . $puerto['nombre_cliente'];
                            }
                            if (!empty($puerto['actualizado_en'])) {
                                $tooltip .= "\nOcupado desde: " . date('d/m/Y H:i', strtotime($puerto['actualizado_en']));
                            }
                            // Buscar hoja técnica asociada (por id_caja y cliente_usuario_id)
                            if (!empty($puerto['cliente_usuario_id'])) {
                                $hojaTecnica = null;
                                if (!empty($data['hojas_tecnicas'])) {
                                    foreach ($data['hojas_tecnicas'] as $ht) {
                                        if ($ht['id_caja'] == $data['cajaSeleccionada']['id_caja'] && $ht['cliente_usuario_id'] == $puerto['cliente_usuario_id']) {
                                            $hojaTecnicaId = $ht['id_hoja_caja'];
                                            break;
                                        }
                                    }
                                }
                            }
                        }
                    } else {
                        $color = '#198754';
                        $estado = 'Disponible';
                        $tooltip = "Puerto $i: $estado";
                    }
                ?>
                    <?php if ($isOcupado && $hojaTecnicaId): ?>
                        <div title="<?php echo htmlspecialchars($tooltip); ?>"
                             class="puerto-ocupado-btn"
                             data-hoja-id="<?php echo $hojaTecnicaId; ?>"
                             data-cliente="<?php echo htmlspecialchars($puerto['nombre_cliente'] ?? ''); ?>"
                             data-fecha="<?php echo !empty($puerto['actualizado_en']) ? date('d/m/Y H:i', strtotime($puerto['actualizado_en'])) : ''; ?>"
                             data-puerto="<?php echo $i; ?>"
                             style="width:40px;height:40px;background:<?php echo $color; ?>;border-radius:6px;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:bold;cursor:pointer;">
                            <?php echo $i; ?>
                        </div>
                    <?php else: ?>
                        <div title="<?php echo htmlspecialchars($tooltip); ?>"
                             style="width:40px;height:40px;background:<?php echo $color; ?>;border-radius:6px;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:bold;cursor:default;">
                            <?php echo $i; ?>
                        </div>
                    <?php endif; ?>
                <?php endfor; ?>
            </div>
            <div class="mt-3">
                <span class="badge bg-success">Disponible</span>
                <span class="badge bg-danger">Ocupado</span>
                <span class="badge bg-warning text-dark">Defectuoso</span>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Modal para mostrar datos de hoja técnica -->
<div class="modal fade" id="modalHojaTecnica" tabindex="-1" aria-labelledby="modalHojaTecnicaLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalHojaTecnicaLabel">Detalle de Puerto Ocupado</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <p><strong>Cliente:</strong> <span id="modalCliente"></span></p>
        <p><strong>Puerto ocupado:</strong> <span id="modalPuerto"></span></p>
        <p><strong>Fecha de ocupación:</strong> <span id="modalFecha"></span></p>
        <p><strong>Técnico:</strong> <span id="modalTecnico"></span></p>
        <p><strong>Fecha de instalación:</strong> <span id="modalFechaInstalacion"></span></p>
        <a id="modalVerHoja" href="#" class="btn btn-primary btn-sm" target="_blank">Ver hoja técnica completa</a>
      </div>
    </div>
  </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Pasar las hojas técnicas a JS
    var hojasTecnicas = <?php echo json_encode($data['hojas_tecnicas'] ?? []); ?>;
    document.querySelectorAll('.puerto-ocupado-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.getElementById('modalCliente').textContent = btn.getAttribute('data-cliente');
            document.getElementById('modalPuerto').textContent = btn.getAttribute('data-puerto');
            document.getElementById('modalFecha').textContent = btn.getAttribute('data-fecha');
            document.getElementById('modalVerHoja').href = '<?php echo URL_ROOT; ?>/hoja_tecnica/ver/' + btn.getAttribute('data-hoja-id');
            // Buscar hoja técnica correspondiente
            var hojaId = btn.getAttribute('data-hoja-id');
            var hoja = hojasTecnicas.find(function(ht) { return ht.id_hoja_caja == hojaId; });
            document.getElementById('modalTecnico').textContent = hoja && hoja.nombre_tecnico ? hoja.nombre_tecnico : '';
            document.getElementById('modalFechaInstalacion').textContent = hoja && hoja.creado_en ? (new Date(hoja.creado_en)).toLocaleString('es-ES') : '';
            var modal = new bootstrap.Modal(document.getElementById('modalHojaTecnica'));
            modal.show();
        });
    });
});
</script>
<?php require_once 'views/layouts/footer.php'; ?> 