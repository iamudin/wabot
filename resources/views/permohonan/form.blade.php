<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Permohonan Surat Keterangan Tidak Mampu</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            margin: auto;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 12px;
        }

        input,
        textarea,
        select {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        button {
            margin-top: 20px;
            width: 100%;
            padding: 12px;
            background: #0d6efd;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background: #0b5ed7;
        }

        .note {
            font-size: 13px;
            color: #666;
            margin-top: 15px;
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Permohonan Surat Keterangan Tidak Mampu</h2>

        <form method="POST" action="{{ url('/form-permohonan/sktm') }}">
            @csrf

            <!-- TOKEN WAJIB -->
            <input type="hidden" name="token" value="{{ $token }}">

            <label>NIK</label>
            <input type="text" name="nik" required maxlength="16" placeholder="Contoh: 1402xxxxxxxxxxxx">

            <label>Nama Lengkap</label>
            <input type="text" name="nama" required>

            <label>Tempat, Tanggal Lahir</label>
            <input type="text" name="ttl" required placeholder="Contoh: Bengkalis, 12-05-1998">

            <label>Jenis Kelamin</label>
            <select name="jenis_kelamin" required>
                <option value="">-- Pilih --</option>
                <option value="L">Laki-laki</option>
                <option value="P">Perempuan</option>
            </select>

            <label>Pekerjaan</label>
            <input type="text" name="pekerjaan" required>

            <label>Alamat Lengkap</label>
            <textarea name="alamat" rows="3" required></textarea>

            <label>Keperluan SKTM</label>
            <textarea name="keperluan" rows="3" required
                placeholder="Contoh: Persyaratan bantuan pendidikan"></textarea>

            <label>Nomor WhatsApp Aktif</label>
            <input type="text" name="no_wa" required placeholder="08xxxxxxxxxx">

            <button type="submit">Kirim Permohonan</button>
        </form>

        <div class="note">
            ⏳ Link ini hanya berlaku satu kali dan memiliki batas waktu.
        </div>
    </div>

</body>

</html>