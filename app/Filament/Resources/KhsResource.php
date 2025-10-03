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
use Illuminate\Support\Facades\Auth;

class KhsResource extends Resource
{
    protected static ?string $model = Khs::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationGroup = 'Kelola PKL';

    protected static ?string $navigationLabel = 'KHS';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        $user = Auth::user();
        $isMahasiswa = $user && $user->isMahasiswa();
        $isDospem = $user && $user->isDospem();

        return $form
            ->schema([
                Forms\Components\FileUpload::make('file_path')
                    ->label('File KHS')
                    ->disk('public')
                    ->directory('uploads/khs')
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
                    ->hidden($isMahasiswa) // Hide for mahasiswa
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
                Tables\Columns\TextColumn::make('mahasiswa.name')
                    ->label('Nama Mahasiswa')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('mahasiswa.mahasiswaProfile.nim')
                    ->label('NIM')
                    ->searchable(),
                Tables\Columns\TextColumn::make('file_path')
                    ->label('File')
                    ->formatStateUsing(fn ($state) => basename($state))
                    ->searchable(),
                Tables\Columns\BadgeColumn::make('status_validasi')
                    ->label('Status')
                    ->colors([
                        'success' => 'tervalidasi',
                        'warning' => 'menunggu',
                        'danger' => fn ($state) => in_array($state, ['revisi', 'belum_valid']),
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Upload')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status_validasi')
                    ->options([
                        'menunggu' => 'Menunggu',
                        'tervalidasi' => 'Tervalidasi',
                        'revisi' => 'Perlu Revisi',
                        'belum_valid' => 'Belum Valid',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->modifyQueryUsing(function (Builder $query) {
                $user = Auth::user();
                if ($user && $user->isMahasiswa()) {
                    // Mahasiswa only see their own files
                    $query->where('mahasiswa_id', $user->id);
                } elseif ($user && $user->isDospem()) {
                    // Dospem see their students' files
                    $mahasiswaIds = $user->mahasiswaBimbingan()->pluck('user_id');
                    $query->whereIn('mahasiswa_id', $mahasiswaIds);
                }
                // Admin sees all
            });
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
