<?php

namespace App\Filament\Resources\Posts\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;

use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\DatePicker;

class PostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make("title")->sortable()->searchable(),
                TextColumn::make("slug")->sortable()->searchable(),
                TextColumn::make("category.nama")->sortable()->searchable(),
                ColorColumn::make("color"),
                ImageColumn::make("image")->disk("public"),
                IconColumn::make("published")->boolean(),
                TextColumn::make("created_at")
                    ->label("Created At")
                    ->sortable()
                    ->dateTime(),
            ])
            ->defaultSort("created_at", "desc")
            ->filters([
                Filter::make("created_at")
                    ->label("Creation Date")
                    ->schema([
                        DatePicker::make("created_at")->label("Select Date :"),
                    ])
                    ->query(function ($query, $data) {
                        return $query->when(
                            $data["created_at"],
                            fn($query, $date) => $query->whereDate(
                                "created_at",
                                $date,
                            ),
                        );
                    }),
                SelectFilter::make("category_id")
                    ->relationship("category", "nama")
                    ->label("Category")
                    ->preload(),
            ])
            ->recordActions([EditAction::make()])
            ->toolbarActions([
                BulkActionGroup::make([DeleteBulkAction::make()]),
            ]);
    }
}
