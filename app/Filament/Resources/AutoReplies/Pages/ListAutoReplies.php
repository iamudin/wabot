<?php

namespace App\Filament\Resources\AutoReplies\Pages;

use App\Filament\Resources\AutoReplies\AutoReplyResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAutoReplies extends ListRecords
{
    protected static string $resource = AutoReplyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
