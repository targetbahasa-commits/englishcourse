<!DOCTYPE html>
<html>
<head>
    <title>Pendaftaran Baru: {{ $lead->full_name }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

</head>
<body>
    <h2>Halo Admin, ada pendaftaran baru!</h2>
    <p>Berikut adalah detail pendaftaran:</p>
    <ul>
        <li><strong>Nama:</strong> {{ $lead->full_name }}</li>
        <li><strong>WhatsApp:</strong> {{ $lead->whatsapp }}</li>
        <li><strong>Email:</strong> {{ $lead->email ?? '-' }}</li>
        <li><strong>Kota:</strong> {{ $lead->city }}</li>
        <li><strong>Program:</strong> {{ $lead->program->name ?? '-' }}</li>
        <li><strong>Batch:</strong> {{ $lead->classPeriod->name ?? '-' }}</li>
        <li><strong>Mode:</strong> {{ $lead->mode }}</li>
        <li><strong>Profesi:</strong> {{ $lead->profession }}</li>
    </ul>
    <p>Silakan cek di dashboard admin untuk melihat detail lebih lanjut.</p>
</body>
</html>
