<?php

namespace App\Filament\Resources\AutoReplies\Pages;

use App\Filament\Resources\AutoReplies\AutoReplyResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAutoReply extends CreateRecord
{
    protected static string $resource = AutoReplyResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $html = $data['value'];

        $data['value'] = str_replace(
            ['<br>','<br/>','<p>','</p>','<strong>', '</strong>', '<em>', '</em>', '<s>', '</s>'],
            ['\n','\n','','\n',' *', '* ', ' _', '_ ', ' ~', '~ '],
            $html
        );

        return $data;
    }
}
