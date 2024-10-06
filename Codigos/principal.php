<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landsat Data Display</title>
    <link rel="stylesheet" href="/LANDSAT/css/principal.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            display: flex;
            justify-content: space-between;
        }
        .metadata-section, .image-section, .user-options {
            margin-right: 20px;
        }
        .satellite-info {
            margin-top: 20px;
        }
        h2 {
            border-bottom: 1px solid #ccc;
        }
        ul {
            list-style-type: none;
        }
        li {
            margin: 5px 0;
        }
        form {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Sección para mostrar la imagen de Landsat -->
    <div class="image-section">
        <h2>Imagen del Landsat</h2>
        <img src="/LANDSAT/Imagenes/delta_ii-300x233-1.jpg" alt="Imagen del Landsat" width="300">
    </div>

    <!-- Sección para mostrar los metadatos -->
    <div class="metadata-section">
        <h2>Metadatos del Landsat</h2>
        <ul>
            <li><strong>Producto ID:</strong> LE07_L1TP_029030_20010719_20191001_02_T1</li>
            <li><strong>Número de colección:</strong> 02</li>
            <li><strong>Fecha de adquisición:</strong> 2001-07-19</li>
            <li><strong>Cobertura de nubes:</strong> 9%</li>
            <li><strong>Proyección:</strong> UTM, Zona 14, Datum WGS84</li>
            <li><strong>Azimut solar:</strong> 131.35°</li>
            <li><strong>Elevación solar:</strong> 60.18°</li>
            <li><strong>Ruta/Fila:</strong> 29/30</li>
            <li><strong>Latitud/Longitud:</strong> 44.17°N, -98.65°W</li>
            <!-- Puedes agregar más metadatos aquí -->
        </ul>
    </div>
</div>

<!-- Sección para especificar las opciones del usuario -->
<div class="user-options">
    <h2>Opciones de consulta de Landsat</h2>
    <form method="post" action="process_request.php">
        <label for="recent-only">Acceso solo a adquisición más reciente:</label>
        <input type="checkbox" id="recent-only" name="recent-only"><br><br>

        <label for="start-date">Fecha de inicio:</label>
        <input type="date" id="start-date" name="start-date"><br><br>

        <label for="end-date">Fecha de finalización:</label>
        <input type="date" id="end-date" name="end-date"><br><br>

        <button type="submit">Consultar Landsat</button>
    </form>
</div>

<!-- Sección para mostrar datos Landsat SR -->
<div class="landsat-sr">
    <h2>Datos Landsat SR y Temperatura de la Superficie</h2>
    <ul>
        <li><strong>Temperatura de superficie (infrarrojo térmico):</strong> 298.15 K</li>
        <li><strong>Radiancia máxima en la banda 4:</strong> 241.1</li>
        <li><strong>Reflectancia mínima en la banda 5:</strong> -0.014</li>
        <!-- Agregar otros datos según sea necesario -->
    </ul>
</div>

<!-- Gráfico de la firma espectral -->
<div class="spectral-signature">
    <h2>Firma Espectral (Gráfico)</h2>
    <!-- Aquí se integraría un gráfico usando una librería como Chart.js o similar -->
    <img src="/LANDSAT/Imagenes/firma_espectral_landsat.png" alt="Gráfico de firma espectral" width="300">
</div>

<!-- Opción para descargar o compartir datos -->
<div class="download-options">
    <h2>Descargar o Compartir Datos</h2>
    <form method="post" action="download_data.php">
        <button type="submit" name="format" value="csv">Descargar CSV</button>
        <button type="submit" name="format" value="share">Compartir Datos</button>
    </form>
</div>

</body>
</html>
