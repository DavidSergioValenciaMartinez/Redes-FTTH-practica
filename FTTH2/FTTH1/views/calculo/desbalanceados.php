<?php require_once 'views/layouts/header.php'; ?>

<?php
if (!isset($_SESSION['user_id'])): ?>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow text-center">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-tachometer-alt me-2"></i> Speedtest</h5>
                    </div>
                    <div class="card-body">
                        <p>Para acceder a los cálculos de atenuación balanceada y desbalanceada, por favor <a href="<?php echo URL_ROOT; ?>/login">inicie sesión</a>.</p>
                        <a href="https://www.speedtest.net" target="_blank" class="btn btn-success mt-3"><i class="fas fa-tachometer-alt me-1"></i> Realizar Speedtest</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php elseif (isset($_SESSION['user_role']) && in_array($_SESSION['user_role'], ['cliente', 'client'])): ?>
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
    <div class="container my-5">
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">
                            <i class="fas fa-unbalance me-2"></i>
                            Cálculos Desbalanceados
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Esta sección está en desarrollo. Próximamente podrás realizar cálculos de desbalanceo aquí.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php require_once 'views/layouts/footer.php'; ?> 