<?php

namespace App\Filament\Resources\Layanans\Schemas;

use Illuminate\Support\Str;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;

class LayananForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('kategori_id')
                    ->relationship('kategori', 'nama_kategori')
                    ->required(),
                TextInput::make('nama_layanan')
                    ->required(),
                Textarea::make('keterangan')
                    ->required()
                    ->columnSpanFull(),
                     FileUpload::make('template_surat')
                    ->label('Upload Template Surat (.DOCX)')
                    ->directory('layanan/template-surat')
                    ->preserveFilenames(false)
                    ->acceptedFileTypes(['application/vnd.openxmlformats-officedocument.wordprocessingml.document'])    // hanya izinkan .docx
                    ->getUploadedFileNameForStorageUsing(
                        fn($file) =>
                        (string) Str::uuid() . '.' . $file->getClientOriginalExtension()
                    )   ,         
                Toggle::make('status')
                    ->required(),
            ]);
    }
}
