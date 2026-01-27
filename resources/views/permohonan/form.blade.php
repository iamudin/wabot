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
            width: 94%;
            padding: 10px;
            margin-top: 6px;
            margin-right: auto;
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
        <h2>{{ $data->nama_layanan }}</h2>

        <form method="POST" action="{{ request()->fullUrl() }}">
            @csrf

            <!-- TOKEN WAJIB -->
            <input type="hidden" name="token" value="{{ $token }}">
     @foreach($data->syaratLayanans->sortBy('urutan')->where('status',1) as $key=>$row)
     @if($row->jenis_syarat=='break')
     <h4>{!! $row->nama !!}</h4>
     <hr>
     @else
            <label>{{ $row->nama }}</label>
            <input type="text" name="syarat_{{$row->id }}"  placeholder="Masukkan {{ str($row->kata_kunci)->headline() }}">
            @endif
          @endforeach

            <button type="submit">Kirim Permohonan</button>
        </form>

        <div class="note">
            ⏳ Link ini hanya berlaku satu kali dan memiliki batas waktu.
        </div>
    </div>

</body>

</html>