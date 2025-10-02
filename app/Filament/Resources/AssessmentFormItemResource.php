<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AssessmentFormItemResource\Pages;
use App\Filament\Resources\AssessmentFormItemResource\RelationManagers;
use App\Models\AssessmentFormItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AssessmentFormItemResource extends Resource
{
    protected static ?string $model = AssessmentFormItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('form_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('label')
                    ->required()
                    ->maxLength(200),
                Forms\Components\TextInput::make('type')
                    ->required(),
                Forms\Components\TextInput::make('weight')
                    ->required()
                    ->numeric()
                    ->default(0.00),
                Forms\Components\Toggle::make('required')
                    ->required(),
                Forms\Components\TextInput::make('sort_order')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('form_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('label')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type'),
                Tables\Columns\TextColumn::make('weight')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('required')
                    ->boolean(),
                Tables\Columns\TextColumn::make('sort_order')
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
            'index' => Pages\ListAssessmentFormItems::route('/'),
            'create' => Pages\CreateAssessmentFormItem::route('/create'),
            'edit' => Pages\EditAssessmentFormItem::route('/{record}/edit'),
        ];
    }
}
