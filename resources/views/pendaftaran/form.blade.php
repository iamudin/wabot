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
            <input type="text" name="nik" required maxlength="16" minlength="16" style="width:100%;padding:8px">

            <label>Nama Lengkap</label>
            <input type="text" name="nama" required style="width:100%;padding:8px">
            <label>Tempate Tanggal Lahir</label>
            <input type="text" name="tempat_tanggal_lahir" required style="width:100%;padding:8px">
            <label>Jenis Kelamin</label>
            <input type="text" name="jenis_kelamin" required style="width:100%;padding:8px">
            <label>Alamat Lengkap</label>
            <textarea name="alamat" required style="width:100%;padding:8px"></textarea>
            <label>RT</label>
            <input type="text" name="rt" required style="width:100%;padding:8px">
            <label>RW</label>
            <input type="text" name="rw" required style="width:100%;padding:8px">
            <label>Agama</label>
            <input type="text" name="agama" required style="width:100%;padding:8px">
            <label>Kewarganegaraan</label>
            <input type="text" name="kewarganegaraan" required style="width:100%;padding:8px">
            <label>Pekerjaan</label>
            <input type="text" name="pekerjaan" required style="width:100%;padding:8px">
            <label>Status Kawin</label>
            <input type="text" name="status_kawin" required style="width:100%;padding:8px">
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
