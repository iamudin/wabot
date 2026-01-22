<?php

namespace App\Filament\Resources\Permohonans\Pages;

use App\Filament\Resources\Permohonans\PermohonanResource;
use Filament\Resources\Pages\Page;

class PermohonanSurat extends Page
{
    protected static string $resource = PermohonanResource::class;

    protected string $view = 'filament.resources.permohonans.pages.permohonan-surat';
}
