<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KhsResource\Pages;
use App\Filament\Resources\KhsResource\RelationManagers;
use App\Models\Khs;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KhsResource extends Resource
{
    protected static ?string $model = Khs::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('mahasiswa_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('file_path')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('status_validasi')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('mahasiswa_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('file_path')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status_validasi'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKhs::route('/'),
            'create' => Pages\CreateKhs::route('/create'),
            'edit' => Pages\EditKhs::route('/{record}/edit'),
        ];
    }
}
