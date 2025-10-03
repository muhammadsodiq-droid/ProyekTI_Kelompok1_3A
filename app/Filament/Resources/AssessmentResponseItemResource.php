<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AssessmentResponseItemResource\Pages;
use App\Filament\Resources\AssessmentResponseItemResource\RelationManagers;
use App\Models\AssessmentResponseItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AssessmentResponseItemResource extends Resource
{
    protected static ?string $model = AssessmentResponseItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('response_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('item_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('value_numeric')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('value_letter')
                    ->maxLength(5)
                    ->default(null),
                Forms\Components\Toggle::make('value_bool'),
                Forms\Components\TextInput::make('value_text')
                    ->maxLength(500)
                    ->default(null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('response_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('item_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('value_numeric')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('value_letter')
                    ->searchable(),
                Tables\Columns\IconColumn::make('value_bool')
                    ->boolean(),
                Tables\Columns\TextColumn::make('value_text')
                    ->searchable(),
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
            'index' => Pages\ListAssessmentResponseItems::route('/'),
            'create' => Pages\CreateAssessmentResponseItem::route('/create'),
            'edit' => Pages\EditAssessmentResponseItem::route('/{record}/edit'),
        ];
    }
}
