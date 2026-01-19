<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Pendaftaran Penduduk</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body style="font-family:Arial;background:#f4f6f8;padding:20px">

    <div style="max-width:500px;background:#fff;padding:20px;border-radius:8px;margin:auto">

        <h3 style="text-align:center">Pendaftaran Penduduk Desa</h3>

        <form method="POST" action="{{ url('/pendaftaran-submit') }}" enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <label>NIK</label>
            <input type="text" name="nik" required maxlength="16" style="width:100%;padding:8px">

            <label>Nama Lengkap</label>
            <input type="text" name="nama" required style="width:100%;padding:8px">

            <label>Alamat Lengkap</label>
            <textarea name="alamat" required style="width:100%;padding:8px"></textarea>

            <label>Upload Foto KTP</label>
            <input type="file" name="ktp" required accept="image/*">

            <button type="submit"
                style="margin-top:15px;width:100%;padding:10px;background:#0d6efd;color:#fff;border:none">
                Daftar
            </button>
        </form>

    </div>
</body>

</html>