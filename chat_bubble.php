<?php

$esPremium = isset($_SESSION['plan_activo']) && $_SESSION['plan_activo'] !== 'básico';
$archivo_dudas = __DIR__ . '/dudas.json';

// Procesar nueva duda, edición o eliminación
if ($esPremium && isset($_POST['accion'])) {
    $dudas = file_exists($archivo_dudas) ? json_decode(file_get_contents($archivo_dudas), true) : [];
    
    // Eliminar duda
    if ($_POST['accion'] === 'eliminar' && !empty($_POST['id'])) {
        $dudas = array_filter($dudas, function($duda) {
            return $duda['id'] !== $_POST['id'];
        });
        $accion = 'eliminada';
    }
    // Editar duda
    elseif ($_POST['accion'] === 'editar' && !empty($_POST['id']) && !empty($_POST['duda_mensaje'])) {
        foreach ($dudas as &$duda) {
            if ($duda['id'] === $_POST['id'] && $duda['estado'] === 'pendiente') {
                $duda['mensaje'] = htmlspecialchars(trim($_POST['duda_mensaje']));
                $duda['fecha'] = date('Y-m-d H:i:s');
                break;
            }
        }
        $accion = 'actualizada';
    }
    // Nueva duda
    elseif ($_POST['accion'] === 'nueva' && !empty($_POST['duda_mensaje'])) {
        $nuevaDuda = [
            'id' => uniqid(),
            'usuario' => $_SESSION['nombre_usuario'],
            'mensaje' => htmlspecialchars(trim($_POST['duda_mensaje'])),
            'fecha' => date('Y-m-d H:i:s'),
            'respuesta' => null,
            'fecha_respuesta' => null,
            'estado' => 'pendiente'
        ];
        $dudas[] = $nuevaDuda;
        $accion = 'enviada';
    }
    
    file_put_contents($archivo_dudas, json_encode($dudas, JSON_PRETTY_PRINT));
    
    echo "<script>
        alert('Tu duda ha sido {$accion} correctamente.');
        resetForm();
    </script>";
}

