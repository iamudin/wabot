<?php

namespace App\Filament\Resources\AutoReplies\Pages;

use App\Filament\Resources\AutoReplies\AutoReplyResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAutoReply extends EditRecord
{
    protected static string $resource = AutoReplyResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $html = $data['value'];

        $data['value'] = str_replace(
            ['<br>','<br/>','<p>','</p>','<strong>', '</strong>', '<em>', '</em>', '<s>', '</s>'],
            ['\n','\n','','\n',' *', '* ', ' _', '_ ', ' ~', '~ '],
            preg_replace('/<\/?(ol|ul|li)[^>]*>/', '', $html)
        );
        return $data;
    }
    protected function mutateFormDataBeforeFill(array $data): array
    {
        $text = $data['value'];

        $data['value'] = str_replace(
            ['<br>', '<br/>', '<p>', '</p>', '<strong>', '</strong>', '<em>', '</em>', '<s>', '</s>'],
            ['\n', '\n', '', '\n', ' *', '* ', ' _', '_ ', ' ~', '~ '],
            preg_replace('/<\/?(ol|ul|li)[^>]*>/', '', $text)
        );
        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
