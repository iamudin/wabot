<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Verifikasi Dokumen Resmi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f3f6fa;
            padding: 20px;
        }

        .card {
            max-width: 500px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .success {
            color: #2ecc71;
            font-size: 20px;
            font-weight: bold;
        }

        .info {
            margin-top: 15px;
            text-align: left;
        }

        .badge {
            display: inline-block;
            background: #27ae60;
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 13px;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="card">

    <img src="https://cdn-icons-png.flaticon.com/512/190/190411.png" width="80">

    <p class="success">
        ✅ DOKUMEN RESMI TERVERIFIKASI
    </p>

    <p>
        Dokumen ini telah <b>ditandatangani secara elektronik</b> dan <b>diterbitkan oleh Pemerintah Desa Tameran</b>.
    </p>

    <span class="badge">
        Tanda Tangan Elektronik Aktif
    </span>

    <div class="info">
        <hr>

        <p><b>Kode Dokumen:</b> {{ $data->kode_tiket }}</p>
        <p><b>Jenis Surat:</b> {{ $data->layanan->nama_layanan }}</p>
        <p><b>Desa:</b> Tameran</p>
        <p><b>Tanggal Terbit:</b> {{ $data->ditandatangani_pada->format('d F Y H:i') }}</p>

    </div>

</div>

</body>
</html>
