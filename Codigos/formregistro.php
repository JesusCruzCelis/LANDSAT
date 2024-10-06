<?php
// Iniciar sesión para leer el mensaje de error
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - LandSat Project</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="/LANDSAT/css/Registros.css">
</head>
<body> 
    <h1>Registro</h1>

    <!-- Mostrar mensaje de error si existe -->
    <?php if (isset($_SESSION['error'])): ?>
        <p class="error-message"><?php echo $_SESSION['error']; ?></p>
        <?php unset($_SESSION['error']); // Eliminar el mensaje de error después de mostrarlo ?>
    <?php endif; ?>

    <form action="register.php" method="POST" id="registrationForm">
        <!-- Nombre -->
        <div>
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>
        </div>

        <!-- Email -->
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>

        <!-- Número (máximo 10 dígitos) -->
        <div>
            <label for="numero">Número de Teléfono:</label>
            <input type="number" id="numero" name="numero" required min="1000000000" max="9999999999" maxlength="10" oninput="validateMaxLength(this)">
        </div>

        <!-- Preferencia de notificación (email o teléfono) -->
        <div>
            <label for="pref_noti">¿Cómo prefieres que te contactemos?</label>
            <select id="pref_noti" name="pref_noti" required>
                <option value="email">Email</option>
                <option value="telefono">Teléfono</option>
            </select>
        </div>

        <!-- Contraseña -->
        <div>
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>
        </div>

        <!-- Rango de horario de notificación -->
        <div>
            <label for="notificationTimeStart">Horario de notificación (inicio):</label>
            <input type="time" id="notificationTimeStart" name="notificationTimeStart" required>
        </div>

        <div>
            <label for="notificationTimeEnd">Horario de notificación (fin):</label>
            <input type="time" id="notificationTimeEnd" name="notificationTimeEnd" required>
        </div>

        <!-- Mapa para seleccionar ubicación -->
        <div>
            <label>Selecciona tu ubicación:</label>
            <div id="map" style="height: 300px;"></div>
            <span class="error-message" id="locationError">Por favor, selecciona una ubicación en el mapa.</span>
        </div>

        <!-- Mostrar latitud y longitud debajo del mapa -->
        <div id="latLonDisplay">Latitud: --, Longitud: --</div>

        <!-- Campos ocultos para guardar latitud y longitud -->
        <input type="hidden" id="latitud" name="latitud" required pattern="\-?\d+(\.\d+)?" title="Introduce un número válido">
        <input type="hidden" id="longitud" name="longitud" required pattern="\-?\d+(\.\d+)?" title="Introduce un número válido">

        <button type="submit">Registrarse</button>
    </form>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        // Validar longitud máxima de dígitos en el campo número
        function validateMaxLength(element) {
            if (element.value.length > 10) {
                element.value = element.value.slice(0, 10);
            }
        }

        var map = L.map('map').setView([20.0, -90.0], 5);

        // Agregar capa de fondo de OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        var marker;

        // Manejar clic en el mapa para seleccionar ubicación
        map.on('click', function(e) {
            var lat = e.latlng.lat;
            var lon = e.latlng.lng;

            if (marker) {
                map.removeLayer(marker);
            }

            marker = L.marker([lat, lon]).addTo(map);
            document.getElementById('latitud').value = lat;
            document.getElementById('longitud').value = lon;

            document.getElementById('latLonDisplay').textContent = `Latitud: ${lat.toFixed(6)}, Longitud: ${lon.toFixed(6)}`;
            document.getElementById('locationError').style.display = "none";
        });

        document.getElementById('registrationForm').addEventListener('submit', function(event) {
            var latitud = document.getElementById('latitud').value;
            var longitud = document.getElementById('longitud').value;

            if (!latitud || !longitud) {
                event.preventDefault();
                document.getElementById('locationError').style.display = "block";
            }
        });
    </script> 
    <a href="index.php" class="button">Regresar al menú principal</a>
</body>
</html>
