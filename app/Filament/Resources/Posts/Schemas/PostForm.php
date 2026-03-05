<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Group;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DateTimePicker;

use Filament\Support\Icon\HeroIcon;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //section 1
                Group::make([
                    Section::make("Post Details")
                        ->Description("Fill in details of the post")
                        ->icon("heroicon-o-document-text")
                        ->schema([
                            Group::make([
                                TextInput::make("title")
                                    ->minLength(5)
                                    ->required(),
                                TextInput::make("slug")->unique(),
                                Select::make("category_id")
                                    ->relationship("category", "nama")
                                    ->preload()
                                    ->searchable(),
                                ColorPicker::make("color"),
                            ])->columns(2),
                            MarkdownEditor::make("content"),
                        ]),
                ])->columnSpan(2),
                // RichEditor::make("content"),

                Group::make([
                    Section::make("Image Upload")
                        ->icon("heroicon-o-photo")
                        ->schema([
                            FileUpload::make("image")
                                ->disk("public")
                                ->directory("posts"),
                        ]),
                    // section 3
                    Section::make("Meta Information")
                        ->icon("heroicon-o-tag")
                        ->schema([
                            TagsInput::make("tags"),
                            Checkbox::make("published"),
                            DateTimePicker::make("published_at"),
                        ]),
                ])->columnSpan(1),
                // section 2
            ])
            ->columns(3);
    }
}
