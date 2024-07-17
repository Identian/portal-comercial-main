<!DOCTYPE html>
<html>
<head>
    <title>Inactivación de Registros</title>
</head>
<body>
    @if ($activos > 0)
        <p>Buen día, el presente correo es para informarles que todas las ordenes de compra han sido inactivadas</p>
        <p>Total de Ordenes inactivadas : <b>{{ $activos}}</b></p>
    @else
        <p>Buen día, el presente correo es para informarles que no se encontraron ordenes de compra activas</p>
        <p>Total de Ordenes activas : <b>0</b></p>
    @endif
</body>
</html>
