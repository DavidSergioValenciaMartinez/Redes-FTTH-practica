/**
 * FiberNet Pro - Archivo JavaScript principal
 */
document.addEventListener('DOMContentLoaded', function() {
    // Crear el icono fa-chart-network (no está en versiones gratuitas de Font Awesome)
    if (!document.getElementById('chart-network-icon')) {
        // Añadir icono personalizado para fa-chart-network
        const style = document.createElement('style');
        style.id = 'chart-network-icon';
        style.innerHTML = `
            .fa-chart-network:before {
                content: "\\f6ff"; /* Usar código de fa-network-wired como alternativa */
            }
        `;
        document.head.appendChild(style);
    }

    // Cambiar entre secciones
    const sectionLinks = document.querySelectorAll('.nav-link[data-section]');
    
    if (sectionLinks.length > 0) {
        sectionLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                // La navegación ahora se maneja con enlaces reales, así que esto ya no es necesario
                // Sin embargo, podemos agregar alguna animación al hacer clic
                
                // Remover clase activa de todos los enlaces
                sectionLinks.forEach(link => {
                    link.classList.remove('active');
                });
                
                // Agregar clase activa al enlace actual
                this.classList.add('active');
            });
        });
    }
    
    // Cambiar estilo
    const toggleStyleBtn = document.getElementById('toggleStyle');
    
    if (toggleStyleBtn) {
        toggleStyleBtn.addEventListener('click', function() {
            document.body.classList.toggle('alt-style');
            
            // Guardar preferencia en cookie
            if (document.body.classList.contains('alt-style')) {
                document.cookie = "alt_style=1; path=/; max-age=2592000"; // 30 días
            } else {
                document.cookie = "alt_style=; path=/; max-age=0"; // Eliminar cookie
            }
        });
    }
    
    // Formulario de login
    const loginForm = document.getElementById('loginForm');
    
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            // No necesitamos prevenir el envío, ya que el formulario se enviará al controlador
            // Solo podemos agregar validación adicional si es necesario
            
            const email = document.getElementById('loginEmail').value;
            const password = document.getElementById('loginPassword').value;
            
            if (!email || !password) {
                e.preventDefault();
                alert('Por favor, complete todos los campos requeridos.');
                return false;
            }
        });
    }
    
    // Formulario de registro
    const registerForm = document.getElementById('registerForm');
    
    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            const password = document.getElementById('registerPassword').value;
            const confirmPassword = document.getElementById('registerPasswordConfirm').value;
            
            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Las contraseñas no coinciden. Por favor, verifíquelas.');
                return false;
            }
        });
    }
    
    // Verificar NAP para calculadora
    const napVerificationForm = document.getElementById('napVerificationForm');
    
    if (napVerificationForm) {
        napVerificationForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const napId = document.getElementById('napId').value;
            
            if (napId.trim() !== "" && napId.toLowerCase().startsWith('nap-')) {
                document.getElementById('napAlert').style.display = 'none';
                document.getElementById('splitterCalculator').style.display = 'block';
            } else {
                alert('Por favor, ingrese un ID de NAP válido (debe comenzar con "NAP-")');
            }
        });
    }
    
    // Cálculo de splitter
    const calculateBtn = document.getElementById('calculateBtn');
    
    if (calculateBtn) {
        calculateBtn.addEventListener('click', function() {
            // Obtener valores
            const inputPower = parseFloat(document.getElementById('inputPower').value || 0);
            const fiberLength = parseFloat(document.getElementById('fiberLength').value || 5000);
            const connectors = parseInt(document.getElementById('connectors').value || 4);
            
            // Añadir campos adicionales requeridos para los nuevos cálculos
            const fusiones = parseInt(document.getElementById('fusiones').value || 6);
            const cajaActualSplitters = document.getElementById('cajaActualSplitters').value || '';
            const cajasAnterioresSplitters = document.getElementById('cajasAnterioresSplitters').value || '';
            
            // Cálculos según fórmulas especificadas
            
            // 1) Atenuación cable = distancia cable/1000m * 0.2
            const atenuacionCable = (fiberLength / 1000) * 0.2;
            
            // 2) Atenuación acopladores = número acopladores * 0.5
            const atenuacionAcopladores = connectors * 0.5;
            
            // 3) Atenuación fusiones = número de fusiones * 0.03
            const atenuacionFusiones = fusiones * 0.03;
            
            // 4) Atenuación splitter según valores específicos
            let atenuacionSplitter = 0;
            
            // Mapeo de valores específicos para cada tipo de splitter
            const splitterValues = {
                "1:2": 3.6,
                "1:4": 7.2,
                "1:8": 11.0,
                "1:16": 14.0,
                "1:32": 17.5
            };
            
            // Procesar splitters de la caja actual
            if (cajaActualSplitters) {
                const currentSplitters = cajaActualSplitters.split(',').map(s => s.trim());
                currentSplitters.forEach(splitter => {
                    if (splitterValues[splitter]) {
                        atenuacionSplitter += splitterValues[splitter];
                    }
                });
            }
            
            // Procesar splitters de cajas anteriores
            if (cajasAnterioresSplitters) {
                const previousSplitters = cajasAnterioresSplitters.split(',').map(s => s.trim());
                previousSplitters.forEach(splitter => {
                    if (splitterValues[splitter]) {
                        atenuacionSplitter += splitterValues[splitter];
                    }
                });
            }
            
            // 5) Atenuación total = Suma de todas las atenuaciones - 5dBm
            const atenuacionTotal = atenuacionCable + atenuacionAcopladores + atenuacionFusiones + atenuacionSplitter;
            const potenciaSalida = inputPower - atenuacionTotal - 5;
            
            // Calcular los valores adicionales solicitados
            const insertionLoss = 13.5; // Valor fijo solicitado
            
            // Pérdida por fibra (calculada como atenuación de cable para consistencia)
            const fiberLoss = atenuacionCable;
            
            // Pérdida por conectores (calculada como atenuación de acopladores para consistencia)
            const connectorLoss = atenuacionAcopladores;
            
            // Pérdida total (para mostrarla como valor adicional)
            const totalLoss = atenuacionTotal;
            
            // Aplicar el ajuste constante a la pérdida total para el cálculo final
            const totalLossAdjusted = atenuacionTotal - 5;
            
            // Determinar margen de potencia con más detalles
            let powerMargin, powerMarginClass;
            
            // Criterio basado en la pérdida total ajustada (<=26dBm es aceptable, >26dBm es crítico)
            if (totalLossAdjusted <= 26) {
                powerMargin = "Aceptable";
                powerMarginClass = "text-success";
            } else {
                powerMargin = "Crítico";
                powerMarginClass = "text-danger fw-bold";
            }
            
            // Mostrar resultados
            document.getElementById('atenuacionCable').textContent = atenuacionCable.toFixed(2);
            document.getElementById('atenuacionAcopladores').textContent = atenuacionAcopladores.toFixed(2);
            document.getElementById('atenuacionFusiones').textContent = atenuacionFusiones.toFixed(2);
            document.getElementById('atenuacionSplitter').textContent = atenuacionSplitter.toFixed(2);
            document.getElementById('atenuacionTotal').textContent = atenuacionTotal.toFixed(2);
            document.getElementById('ajusteConstante').textContent = "-5.00";
            document.getElementById('potenciaSalida').textContent = potenciaSalida.toFixed(2);
            
            // Mostrar los valores adicionales
            document.getElementById('insertionLoss').textContent = insertionLoss.toFixed(1);
            document.getElementById('fiberLoss').textContent = fiberLoss.toFixed(2);
            document.getElementById('connectorLoss').textContent = connectorLoss.toFixed(2);
            document.getElementById('totalLoss').textContent = totalLossAdjusted.toFixed(2);
            
            const powerMarginElement = document.getElementById('powerMargin');
            powerMarginElement.textContent = powerMargin;
            powerMarginElement.className = powerMarginClass;
            
            // Mostrar contenedor de resultados
            document.getElementById('resultContainer').style.display = 'block';
            
            // Generar y mostrar la tabla de puertos
            generatePortTable(potenciaSalida, atenuacionTotal);
        });
    }
    
    // Funciones del chat de soporte
    const sendMessageBtn = document.getElementById('sendMessage');
    
    if (sendMessageBtn) {
        const chatContainer = document.getElementById('chatContainer');
        const chatMessageInput = document.getElementById('chatMessage');
        
        // Función para enviar mensaje
        function sendChatMessage() {
            const message = chatMessageInput.value.trim();
            
            if (message) {
                // Crear el mensaje del usuario
                const userMessageDiv = document.createElement('div');
                userMessageDiv.className = 'chat-message user';
                userMessageDiv.innerHTML = `
                    <div class="fw-bold">Tú</div>
                    ${message}
                `;
                
                // Agregar al chat
                chatContainer.appendChild(userMessageDiv);
                
                // Limpiar input
                chatMessageInput.value = '';
                
                // Hacer scroll al final del chat
                chatContainer.scrollTop = chatContainer.scrollHeight;
                
                // Simular respuesta después de un breve retraso
                setTimeout(() => {
                    const responses = [
                        "Estamos revisando su consulta. En breve le atenderá un técnico especializado.",
                        "Gracias por su mensaje. ¿Podría proporcionarnos más detalles sobre el problema que está experimentando?",
                        "Entendido. Le recomendamos verificar primero la conexión física del equipo.",
                        "Esa información es útil. ¿Ha intentado reiniciar el dispositivo?",
                        "Estamos procesando su solicitud. Uno de nuestros técnicos se pondrá en contacto con usted a la brevedad."
                    ];
                    
                    const randomResponse = responses[Math.floor(Math.random() * responses.length)];
                    
                    const supportMessageDiv = document.createElement('div');
                    supportMessageDiv.className = 'chat-message support';
                    supportMessageDiv.innerHTML = `
                        <div class="fw-bold">Soporte Técnico</div>
                        ${randomResponse}
                    `;
                    
                    chatContainer.appendChild(supportMessageDiv);
                    
                    // Scroll al final del chat nuevamente
                    chatContainer.scrollTop = chatContainer.scrollHeight;
                }, 1000);
            }
        }
        
        // Enviar con botón
        sendMessageBtn.addEventListener('click', sendChatMessage);
        
        // Enviar con Enter
        chatMessageInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                sendChatMessage();
            }
        });
    }
}); 