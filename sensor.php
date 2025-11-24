<?php
header('Content-Type: text/html; charset=utf-8');

$usuario = "root";
$contrasena = "";
$servidor = "localhost";
$basededatos = "proyecto";

$con = mysqli_connect($servidor, $usuario, $contrasena, $basededatos);
mysqli_set_charset($con, "utf8");

// Obtener último estado y estadísticas básicas
$ultimo = mysqli_query($con, "SELECT * FROM datos ORDER BY fecha DESC LIMIT 1");
$ultimo_dato = mysqli_fetch_assoc($ultimo);

$total = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) as total FROM datos"))['total'];

mysqli_close($con);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyecto IoT - Control y Monitoreo</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            max-width: 500px;
            width: 100%;
            text-align: center;
        }
        h1 { color: #333; margin-bottom: 10px; font-size: 2em; }
        .subtitle { color: #666; margin-bottom: 30px; }
        .status {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
        }
        .status-value {
            font-size: 3em;
            margin: 10px 0;
        }
        .btn {
            display: inline-block;
            padding: 15px 30px;
            margin: 10px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: bold;
            transition: transform 0.2s;
            color: white;
        }
        .btn:hover { transform: translateY(-2px); }
        .btn-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .btn-success { background: linear-gradient(135deg, #56ab2f 0%, #a8e063 100%); }
        .stats {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 2px solid #eee;
        }
        .stat-item { text-align: center; }
        .stat-number { font-size: 2em; color: #667eea; font-weight: bold; }
        .stat-label { color: #666; font-size: 0.9em; }
    </style>
</head>
<body>
    <div class="card">
        <h1>🌐 Proyecto IoT</h1>
        <p class="subtitle">Control y Monitoreo en Tiempo Real</p>
        
        <?php if ($ultimo_dato): ?>
        <div class="status">
            <h3>📊 Estado Actual</h3>
            <div class="status-value">
                <?php
                switch($ultimo_dato['valor']) {
                    case 0: echo "🔴 APAGADO"; break;
                    case 1: echo "🟢 ENCENDIDO"; break;
                    case 2: echo "🔵 INTERMITENTE"; break;
                }
                ?>
            </div>
            <small><?= $ultimo_dato['fecha'] ?></small>
        </div>
        <?php endif; ?>
        
        <div>
            <a href="proyecto.php" class="btn btn-primary">🎮 Control API</a>
            <a href="ver_datos.php" class="btn btn-success">📈 Ver Historial</a>
        </div>
        
        <div class="stats">
            <div class="stat-item">
                <div class="stat-number"><?= $total ?></div>
                <div class="stat-label">Registros</div>
            </div>
            <div class="stat-item">
                <div class="stat-number"><?= $ultimo_dato ? $ultimo_dato['valor'] : '-' ?></div>
                <div class="stat-label">Último Valor</div>
            </div>
        </div>
    </div>
</body>
</html>