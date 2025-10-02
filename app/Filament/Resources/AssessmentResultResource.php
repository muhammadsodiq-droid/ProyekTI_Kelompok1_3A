<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AssessmentResultResource\Pages;
use App\Filament\Resources\AssessmentResultResource\RelationManagers;
use App\Models\AssessmentResult;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AssessmentResultResource extends Resource
{
    protected static ?string $model = AssessmentResult::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('form_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('mahasiswa_user_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('total_percent')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('letter_grade')
                    ->maxLength(5)
                    ->default(null),
                Forms\Components\TextInput::make('gpa_point')
                    ->numeric()
                    ->default(null),
                Forms\Components\DateTimePicker::make('decided_at')
                    ->required(),
                Forms\Components\TextInput::make('decided_by')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('form_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('mahasiswa_user_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_percent')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('letter_grade')
                    ->searchable(),
                Tables\Columns\TextColumn::make('gpa_point')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('decided_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('decided_by')
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
            'index' => Pages\ListAssessmentResults::route('/'),
            'create' => Pages\CreateAssessmentResult::route('/create'),
            'edit' => Pages\EditAssessmentResult::route('/{record}/edit'),
        ];
    }
}
