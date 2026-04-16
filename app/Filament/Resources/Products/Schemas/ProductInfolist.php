<?php

namespace App\Filament\Resources\Products\Schemas;

use Dom\Text;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\IconEntry;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;


class ProductInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
                Tabs::make('Product Tabs')
                    ->tabs([
                        Tab::make('Product Info')
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                TextEntry::make('name')
                                    ->label('Product Name')
                                    ->weight('bold')
                                    ->color('primary'),

                                TextEntry::make('id')
                                    ->label('Product ID'),

                                TextEntry::make('sku')
                                    ->label('Product SKU')
                                    ->badge()
                                    ->color('warning'),

                                TextEntry::make('description')
                                    ->label('Product Description'),
                                TextEntry::make('created_at')
                                    ->label('Product Creation Date')
                                    ->date('d M Y H:m:s')
                                    ->color('info'),
                            ])
                            ->columnSpanFull(),
                        Tab::make('Pricing & Stock')
                            ->icon('heroicon-o-currency-dollar')
                            ->schema([
                                TextEntry::make('price')
                                    ->formatStateUsing(fn (string $state) => 'Rp ' . number_format($state, 0, ',', '.') . '')
                                    ->label('Product Price')
                                    ->weight('bold')
                                    ->color('primary')
                                    ->icon('heroicon-o-currency-dollar'),
                                TextEntry::make('stock')
                                    ->badge()
                                    ->color(fn ($record) => $record->stock > 5 ? 'success' : 'danger')
                                    ->label('Product Stock')
                                    ->icon('heroicon-o-archive-box'),
                            ])
                            ->columnSpanFull(),
                        Tab::make('Image and Status')
                        ->icon('heroicon-o-camera')
                            ->schema([
                                ImageEntry::make('image')
                                    ->label('Product Image')
                                    ->disk('public'),
                                TextEntry::make('price')
                                    ->label('Product Price')
                                    ->weight('bold')
                                    ->color('primary')
                                    ->icon('heroicon-o-currency-dollar'),
                                TextEntry::make('stock')
                                    ->label('Product Stock')
                                    ->weight('bold')
                                    ->color('primary'),
                                IconEntry::make('is_active')
                                    ->label('Is Active?')
                                    ->boolean(),
                                IconEntry::make('is_featured')
                                    ->label('Featured Status')
                                    ->boolean(),
                            ])
                            ])
                            ->vertical()
                            ->columnSpanFull(),
                    
            ]);
    }
}
