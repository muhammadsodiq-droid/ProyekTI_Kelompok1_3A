<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SuratBalasanResource\Pages;
use App\Filament\Resources\SuratBalasanResource\RelationManagers;
use App\Models\Mitra;
use App\Models\SuratBalasan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class SuratBalasanResource extends Resource
{
    protected static ?string $model = SuratBalasan::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static ?string $navigationGroup = 'Kelola PKL';

    protected static ?string $navigationLabel = 'Surat Balasan Mitra';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        $user = Auth::user();
        $isMahasiswa = $user && $user->isMahasiswa();

        return $form
            ->schema([
                Forms\Components\Select::make('mitra_id')
                    ->label('Pilih Mitra/Instansi')
                    ->options(Mitra::pluck('nama', 'id'))
                    ->searchable()
                    ->nullable()
                    ->placeholder('-- Pilih dari daftar (opsional) --')
                    ->helperText('Pilih mitra dari daftar atau isi manual di bawah'),

                Forms\Components\TextInput::make('mitra_nama_custom')
                    ->label('Nama Mitra (Manual)')
                    ->maxLength(150)
                    ->placeholder('Tulis manual jika tidak ada di daftar')
                    ->helperText('Isi jika mitra tidak ada di dropdown'),

                Forms\Components\FileUpload::make('file_path')
                    ->label('File Surat Balasan')
                    ->disk('public')
                    ->directory('uploads/surat')
                    ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png', 'image/jpg'])
                    ->maxSize(5120) // 5MB
                    ->required()
                    ->downloadable()
                    ->openable()
                    ->helperText('Format: PDF, JPG, PNG. Maksimal 5MB')
                    ->columnSpanFull(),

                Forms\Components\Select::make('status_validasi')
                    ->label('Status Validasi')
                    ->options([
                        'menunggu' => 'Menunggu Validasi',
                        'tervalidasi' => 'Tervalidasi',
                        'revisi' => 'Perlu Revisi',
                        'belum_valid' => 'Belum Valid',
                    ])
                    ->default('menunggu')
                    ->required()
                    ->hidden($isMahasiswa)
                    ->disabled($isMahasiswa),

                Forms\Components\Hidden::make('mahasiswa_id')
                    ->default(fn () => Auth::id())
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
                Tables\Columns\TextColumn::make('mitra_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('mitra_nama_custom')
                    ->searchable(),
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
            'index' => Pages\ListSuratBalasans::route('/'),
            'create' => Pages\CreateSuratBalasan::route('/create'),
            'edit' => Pages\EditSuratBalasan::route('/{record}/edit'),
        ];
    }
}
