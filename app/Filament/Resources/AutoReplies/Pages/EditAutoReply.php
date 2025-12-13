<?php

namespace App\Filament\Resources\AutoReplies\Pages;

use App\Filament\Resources\AutoReplies\AutoReplyResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAutoReply extends EditRecord
{
    protected static string $resource = AutoReplyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
