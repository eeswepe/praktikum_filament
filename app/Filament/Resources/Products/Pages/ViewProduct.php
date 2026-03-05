<?php

namespace App\Filament\Resources\Products\Pages;

use App\Filament\Resources\Products\ProductResource;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class ViewProduct extends ViewRecord
{
    protected static string $resource = ProductResource::class;

    public function infolist(Schema $schema): Schema
    {
        return $schema->components([
            Tabs::make("Product Tabs")
                ->vertical()
                ->tabs([
                    Tab::make("Product Details")
                        ->icon("heroicon-s-information-circle")
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
                        ]),
                    Tab::make("Product Price and Stocks")
                        ->icon("heroicon-s-banknotes")
                        ->schema([
                            TextEntry::make("price")
                                ->label("Price")
                                ->weight("bold")
                                ->color("primary")
                                ->icon("heroicon-s-currency-dollar")
                                ->badge()
                                ->formatStateUsing(
                                    fn($state) => "Rp " .
                                        number_format($state, 0, ",", "."),
                                ),
                            TextEntry::make("stock")
                                ->label("Stock")
                                ->icon("heroicon-s-cube")
                                ->badge()
                                ->formatStateUsing(
                                    fn($state) => match (true) {
                                        $state <= 0 => "Habis",
                                        $state <= 10
                                            => "Stok Rendah ({$state})",
                                        default => "Tersedia ({$state})",
                                    },
                                )
                                ->color(
                                    fn($state) => match (true) {
                                        $state <= 0 => "danger",
                                        $state <= 10 => "warning",
                                        default => "success",
                                    },
                                ),
                        ]),
                    Tab::make("Media and Status")
                        ->icon("heroicon-s-photo")
                        ->schema([
                            ImageEntry::make("image")
                                ->label("Product Image")
                                ->disk("public"),
                            IconEntry::make("is_active")
                                ->label("Status")
                                ->boolean(),
                            IconEntry::make("is_featured")
                                ->label("Featured")
                                ->boolean(),
                        ]),
                ])
                ->columnSpanFull(),
        ]);
    }
}
