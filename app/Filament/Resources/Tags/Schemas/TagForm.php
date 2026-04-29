<?php

namespace App\Filament\Resources\Tags\Schemas;
use Filament\Resources\Resource;

use Dom\Text;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TagForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Tambahkan komponen form untuk Tag di sini
                TextInput::make("name")
                
            ]);
    }
}
