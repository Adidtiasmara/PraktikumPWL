<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Components\Group;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TextInput;



class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Wizard::make([
                    Step::make('Product Info')
                    ->description('Isi Informasi Produk')
                    ->schema([
                        Group::make([
                            TextInput::make('name')
                            ->required(),
                            TextInput::make('sku')
                            ->required(),
                        ])->columns(2),
                        MarkdownEditor::make('description')
                    ]),
                ])
                ->columnSpanFull(),
            ]);
    }
}
