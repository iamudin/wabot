<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan Tidak Mampu</title>
    
    <style>
        @page {
    margin-top: 10mm;
    margin-bottom: 10mm;
    margin-left: 10mm;
    margin-right: 10mm;
}
        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 12pt;
            margin: 40px;
            color: #000;
        }

        .kop-surat {
            text-align: center;
            border-bottom: 3px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .kop-surat img {
            width: 80px;
            position: absolute;
            left: 40px;
            top: 40px;
        }

        .kop-surat h1 {
            font-size: 16pt;
            margin: 0;
            font-weight: bold;
        }

        .kop-surat h2 {
            font-size: 14pt;
            margin: 0;
        }

        .kop-surat p {
            margin: 2px 0;
            font-size: 11pt;
        }

        .judul {
            text-align: center;
            margin-top: 20px;
        }

        .judul h3 {
            margin: 0;
            text-decoration: underline;
        }

        .judul p {
            margin-top: 5px;
        }

        table {
            width: 100%;
            margin-top: 15px;
            border-collapse: collapse;
        }

        td {
            padding: 4px;
            vertical-align: top;
        }

        .label {
            width: 180px;
        }

        .isi {
            text-align: justify;
            margin-top: 15px;
            line-height: 1.6;
        }

        .ttd {
            width: 100%;
            margin-top: 40px;
        }

        .ttd td {
            text-align: center;
        }

        .nama-ttd {
            margin-top: 70px;
            text-decoration: underline;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <!-- KOP SURAT -->
    <div class="kop-surat">
        <!-- LOGO -->
        <!-- <img src="logo-desa.png"> -->

        <h1>PEMERINTAH KABUPATEN BENGKALIS</h1>
        <h2>KECAMATAN BENGKALIS</h2>
        <h2>DESA TAMERAN</h2>
        <p>Jl. Utama Desa Tameran Telp. .............. Fax. ..............</p>
        <p>Kode Pos : 28751</p>
    </div>

    <!-- JUDUL -->
    <div class="judul">
        <h3>SURAT KETERANGAN TIDAK MAMPU</h3>
        <p>Nomor : {{ $data->nomor_surat }}</p>
    </div>

    <p>
        Kepala Desa Tameran Kecamatan Bengkalis Kabupaten Bengkalis dengan ini menerangkan bahwa dengan sebenarnya:
    </p>

    <!-- DATA PEMOHON -->
    <table>
        <tr>
            <td class="label">Nama Lengkap</td>
            <td>: <b>{{ $data->penduduk->nama }}</b></td>
        </tr>
        <tr>
            <td>NIK</td>
            <td>: {{ $data->penduduk->nik }}</td>
        </tr>
        <tr>
            <td>Tempat / Tgl Lahir</td>
            <td>: {{ $data->penduduk->tempat_tanggal_lahir }}</td>
        </tr>
        <tr>
            <td>Kewarganegaraan</td>
            <td>:  {{ $data->penduduk->kewarganegaraan }}</td>
        </tr>
        <tr>
            <td>Agama</td>
            <td>:  {{ $data->penduduk->agama }}</td>
        </tr>
        <tr>
            <td>Pekerjaan</td>
            <td>:  {{ $data->penduduk->pekerjaan }}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>:  {{ $data->penduduk->alamat }}</td>
        </tr>
    </table>

    <br>

    <p>Adalah anak kandung dari:</p>

    <!-- DATA AYAH -->
    <table>
        <tr>
            <td class="label">Nama Lengkap</td>
            <td>:  {{ $data_syarat->nama_lengkap_ayah }}</td>
        </tr>
        <tr>
            <td>NIK</td>
            <td>: {{   $data_syarat->nik_ayah }}</td>
        </tr>
        <tr>
            <td>Tempat / Tgl Lahir</td>
            <td>: {{$data_syarat->tempat_tanggal_lahir_ayah }}</td>
        </tr>
        <tr>
            <td>Kewarganegaraan</td>
            <td>: {{$data_syarat->kewarganegaraan_ayah }}</td>
        </tr>
        <tr>
            <td>Agama</td>
            <td>: {{$data_syarat->agama_ayah }}</td>
        </tr>
        <tr>
            <td>Pekerjaan</td>
            <td>: {{$data_syarat->pekerjaan_ayah }}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>: {{$data_syarat->alamat_ayah }}</td>
        </tr>
    </table>

    <br>

    <!-- DATA IBU -->
    <table>
        <tr>
            <td class="label">Nama Lengkap</td>
            <td>: {{ $data_syarat->nama_lengkap_ibu }}</td>
        </tr>
        <tr>
            <td>NIK</td>
            <td>: {{ $data_syarat->nik_ibu }}</td>
        </tr>
        <tr>
            <td>Tempat / Tgl Lahir</td>
            <td>: {{ $data_syarat->tempat_tanggal_lahir_ibu }}</td>
        </tr>
        <tr>
            <td>Kewarganegaraan</td>
            <td>: {{ $data_syarat->kewarganegaraan_ibu }}</td>
        </tr>
        <tr>
            <td>Agama</td>
            <td>: {{ $data_syarat->agama_ibu }}</td>
        </tr>
        <tr>
            <td>Pekerjaan</td>
            <td>: {{ $data_syarat->pekerjaan_ibu }}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>: {{ $data_syarat->alamat_ibu }}</td>
        </tr>
    </table>

    <!-- ISI SURAT -->
    <div class="isi">
        <p>
            Benar yang bersangkutan berdomisili di Dusun Kempas Tinggi RT.009/RW.003
            Desa Tameran Kecamatan Bengkalis Kabupaten Bengkalis. Dengan ini kami
            jelaskan sepanjang pengetahuan kami nama tersebut di atas adalah
            tergolong keluarga <b>tidak mampu</b> sesuai dengan data yang ada pada kami.
        </p>

        <p>
            Adapun Surat Keterangan Tidak Mampu ini kami buat untuk melengkapi
            persyaratan administrasi pendidikan yang bersangkutan.
        </p>

        <p>
            Demikian surat keterangan ini dibuat dengan sebenarnya dan diberikan
            untuk dapat dipergunakan sebagaimana mestinya.
        </p>
    </div>

    <!-- TANDA TANGAN -->
    <table class="ttd">
        <tr>
            <td></td>
            <td>
                Tameran, 14 Oktober 2025 <br>
                An. Kepala Desa Tameran <br>
                Kecamatan Bengkalis <br>
                Sekdes
                <div class="nama-ttd">
                    SAFARUDDIN, A.Md
                </div>
            </td>
        </tr>
    </table>

</body>
</html>
