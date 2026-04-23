<?php

namespace App\Filament\Resources\Posts\Schemas;

use App\Models\Category;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DateTimePicker;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Group;
class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
                Section::make("Post Details")
                -> description("Fill in the details of the post.")
                ->icon("heroicon-s-document-text")
                ->schema([
                Group::make([
                TextInput::make('title')
                ->rules(['required', 'min:5']),
                // ->required()->minLength(5),
                TextInput::make('slug')
                ->required()
                ->unique()
                ->minLength(3)
                ->validationMessages([
                    'unique' => 'Slug harus unik dan tidak boleh sama.',
                    'required' => 'Slug wajib diisi.',
                    'minLength' => 'Slug minimal 3 karakter.',
                    
                ]),
                Select::make("category_id")
                    ->relationship("category", "name")
                    ->options(Category::pluck('name', 'id'))
                    ->required()
                    // ->preload()
                    ->searchable()
                    ->validationMessages([
                        'required' => 'Kategori wajib dipilih.',
                    ]),
                ColorPicker::make("color"),
                // RichEditor::make("content"),
                ])->columns(2),
                MarkdownEditor::make("body"),
                ])->columnSpan(2),

                Group::make([
                Section::make("Image Upload")
                ->description("Upload an image for the post.")
                ->icon("heroicon-s-photo")
                ->schema([
                    FileUpload::make("image")
                    ->required()
                    ->disk("public")
                    ->directory("posts")
                    ->validationMessages([
                        'required' => 'Gambar wajib diunggah.'
                        ]),
                ]),
                Section::make("Meta Information")
                ->description("Manage the meta information for the post.")
                ->icon("heroicon-s-cog")
                ->schema([
                    TagsInput::make("tags"),
                    Checkbox::make("published"),
                    DateTimePicker::make("published_at"),
                ])->columnSpan (1),
                ]),
            ])->columns(3);
    }
}
