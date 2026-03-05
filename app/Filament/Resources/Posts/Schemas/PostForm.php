<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Group;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DateTimePicker;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // section 1
                Group::make([
                    Section::make("Post Details")
                        ->description("Fill in details of the post")
                        ->icon("heroicon-o-document-text")
                        ->schema([
                            Group::make([
                                TextInput::make("title")
                                    ->rules(["required", "min:5", "max:100"])
                                    ->validationMessages([
                                        "required" => "Title cannot be empty",
                                        "min" =>
                                            "Title must be at least 5 characters",
                                        "max" =>
                                            "Title cannot exceed 100 characters",
                                    ]),
                                TextInput::make("slug")
                                    ->rules(["required", "min:3"])
                                    ->unique()
                                    ->validationMessages([
                                        "required" => "Slug cannot be empty",
                                        "min" =>
                                            "Slug must be at least 3 characters",
                                        "unique" => "Slug must be unique",
                                    ]),
                                Select::make("category_id")
                                    ->relationship("category", "nama")
                                    ->preload()
                                    ->required()
                                    ->searchable()
                                    ->validationMessages([
                                        "required" =>
                                            "Please select a category",
                                    ]),
                                ColorPicker::make("color"),
                            ])->columns(2),
                            MarkdownEditor::make("body")
                                ->rules(["nullable", "max:5000"])
                                ->validationMessages([
                                    "max" =>
                                        "Content cannot exceed 5000 characters",
                                ]),
                        ]),
                ])->columnSpan(2),

                Group::make([
                    // section 2
                    Section::make("Image Upload")
                        ->icon("heroicon-o-photo")
                        ->schema([
                            FileUpload::make("image")
                                ->disk("public")
                                ->directory("posts")
                                ->required()
                                ->validationMessages([
                                    "required" => "Please upload an image",
                                ]),
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
            ])
            ->columns(3);
    }
}
