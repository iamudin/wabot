<?php

namespace App\Filament\Resources\AutoReplies\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;

class AutoReplyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('key'),
                TextInput::make('title'),
         
            RichEditor::make('value')
                    ->toolbarButtons([
                        'bold',
                        'italic',
                        'strike',
                        'undo',
                        'redo',
                    ])->disableToolbarButtons([
                            'orderedList',
                            'bulletList',
                        ])
                    ->columnSpanFull()
                    ->placeholder('Tulis konten di sini...')
    ->helperText('0️⃣ 1️⃣ 2️⃣ 3️⃣ 4️⃣ 5️⃣ 6️⃣ 7️⃣ 8️⃣ 9️⃣ 🔟 ① ② ③ ④ ⑤ ⑥ ⑦ ⑧ ⑨ ⑩
😀 😃 😄 😁 😆 😅 😂 🤣 😊 🙂 🙃 😉 😌 😍 🥰 😘 😗 😙 😚 😋 😛 😜 🤪 😝 🤑 🤗 🤭 🤫 🤔 🤐 😐 😑 😶 😏 😒 🙄 😬 🤥 😔 😪 🤤 😴 😷 🤒 🤕 🤢 🤮 🤧 😵 😵‍💫 😎 🤓 🧐 😕 😟 🙁 ☹️ 😮 😯 😲 😳 🥺 😦 😧 😨 😰 😥 😢 😭 😱 😖 😣 😞 😓 😩 😫 🥱 😤 😡 😠 🤬 😈 👿 💀 ☠️ 👻 👽 🤖 🎃
🙏 🤲 👐 🙌 👏 🤝 👍 👎 👊 ✊ 🤛 🤜 🤞 ✌️ 🤟 🤘 👌 🤏 👈 👉 👆 👇 ☝️ ✋ 🤚 🖐️ 🖖 👋 🤙 💪 🦾 🦿 🦵 🦶
👶 🧒 👦 👧 🧑 👨 👩 👴 👵 🧓 🧔 🧕 👳 👲 👮 👷 💂 🕵️ 👩‍⚕️ 👨‍⚕️ 👩‍🏫 👨‍🏫 👩‍💼 👨‍💼 👩‍🌾 👨‍🌾 👩‍💻 👨‍💻 👩‍🚒 👨‍🚒
🏛️ 🏢 🏣 🏤 🏥 🏫 🏦 🏠 🏡 🏘️ 🏬 🏪 🏨 🛣️ 🛤️ 🌍 🌎 🌏 🌳 🌴 🌾 🌱 🌿 🍃
📄 📑 🗂️ 📁 📂 🗃️ 📝 📋 🖊️ 🖋️ ✒️ 📢 📣 📌 📍 🕘 🕒 ⏰ ⏳ ⌛ ☎️ 📞 📱 💻 🖥️ 🖨️
✅ ❌ ⚠️ 🚫 ⛔ 🔴 🟢 🟡 🔵 🟣 ⚫ ⚪ ✔️ ✖️ ☑️ 🔒 🔓 🔔 🔕
🎉 🎊 🥳 🎈 🎁 🎀 📅 🗓️ 📆 🎤 🎙️
💊 💉 🩺 🧬 🧪 🍎 🍉 🍌 🍊 🍇 🏃 🚶 🧘 🤸
')                    ,

             
            ]);
    }
}
