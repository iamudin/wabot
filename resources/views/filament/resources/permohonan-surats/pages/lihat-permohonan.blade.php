<x-filament-panels::page>
    {{-- HEADER --}}
    <div class="space-y-1">
        <p class="text-sm text-green-500 alert">
            Persiapan tanda tangan elektronik oleh pejabat penandatangan
        </p>
    </div>

    {{-- DATA PERMOHONAN --}}
    <x-filament::section class="mt-6">
        <x-slot name="heading">Data Permohonan</x-slot>

        <dl class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div>
                <dt class="text-gray-500">Kode Tiket Permohonan</dt>
                <b class="font-medium" style="color:orange">#{{ $record->kode_tiket }}</b>
            </div>
            <div>
                <dt class="text-gray-500">NIK</dt>
                <dd class="font-medium" style="color:orange">{{ $record->penduduk->nik }}</dd>
            </div>
            <div>
                <dt class="text-gray-500">Nama</dt>
                <dd class="font-medium" style="color:orange">{{ $record->penduduk->nama }}</dd>
            </div>
            <div>
                <dt class="text-gray-500">Alamat</dt>
                <dd class="font-medium" style="color:orange">{{ $record->penduduk->alamat }}</dd>
            </div>
              <div>
                <dt class="text-gray-500">RT/RW</dt>
                <dd class="font-medium" style="color:orange">{{ $record->penduduk->rt->nomor }} / {{ $record->penduduk->rt->rw->nomor }}</dd>
            </div>
                <div>
                <dt class="text-gray-500">Kontak</dt>
                <dd class="font-medium" style="color:orange">{{ $record->penduduk->nomor_whatsapp }}</dd>
            </div>
            <div>
                <dt class="text-gray-500">Jenis Surat</dt>
                <dd class="font-medium" style="color:orange">{{ $record->layanan->nama_layanan }}</dd>
            </div>
            <div>
                <dt class="text-gray-500">Tanggal Pengajuan</dt>
                <dd class="font-medium" style="color:orange">{{ $record->created_at->format('d M Y H:i T') }}</dd>
            </div>
        </dl>
    </x-filament::section>
   <x-filament::section class="mt-6">
        <x-slot name="heading">Tanda Tangan Elektronik</x-slot>

        @if ($this->getPenandatangan())
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div>
                    <dt class="text-gray-500">Nama Penandatangan</dt>
                    <dd class="font-medium" style="color:orange">{{ $this->getPenandatangan()->nama }}</dd>
                </div>
                <div>
                    <dt class="text-gray-500">Jabatan</dt>
                    <dd class="font-medium" style="color:orange">{{ $this->getPenandatangan()->jabatan }}</dd>
                </div>
            </div>

            <div class="mt-4">
                @if($time=$record->ditandatangani_pada)
                  <p class="text-sm text-warning-600">
                        Sudah Ditandatangani <br> pada <b style="color:green"> {{ $time->format('d F Y H:i T') }}</b>
                    </p>
                @else
                @if ($this->isSiapTTE())
                    <x-filament::button
                        color="success"
                        wire:click="mountAction('prosesTTE')"
                        icon="heroicon-o-pencil-square"
                    >
                        Tandatangani Dokumen
                    </x-filament::button>
                @else
                    <p class="text-sm text-warning-600">
                        ⚠️ Dokumen atau passphrase belum lengkap
                    </p>
                @endif
                @endif
            </div>
        @else
            <p class="text-sm text-danger-600">
                Penandatangan belum ditentukan
            </p>
        @endif
    </x-filament::section>
    {{-- DOKUMEN --}}
    <x-filament::section class="mt-6">
        <x-slot name="heading">Dokumen </x-slot>

   @if ($record->file_surat)
    <div class="mt-4 rounded-lg border bg-white">
        <iframe
        style="width:100%;height:70vh"
            src="{{ route('file.preview',base64_encode($record->surat_tte ?? $record->file_surat)) }}"
            class="w-full h-[75vh] rounded-lg"
        ></iframe>
    </div>
@else
    <div class="rounded-lg border border-red-200 bg-red-50 p-4 text-red-700 text-sm">
        Dokumen belum tersedia
    </div>
@endif

    </x-filament::section>

    {{-- PANEL TANDA TANGAN ELEKTRONIK --}}
 
</x-filament-panels::page>

