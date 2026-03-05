<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Components\Group;

use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Checkbox;

use Filament\Actions\Action;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Wizard::make([
                // step 1
                Step::make("Product Info")
                    ->description("Isi Informasi Produk")
                    ->icon("heroicon-o-clipboard-document-list")
                    ->schema([
                        Group::make([
                            TextInput::make("name")->required(),
                            TextInput::make("sku")->required(),
                        ])->columns(2),
                        MarkdownEditor::make("description")->required(),
                    ]),

                // step 2
                Step::make("Pricing & Stock")
                    ->description("Isi harga dan jumlah stok")
                    ->icon("heroicon-o-currency-dollar")
                    ->schema([
                        TextInput::make("price")
                            ->numeric()
                            ->required()
                            ->minValue(0)
                            ->validationMessages([
                                "required" => "Harga harus diisi",
                                "min_value" => "Harga harus lebih besar dari 0",
                            ]),
                        TextInput::make("stock")
                            ->numeric()
                            ->required()
                            ->minValue(0)
                            ->validationMessages([
                                "required" => "Stok harus diisi",
                                "min_value" => "Stok harus lebih besar dari 0",
                            ]),
                    ]),

                // step 3
                Step::make("Media & Status")
                    ->description("Upload gambar dan atur status")
                    ->icon("heroicon-o-photo")
                    ->schema([
                        FileUpload::make("image")
                            ->disk("public")
                            ->directory("products")
                            ->required(),
                        Checkbox::make("is_active")->required(),
                        Checkbox::make("is_featured")->required(),
                    ]),
            ])
                ->columnSpanFull()
                ->submitAction(
                    Action::make("save")
                        ->label("Save Product")
                        ->button()
                        ->color("primary")
                        ->submit("save"),
                ),
        ]);
    }
}
