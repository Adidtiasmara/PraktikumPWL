<?php

namespace App\Filament\Resources\Posts\Tables;

use BladeUI\Icons\Components\Icon;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Columns\IconColumn;
use Filament\Actions\DeleteAction;
use Filament\Actions\ReplicateAction;



class PostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make("id")
                ->label("ID")
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('title')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('slug')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('category.name')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                ColorColumn::make('color')
                    ->toggleable(),
                ImageColumn::make("image")->disk("public")
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->Label('Created At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('tags')
                    ->label('Tags')
                    ->toggleable(),
                IconColumn::make('published')
                    ->boolean()
                    ->toggleable(),
            ])->defaultSort('created_at', 'asc')
            ->filters([
                Filter::make ('created_at')
                    ->Label('Creation Date')
                    ->schema([
                        DatePicker::make('created_at')
                            ->label('Select Date :')
                    ]),
                SelectFilter::make('category_id')
                    ->relationship('category', 'name')
                    ->label('Category')
                    ->preload()
                    // Query Logic
                    // ->query(function ( $query, $data) {
                    //     return $query 
                    //     ->when(
                    //         $data['created_at'],
                    //         fn ($query, $date) => $query->whereDate('created_at', $date),
                    //     );
                    // })
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),

            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
