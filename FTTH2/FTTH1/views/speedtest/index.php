<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<div class="container my-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card bg-dark text-white shadow">
        <div class="card-body text-center">
          <h2 class="mb-4">Speedtest</h2>
          <button id="btnSpeedtest" class="btn btn-primary mb-4">Iniciar prueba</button>
          <div class="row mb-3">
            <div class="col-md-4 mb-2">
              <div class="p-3 border rounded bg-dark text-center" style="border-color: #00aaff;">
                <div class="fw-bold">Ping</div>
                <div id="ping" style="font-size:1.5rem;">-</div>
              </div>
            </div>
            <div class="col-md-4 mb-2">
              <div class="p-3 border rounded bg-dark text-center" style="border-color: #00aaff;">
                <div class="fw-bold">Descarga</div>
                <div id="download" style="font-size:1.5rem;">-</div>
              </div>
            </div>
            <div class="col-md-4 mb-2">
              <div class="p-3 border rounded bg-dark text-center" style="border-color: #00aaff;">
                <div class="fw-bold">Subida</div>
                <div id="upload" style="font-size:1.5rem;">-</div>
              </div>
            </div>
          </div>
          <div id="speedtest-status" class="text-info"></div>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/@fdossena/speedtest@latest/speedtest.min.js"></script>
<script>
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
  // Aquí puedes simular descargas a los endpoints y medir el tiempo para calcular la velocidad
  // Por simplicidad, puedes mostrar un mensaje de que la prueba está en curso y luego mostrar un resultado simulado
  // Para una integración real, se recomienda usar la librería mencionada arriba en backend o Node.js
}

document.getElementById('btnSpeedtest').addEventListener('click', async function() {
  const statusEl = document.getElementById('speedtest-status');
  statusEl.textContent = 'Comprobando conexión...';
  const isConnected = await checkInternetConnection();
  if (!isConnected) {
    statusEl.textContent = 'No tienes conexión a internet.';
    return;
  }
  statusEl.textContent = 'Ejecutando prueba de velocidad...';
  // Aquí llamas a runFastSpeedTest() y actualizas los resultados
  // Por ahora, simulemos el resultado:
  setTimeout(() => {
    document.getElementById('ping').textContent = '12 ms';
    document.getElementById('download').textContent = '85.32 Mbps';
    document.getElementById('upload').textContent = '19.45 Mbps';
    statusEl.textContent = 'Prueba finalizada (simulada).';
  }, 3000);
});
</script>
<?php require_once __DIR__ . '/../layouts/footer.php'; ?> 