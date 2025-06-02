<!-- Sección Hoja Técnica -->
<section id="hojaTecnica" class="section-content container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-file-alt me-2"></i>Hoja Técnica de Instalación</h2>
        <a href="<?php echo URL_ROOT; ?>/soporte" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left me-2"></i>Volver a Soporte
        </a>
    </div>
    
    <div class="card shadow-sm mb-5">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Datos de Instalación / Intervención</h5>
        </div>
        <div class="card-body">
            <form id="hojaTecnicaForm">
                <!-- Encabezado principal -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="contratoOT" class="form-label fw-bold">1) Contrato/OT del Cliente (ID):</label>
                            <input type="text" class="form-control" id="contratoOT" name="contratoOT" required>
                        </div>
                        
                        <div class="form-group mb-3">
                            <div class="d-flex align-items-center">
                                <label for="nombreCliente" class="form-label fw-bold me-2">2) Nombre del Cliente:</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="checkNombreCliente" name="checkNombreCliente">
                                    <label class="form-check-label" for="checkNombreCliente">
                                        Verificado
                                    </label>
                                </div>
                            </div>
                            <input type="text" class="form-control" id="nombreCliente" name="nombreCliente" required>
                        </div>
                        
                        <div class="form-group mb-3">
                            <div class="d-flex align-items-center">
                                <label for="direccion" class="form-label fw-bold me-2">3) Dirección:</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="checkDireccion" name="checkDireccion">
                                    <label class="form-check-label" for="checkDireccion">
                                        Verificado
                                    </label>
                                </div>
                            </div>
                            <textarea class="form-control" id="direccion" name="direccion" rows="2" required></textarea>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="movilidad" class="form-label fw-bold">4) Movilidad:</label>
                            <input type="text" class="form-control" id="movilidad" name="movilidad">
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="fechaEjecucion" class="form-label fw-bold">5) Fecha de Ejecución:</label>
                            <input type="date" class="form-control" id="fechaEjecucion" name="fechaEjecucion" required value="<?php echo date('Y-m-d'); ?>">
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="horaEjecucion" class="form-label fw-bold">6) Hora:</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="horaInicio" class="form-label">Hora de Inicio:</label>
                                    <input type="time" class="form-control" id="horaInicio" name="horaInicio" required value="<?php echo date('H:i'); ?>">
                                </div>
                                <div class="col-md-6">
                                    <label for="horaFin" class="form-label">Hora de Finalización:</label>
                                    <input type="time" class="form-control" id="horaFin" name="horaFin" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <hr>
                
                <!-- Datos técnicos y detalles -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5 class="mb-3">7) Datos Técnicos</h5>
                        
                        <div class="form-group mb-3">
                            <label for="tecnico1" class="form-label">Técnico 1:</label>
                            <input type="text" class="form-control" id="tecnico1" name="tecnico1" required>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="tecnico2" class="form-label">Técnico 2:</label>
                            <input type="text" class="form-control" id="tecnico2" name="tecnico2">
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <h5 class="mb-3">Detalles del Trabajo Realizado</h5>
                        
                        <div class="form-group mb-3">
                            <label for="detallesTrabajo" class="form-label">Descripción:</label>
                            <textarea class="form-control" id="detallesTrabajo" name="detallesTrabajo" rows="4"></textarea>
                        </div>
                    </div>
                </div>
                
                <!-- Tipo de trabajo -->
                <div class="mb-4">
                    <h5 class="mb-3">8) Tipo de Trabajo</h5>
                    
                    <div class="row">
                        <?php foreach ($tiposTrabajo as $key => $tipo): ?>
                        <div class="col-md-3 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="tipoTrabajo" id="tipo_<?php echo $key; ?>" value="<?php echo $key; ?>" <?php echo $key === 'instalacion' ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="tipo_<?php echo $key; ?>">
                                    <?php echo $tipo; ?>
                                </label>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <!-- Distritos y cajas -->
                <div class="mb-4">
                    <h5 class="mb-3">9) Ubicación y Puertos</h5>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="distrito" class="form-label">Distrito:</label>
                                <select class="form-select" id="distrito" name="distrito" required>
                                    <option value="">Seleccione distrito...</option>
                                    <?php foreach ($distritos as $key => $distrito): ?>
                                    <option value="<?php echo $key; ?>"><?php echo $distrito; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cajaNAP" class="form-label">Caja NAP:</label>
                                <select class="form-select" id="cajaNAP" name="cajaNAP" disabled>
                                    <option value="">Seleccione primero un distrito</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="puertoNAP" class="form-label">Puerto NAP:</label>
                                <select class="form-select" id="puertoNAP" name="puertoNAP" disabled>
                                    <option value="">Seleccione primero una caja NAP</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="tipoSplitter" class="form-label">Tipo de Splitter:</label>
                                <input type="text" class="form-control" id="tipoSplitter" name="tipoSplitter" readonly>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="atenuacion" class="form-label">Atenuación (dB):</label>
                                <input type="text" class="form-control" id="atenuacion" name="atenuacion" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Materiales -->
                <div class="mb-4">
                    <h5 class="mb-3">10) Materiales Utilizados</h5>
                    
                    <div class="table-responsive mb-3">
                        <table class="table table-bordered" id="materialesTable">
                            <thead class="table-light">
                                <tr>
                                    <th width="10%">N°</th>
                                    <th width="50%">Descripción</th>
                                    <th width="20%">Cantidad</th>
                                    <th width="20%">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>
                                        <input type="text" class="form-control" name="material_desc[]" placeholder="Descripción del material">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" name="material_cant[]" min="1" value="1">
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-danger delete-row">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        
                        <button type="button" id="addMaterial" class="btn btn-sm btn-success">
                            <i class="fas fa-plus me-1"></i> Agregar Material
                        </button>
                    </div>
                    
                    <div class="form-group">
                        <label for="serialRouter" class="form-label fw-bold">Número de Serie / Código de Barras del Router:</label>
                        <div class="input-group mb-2">
                            <input type="text" class="form-control" id="serialRouter" name="serialRouter" placeholder="Ingrese el número de serie o código del router">
                            <button type="button" class="btn btn-primary" id="generateSerial">
                                <i class="fas fa-barcode me-1"></i> Generar Código
                            </button>
                        </div>
                        <div id="barcodeContainer" class="text-center mt-3 mb-3 p-3 border rounded" style="display: none;">
                            <p class="mb-2">Código de barras generado:</p>
                            <svg id="barcodeSVG" class="w-100"></svg>
                            <!-- Contenedor alternativo para cuando no funciona la biblioteca -->
                            <div id="fallbackBarcode" style="display: none;">
                                <div class="bg-white p-3 border">
                                    <div class="d-flex justify-content-between" id="fallbackBarcodeLines"></div>
                                    <div class="mt-2 text-center fw-bold" id="fallbackBarcodeText"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Observaciones -->
                <div class="mb-4">
                    <h5 class="mb-3">11) Observaciones</h5>
                    
                    <div class="form-group">
                        <textarea class="form-control" id="observaciones" name="observaciones" rows="4" placeholder="Ingrese cualquier observación relevante, fallas detectadas, problemas con la atenuación, etc."></textarea>
                    </div>
                </div>
                
                <!-- Botones de acción -->
                <div class="d-flex justify-content-end mt-4">
                    <button type="button" class="btn btn-secondary me-2" id="resetForm">
                        <i class="fas fa-eraser me-2"></i>Limpiar Formulario
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Guardar Hoja Técnica
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- Incluir JsBarcode directamente en esta página -->
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>

