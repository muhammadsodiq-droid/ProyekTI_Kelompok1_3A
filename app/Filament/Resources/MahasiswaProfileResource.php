<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MahasiswaProfileResource\Pages;
use App\Filament\Resources\MahasiswaProfileResource\RelationManagers;
use App\Models\MahasiswaProfile;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MahasiswaProfileResource extends Resource
{
    protected static ?string $model = MahasiswaProfile::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nim')
                    ->maxLength(50)
                    ->default(null),
                Forms\Components\TextInput::make('prodi')
                    ->required()
                    ->maxLength(100),
                Forms\Components\TextInput::make('semester')
                    ->required()
                    ->numeric()
                    ->default(5),
                Forms\Components\TextInput::make('whatsapp')
                    ->maxLength(30)
                    ->default(null),
                Forms\Components\TextInput::make('gender'),
                Forms\Components\TextInput::make('ipk')
                    ->numeric()
                    ->default(null),
                Forms\Components\Toggle::make('cek_min_semester')
                    ->required(),
                Forms\Components\Toggle::make('cek_ipk_nilaisks')
                    ->required(),
                Forms\Components\Toggle::make('cek_valid_biodata')
                    ->required(),
                Forms\Components\TextInput::make('dospem_id')
                    ->numeric()
                    ->default(null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nim')
                    ->searchable(),
                Tables\Columns\TextColumn::make('prodi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('semester')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('whatsapp')
                    ->searchable(),
                Tables\Columns\TextColumn::make('gender'),
                Tables\Columns\TextColumn::make('ipk')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('cek_min_semester')
                    ->boolean(),
                Tables\Columns\IconColumn::make('cek_ipk_nilaisks')
                    ->boolean(),
                Tables\Columns\IconColumn::make('cek_valid_biodata')
                    ->boolean(),
                Tables\Columns\TextColumn::make('dospem_id')
                    ->numeric()
                    ->sortable(),
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
            'index' => Pages\ListMahasiswaProfiles::route('/'),
            'create' => Pages\CreateMahasiswaProfile::route('/create'),
            'edit' => Pages\EditMahasiswaProfile::route('/{record}/edit'),
        ];
    }
}
