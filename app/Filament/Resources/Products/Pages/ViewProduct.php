<?php

namespace App\Filament\Resources\Products\Pages;

use App\Filament\Resources\Products\ProductResource;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ViewProduct extends ViewRecord
{
    protected static string $resource = ProductResource::class;

    public function infolist(Schema $schema): Schema
    {
        return $schema->components([
            Section::make("Product Info")
                ->schema([
                    TextEntry::make("name")
                        ->label("Product Name")
                        ->weight("bold")
                        ->color("primary"),
                    TextEntry::make("id")->label("Product ID"),
                    TextEntry::make("sku")
                        ->label("Product SKU")
                        ->badge()
                        ->color("warning"),
                    TextEntry::make("description")->label(
                        "Product Description",
                    ),
                    TextEntry::make("created_at")
                        ->label("Product Created Date")
                        ->date("d M Y")
                        ->color("info"),
                ])
                ->columnSpanFull(),
            Section::make("Pricing & Stock")
                ->description("")
                ->schema([
                    TextEntry::make("price")
                        ->label("Price")
                        ->weight("bold")
                        ->color("primary")
                        ->icon("heroicon-s-currency-dollar")
                        ->formatStateUsing(
                            fn($state) => 'Rp ' . number_format($state, 0, ',', '.'),
                        ),
                    TextEntry::make("stock")
                        ->label("Stock")
                        ->icon("heroicon-s-cube"),
                ])
                ->columnSpanFull(),
            Section::make("Image and Status")
                ->description("")
                ->schema([
                    ImageEntry::make("image")
                        ->label("Product Image")
                        ->disk("public"),
                    IconEntry::make("is_active")->label("Status")->boolean(),
                    IconEntry::make("is_featured")
                        ->label("Featured")
                        ->boolean(),
                ])
                ->columnSpanFull(),
        ]);
    }
}