<!-- Script para la funcionalidad de la hoja técnica -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Referencias a elementos del DOM
    const distritoSelect = document.getElementById('distrito');
    const cajaNAPSelect = document.getElementById('cajaNAP');
    const puertoNAPSelect = document.getElementById('puertoNAP');
    const tipoSplitterInput = document.getElementById('tipoSplitter');
    const atenuacionInput = document.getElementById('atenuacion');
    const addMaterialBtn = document.getElementById('addMaterial');
    const materialesTable = document.getElementById('materialesTable').getElementsByTagName('tbody')[0];
    const resetFormBtn = document.getElementById('resetForm');
    const hojaTecnicaForm = document.getElementById('hojaTecnicaForm');
    
    // Datos simulados para cajas NAP por distrito
    const distritoCajas = {
        '1': [
            { id: 'NAP001', name: 'NAP001 - Calle Principal' },
            { id: 'NAP002', name: 'NAP002 - Av. Central' }
        ],
        '2': [
            { id: 'NAP003', name: 'NAP003 - Zona Comercial' },
            { id: 'NAP004', name: 'NAP004 - Plaza Norte' }
        ],
        '3': [
            { id: 'NAP005', name: 'NAP005 - Barrio Sur' },
            { id: 'NAP006', name: 'NAP006 - Residencial' }
        ],
        '4': [
            { id: 'NAP007', name: 'NAP007 - Zona Este' },
            { id: 'NAP008', name: 'NAP008 - Industrial' }
        ],
        '5': [
            { id: 'NAP009', name: 'NAP009 - Oeste' },
            { id: 'NAP010', name: 'NAP010 - Parque Central' }
        ]
    };
    
    // Evento cambio de distrito
    distritoSelect.addEventListener('change', function() {
        const distritoId = this.value;
        
        // Limpiar y deshabilitar selects dependientes
        cajaNAPSelect.innerHTML = '';
        puertoNAPSelect.innerHTML = '';
        puertoNAPSelect.disabled = true;
        tipoSplitterInput.value = '';
        atenuacionInput.value = '';
        
        if (!distritoId) {
            cajaNAPSelect.disabled = true;
            cajaNAPSelect.innerHTML = '<option value="">Seleccione primero un distrito</option>';
            return;
        }
        
        // Habilitar select de caja NAP
        cajaNAPSelect.disabled = false;
        cajaNAPSelect.innerHTML = '<option value="">Seleccione una caja NAP...</option>';
        
        // Cargar cajas NAP del distrito seleccionado
        if (distritoCajas[distritoId]) {
            distritoCajas[distritoId].forEach(caja => {
                const option = document.createElement('option');
                option.value = caja.id;
                option.textContent = caja.name;
                cajaNAPSelect.appendChild(option);
            });
        }
    });
    
    // Evento cambio de caja NAP
    cajaNAPSelect.addEventListener('change', function() {
        const cajaId = this.value;
        
        // Limpiar y deshabilitar select de puertos
        puertoNAPSelect.innerHTML = '';
        tipoSplitterInput.value = '';
        atenuacionInput.value = '';
        
        if (!cajaId) {
            puertoNAPSelect.disabled = true;
            puertoNAPSelect.innerHTML = '<option value="">Seleccione primero una caja NAP</option>';
            return;
        }
        
        // Determinar tipo de splitter basado en el ID de NAP (simulación)
        const lastChar = cajaId.slice(-1);
        const lastDigit = parseInt(lastChar) || 0;
        const splitterTypes = ['1:2', '1:4', '1:8', '1:16', '1:32'];
        const splitterType = splitterTypes[lastDigit % splitterTypes.length];
        
        // Mostrar tipo de splitter
        tipoSplitterInput.value = splitterType;
        
        // Simular atenuación
        const attenuation = (10 + Math.random() * 5).toFixed(1);
        atenuacionInput.value = attenuation;
        
        // Habilitar select de puertos
        puertoNAPSelect.disabled = false;
        puertoNAPSelect.innerHTML = '<option value="">Seleccione un puerto...</option>';
        
        // Generar puertos basados en el tipo de splitter
        const numPorts = parseInt(splitterType.split(':')[1]);
        
        for (let i = 1; i <= numPorts; i++) {
            // Simular disponibilidad (para demo)
            const available = Math.random() > 0.7; // 30% disponibles
            
            if (available) {
                const option = document.createElement('option');
                option.value = i;
                option.textContent = `Puerto ${i}`;
                puertoNAPSelect.appendChild(option);
            }
        }
        
        // Si no hay puertos disponibles
        if (puertoNAPSelect.options.length <= 1) {
            const option = document.createElement('option');
            option.value = '';
            option.textContent = 'No hay puertos disponibles';
            option.disabled = true;
            puertoNAPSelect.appendChild(option);
        }
    });
    
    // Agregar fila de material
    addMaterialBtn.addEventListener('click', function() {
        const rowCount = materialesTable.rows.length;
        const row = materialesTable.insertRow();
        
        row.innerHTML = `
            <td>${rowCount + 1}</td>
            <td>
                <input type="text" class="form-control" name="material_desc[]" placeholder="Descripción del material">
            </td>
            <td>
                <input type="number" class="form-control" name="material_cant[]" min="1" value="1">
            </td>
            <td>
                <button type="button" class="btn btn-sm btn-danger delete-row">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        `;
    });
    
    // Eliminar fila de material
    materialesTable.addEventListener('click', function(e) {
        if (e.target.classList.contains('delete-row') || e.target.parentElement.classList.contains('delete-row')) {
            const row = e.target.closest('tr');
            
            // No eliminar si es la única fila
            if (materialesTable.rows.length > 1) {
                row.remove();
                
                // Renumerar las filas
                for (let i = 0; i < materialesTable.rows.length; i++) {
                    materialesTable.rows[i].cells[0].textContent = i + 1;
                }
            }
        }
    });
    
    // Reset del formulario
    resetFormBtn.addEventListener('click', function() {
        if (confirm('¿Está seguro de que desea limpiar el formulario? Todos los datos ingresados se perderán.')) {
            hojaTecnicaForm.reset();
            
            // Restablecer selects dependientes
            cajaNAPSelect.innerHTML = '<option value="">Seleccione primero un distrito</option>';
            cajaNAPSelect.disabled = true;
            puertoNAPSelect.innerHTML = '<option value="">Seleccione primero una caja NAP</option>';
            puertoNAPSelect.disabled = true;
            tipoSplitterInput.value = '';
            atenuacionInput.value = '';
            
            // Restablecer tabla de materiales
            materialesTable.innerHTML = `
                <tr>
                    <td>1</td>
                    <td>
                        <input type="text" class="form-control" name="material_desc[]" placeholder="Descripción del material">
                    </td>
                    <td>
                        <input type="number" class="form-control" name="material_cant[]" min="1" value="1">
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-danger delete-row">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
        }
    });
    
    // Submit del formulario
    hojaTecnicaForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Validación personalizada si es necesario
        
        // Recopilar todos los datos del formulario
        const formData = new FormData(this);
        const formDataObj = {};
        
        // Convertir FormData a objeto para almacenamiento local
        formData.forEach((value, key) => {
            formDataObj[key] = value;
        });
        
        // Generar un ID único para este formulario
        const formId = 'hojaTecnica_' + new Date().getTime();
        
        // Guardar en localStorage
        const savedForms = JSON.parse(localStorage.getItem('hojasTecnicas') || '{}');
        savedForms[formId] = formDataObj;
        localStorage.setItem('hojasTecnicas', JSON.stringify(savedForms));
        
        // Mostrar mensaje de éxito
        alert('Hoja técnica guardada correctamente. ID: ' + formId);
        
        // Opcional: redirigir a la página de soporte
        window.location.href = '<?php echo URL_ROOT; ?>/soporte';
    });
    
    // Botón para generar código de serie del router
    document.getElementById('generateSerial').addEventListener('click', function() {
        const serialInput = document.getElementById('serialRouter');
        const barcodeContainer = document.getElementById('barcodeContainer');
        const serialValue = serialInput.value.trim();
        
        // Verificar que se haya ingresado un valor
        if (!serialValue) {
            alert('Por favor ingrese un número de serie antes de generar el código de barras');
            return;
        }
        
        // Mostrar el contenedor del código de barras
        barcodeContainer.style.display = 'block';
        
        // Limpiar el contenedor SVG para evitar problemas
        const svgElement = document.getElementById('barcodeSVG');
        svgElement.innerHTML = '';
        
        // Ocultar fallback inicialmente
        document.getElementById('fallbackBarcode').style.display = 'none';
        
        try {
            // Verificar si JsBarcode está disponible
            if (typeof JsBarcode === 'undefined') {
                // Si no está disponible, usar el método alternativo
                generateFallbackBarcode(serialValue);
                return;
            }
            
            // Generar el código de barras usando JsBarcode
            JsBarcode("#barcodeSVG", serialValue, {
                format: "CODE128",
                lineColor: "#000",
                width: 2,
                height: 100,
                displayValue: true,
                fontSize: 16,
                margin: 10,
                background: "#ffffff"
            });
            
            console.log("Código de barras generado para: " + serialValue);
        } catch (error) {
            console.error("Error al generar el código de barras:", error);
            
            // Intentar con el método alternativo
            generateFallbackBarcode(serialValue);
        }
    });
    
    // Función para generar un código de barras visual alternativo si JsBarcode falla
    function generateFallbackBarcode(text) {
        const fallbackContainer = document.getElementById('fallbackBarcode');
        const linesContainer = document.getElementById('fallbackBarcodeLines');
        const textDisplay = document.getElementById('fallbackBarcodeText');
        
        // Mostrar el contenedor alternativo
        fallbackContainer.style.display = 'block';
        
        // Ocultar el SVG
        document.getElementById('barcodeSVG').style.display = 'none';
        
        // Limpiar el contenedor de líneas
        linesContainer.innerHTML = '';
        
        // Convertir el texto a una representación visual
        for (let i = 0; i < text.length; i++) {
            const charCode = text.charCodeAt(i);
            
            // Crear un grupo de líneas verticales para cada carácter
            const charContainer = document.createElement('div');
            charContainer.className = 'd-flex mx-1';
            
            // Usar el código ASCII para generar un patrón único para cada carácter
            const numLines = 8 + (charCode % 8); // Entre 8 y 15 líneas
            
            for (let j = 0; j < numLines; j++) {
                const line = document.createElement('div');
                const isBlack = ((charCode + j) % 3 !== 0); // Patrón aleatorio pero consistente
                
                line.style.width = '2px';
                line.style.height = '60px';
                line.style.marginLeft = '1px';
                line.style.backgroundColor = isBlack ? '#000' : '#fff';
                
                charContainer.appendChild(line);
            }
            
            linesContainer.appendChild(charContainer);
        }
        
        // Mostrar el texto debajo del código
        textDisplay.textContent = text;
    }
});
</script> 