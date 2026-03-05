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

class PostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make("title")->sortable(),
                TextColumn::make("slug")->sortable(),
                TextColumn::make("category.nama")->sortable(),
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
                //
            ])
            ->recordActions([EditAction::make()])
            ->toolbarActions([
                BulkActionGroup::make([DeleteBulkAction::make()]),
            ]);
    }
}
