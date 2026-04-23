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
use Filament\Actions\Action;
use Filament\Forms\Components\Checkbox;
use Filament\Notifications\Notification;





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
                    ->badge()
                    ->color('primary')
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
                    ->badge()
                    ->color('info')
                    ->toggleable(),
                IconColumn::make('published')
                    ->boolean()
                    ->toggleable()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
            ])->defaultSort('created_at', 'desc')
            ->filters([
                Filter::make('created_at')
                    ->Label('Creation Date')
                    ->schema([
                        DatePicker::make('created_at')
                            ->label('Select Date :')
                    ])
                     ->query(function ($query, $data) {
                        return $query
                            ->when(
                                $data['created_at'],
                                fn($query, $date) => $query->whereDate('created_at', $date),
                            );
                    }),
                SelectFilter::make('category_id')
                    ->relationship('category', 'name')
                    ->label('Category')
                    ->preload()
                   
            ])
            ->recordActions([
                ReplicateAction::make(),
                EditAction::make(),
                DeleteAction::make(),
                Action::make('Status')
                    ->label('status change')
                    ->icon('heroicon-o-check-circle') // Icon untuk status change
                    ->schema([
                        Checkbox::make('published')
                            ->default(fn($record): bool => $record->published), // Form input untuk set status
                    ])
                    ->action(function ($record, $data) {
                        $record->update(['published' => $data['published']]); // Logic untuk update data
                        Notification::make()
                            ->title('Status berhasil diubah')
                            ->body($data['published']
                                ? 'Post sekarang sudah Published '
                                : 'Status diubah menjadi Not Published ')
                            ->success()
                            ->send();
                    })
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
