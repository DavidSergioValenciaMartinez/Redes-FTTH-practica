<?php require_once 'views/layouts/header.php'; ?>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-box me-2"></i>Seleccionar Cajas NAP</h4>
                </div>
                <div class="card-body">
                    <form action="<?php echo URL_ROOT; ?>/balanceados" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Seleccione una o más cajas NAP para el cálculo:</label>
                            <div class="row">
                                <?php foreach($data['cajas'] as $caja): ?>
                                    <div class="col-md-6 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="cajas_nap[]" id="caja_<?php echo $caja['id_caja']; ?>" value="<?php echo $caja['id_caja']; ?>">
                                            <label class="form-check-label" for="caja_<?php echo $caja['id_caja']; ?>">
                                                <?php echo htmlspecialchars($caja['codigo_caja']) . ' - ' . htmlspecialchars($caja['ubicacion']); ?>
                                            </label>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Continuar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once 'views/layouts/footer.php'; ?> 