function escapeJs($string) {
    return addslashes($string);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soporte Premium</title>
    <link rel="stylesheet" href="css/chatB.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  
</head>
<body>
<?php if($esPremium): ?>
<!-- Burbuja y panel de chat -->
<div class="chat-bubble" id="chatBubble">
    <i class="fas fa-headset"></i>
</div>

<div class="chat-panel" id="chatPanel">
    <h4 style="color: #50008b;"><i class="fas fa-headset"></i> Asesoría Premium</h4>
    
    <!-- Buscador -->
    <div class="search-container">
        <input type="text" id="searchInput" class="search-input" placeholder="Buscar en mis dudas...">
        <i class="fas fa-search search-icon"></i>
    </div>
    
    <!-- Sección para enviar nuevas dudas -->
    <div id="nuevaConsulta">
        <p class="duda">¿Necesitas ayuda con algún problema matemático?</p>
        <form method="post" id="asesoriaForm">
            <input type="hidden" name="accion" id="accion" value="nueva">
            <input type="hidden" name="editar_id" id="editar_id" value="">
            <textarea name="duda_mensaje" id="duda_mensaje" placeholder="Describe tu duda..." required></textarea>
            <button type="submit" class="btn-enviar" id="formButton">Enviar</button>
        </form>
    </div>
    
    <!-- Sección para ver respuestas -->
    <div id="respuestasContainer" style="margin-top: 20px; display: none;">
        <h5 style="color: #50008b;"><i class="fas fa-reply"></i> Mis consultas</h5>
        <div id="respuestasLista"></div>
        <div id="noResults" class="no-results" style="display: none;">No se encontraron resultados</div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const chatBubble = document.getElementById('chatBubble');
    const chatPanel = document.getElementById('chatPanel');
    const formButton = document.getElementById('formButton');
    const editIdField = document.getElementById('editar_id');
    const accionField = document.getElementById('accion');
    const dudaMensajeField = document.getElementById('duda_mensaje');
    const searchInput = document.getElementById('searchInput');
    const noResultsDiv = document.getElementById('noResults');
    
    // Mostrar/ocultar panel
    chatBubble.addEventListener('click', function() {
        chatPanel.style.display = chatPanel.style.display === 'block' ? 'none' : 'block';
        if(chatPanel.style.display === 'block') {
            cargarRespuestas();
        }
    });
    
    // Cargar respuestas existentes
    function cargarRespuestas(busqueda = '') {
        fetch('obtener_respuestas.php')
            .then(response => response.json())
            .then(data => {
                const container = document.getElementById('respuestasLista');
                container.innerHTML = '';
                
                // Filtrar por búsqueda si existe
                if(busqueda) {
                    const searchTerm = busqueda.toLowerCase();
                    data = data.filter(duda => 
                        duda.mensaje.toLowerCase().includes(searchTerm) || 
                        (duda.respuesta && duda.respuesta.toLowerCase().includes(searchTerm))
                    );
                }
                
                if(data.length > 0) {
                    document.getElementById('respuestasContainer').style.display = 'block';
                    noResultsDiv.style.display = 'none';
                    
                    data.forEach(respuesta => {
                        const div = document.createElement('div');
                        div.className = 'respuesta-item';
                        
                        let actions = '';
                        if(respuesta.estado === 'pendiente') {
                            actions = `
                                <div class="duda-actions">
                                    <button class="edit-btn" onclick="editarDuda('${respuesta.id}', '${escapeHtml(respuesta.mensaje)}')">
                                        <i class="fas fa-edit"></i> Editar
                                    </button>
                                    <button class="delete-btn" onclick="eliminarDuda('${respuesta.id}')">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </button>
                                </div>
                            `;
                        }
                        
                        div.innerHTML = `
                            <div class="duda-header">
                                <span>Tu duda:</span>
                                <span class="duda-date">${respuesta.fecha}</span>
                            </div>
                            <div class="duda-text">${respuesta.mensaje}</div>
                            ${actions}
                            ${respuesta.respuesta ? `
                                <div class="duda-header" style="margin-top: 15px;">
                                    <span>Respuesta:</span>
                                    <span class="duda-date">${respuesta.fecha_respuesta}</span>
                                </div>
                                <div class="respuesta-text">${respuesta.respuesta}</div>
                            ` : '<p style="color: #6c757d; font-style: italic; margin-top: 10px;">En espera de respuesta...</p>'}
                        `;
                        container.appendChild(div);
                    });
                } else {
                    document.getElementById('respuestasContainer').style.display = 'block';
                    noResultsDiv.style.display = data.length === 0 && busqueda ? 'block' : 'none';
                }
            })
            .catch(error => console.error('Error:', error));
    }
    
    // Función para escapar HTML
    function escapeHtml(unsafe) {
        return unsafe
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }
    
    // Función para editar duda
    window.editarDuda = function(id, mensaje) {
        editIdField.value = id;
        accionField.value = 'editar';
        dudaMensajeField.value = unescapeHtml(mensaje);
        formButton.textContent = 'Actualizar';
        dudaMensajeField.focus();
        chatPanel.scrollTo(0, 0);
    }
    
    // Función para desescapar HTML
    function unescapeHtml(safe) {
        return safe
            .replace(/&amp;/g, "&")
            .replace(/&lt;/g, "<")
            .replace(/&gt;/g, ">")
            .replace(/&quot;/g, '"')
            .replace(/&#039;/g, "'");
    }
    
    // Función para eliminar duda
    window.eliminarDuda = function(id) {
        if(confirm('¿Estás seguro de que quieres eliminar esta duda?')) {
            const formData = new FormData();
            formData.append('accion', 'eliminar');
            formData.append('id', id);
            
            fetch('', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if(response.ok) {
                    resetForm();
                    cargarRespuestas(searchInput.value);
                }
            })
            .catch(error => console.error('Error:', error));
        }
    }
    
    // Reset completo del formulario
    window.resetForm = function() {
        document.getElementById('asesoriaForm').reset();
        editIdField.value = '';
        accionField.value = 'nueva';
        formButton.textContent = 'Enviar';
        dudaMensajeField.focus();
    }
    
    // Enviar formulario
    document.getElementById('asesoriaForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        
        fetch('', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if(response.ok) {
                resetForm();
                cargarRespuestas(searchInput.value);
            }
        })
        .catch(error => console.error('Error:', error));
    });
    
    // Buscador
    searchInput.addEventListener('input', function() {
        cargarRespuestas(this.value);
    });
});
</script>
<?php endif; ?>
</body>
</html>