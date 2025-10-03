<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AssessmentResponseResource\Pages;
use App\Filament\Resources\AssessmentResponseResource\RelationManagers;
use App\Models\AssessmentResponse;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AssessmentResponseResource extends Resource
{
    protected static ?string $model = AssessmentResponse::class;

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
                Forms\Components\TextInput::make('dosen_user_id')
                    ->required()
                    ->numeric(),
                Forms\Components\Toggle::make('is_final')
                    ->required(),
                Forms\Components\DateTimePicker::make('submitted_at'),
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
                Tables\Columns\TextColumn::make('dosen_user_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_final')
                    ->boolean(),
                Tables\Columns\TextColumn::make('submitted_at')
                    ->dateTime()
                    ->sortable(),
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
            'index' => Pages\ListAssessmentResponses::route('/'),
            'create' => Pages\CreateAssessmentResponse::route('/create'),
            'edit' => Pages\EditAssessmentResponse::route('/{record}/edit'),
        ];
    }
}
