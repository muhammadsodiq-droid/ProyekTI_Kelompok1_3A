<?php

namespace App\Filament\Auth;

use App\Models\MahasiswaProfile;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Auth\Register as BaseRegister;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Register extends BaseRegister
{
    protected static string $view = 'filament.pages.auth.register';

    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getNameFormComponent()
                            ->label('Nama Lengkap'),
                        $this->getEmailFormComponent()
                            ->label('Email'),
                        $this->getPasswordFormComponent()
                            ->label('Password'),
                        $this->getPasswordConfirmationFormComponent()
                            ->label('Konfirmasi Password'),
                        $this->getNimFormComponent(),
                        $this->getProdiFormComponent(),
                        $this->getSemesterFormComponent(),
                    ])
                    ->statePath('data'),
            ),
        ];
    }

    protected function getNimFormComponent(): Component
    {
        return TextInput::make('nim')
            ->label('NIM')
            ->required()
            ->unique('mahasiswa_profiles', 'nim')
            ->maxLength(50)
            ->placeholder('Masukkan NIM');
    }

    protected function getProdiFormComponent(): Component
    {
        return Select::make('prodi')
            ->label('Prodi')
            ->options([
                'D3 Agroindustri' => 'D3 Agroindustri',
                'D3 Akuntansi' => 'D3 Akuntansi',
                'D3 Teknologi Informasi' => 'D3 Teknologi Informasi',
                'D3 Teknologi Otomotif' => 'D3 Teknologi Otomotif',
                'D4 Teknologi Rekayasa Komputer Jaringan' => 'D4 Teknologi Rekayasa Komputer Jaringan',
                'D4 Teknologi Pakan Ternak' => 'D4 Teknologi Pakan Ternak',
                'D4 Teknologi Rekayasa Konstruksi Jalan dan Jembatan' => 'D4 Teknologi Rekayasa Konstruksi Jalan dan Jembatan',
                'D4 Teknologi Rekayasa Pemeliharaan Alat Berat' => 'D4 Teknologi Rekayasa Pemeliharaan Alat Berat',
            ])
            ->required()
            ->searchable()
            ->placeholder('Pilih Program Studi')
            ->native(false);
    }

    protected function getSemesterFormComponent(): Component
    {
        return TextInput::make('semester')
            ->label('Semester')
            ->required()
            ->numeric()
            ->minValue(1)
            ->maxValue(14)
            ->default(5)
            ->placeholder('Masukkan semester');
    }

    protected function handleRegistration(array $data): Model
    {
        return DB::transaction(function () use ($data) {
            // Create user with role mahasiswa
            $user = $this->getUserModel()::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
                'role' => 'mahasiswa', // Fixed role for registration
            ]);

            // Create mahasiswa profile
            MahasiswaProfile::create([
                'user_id' => $user->id,
                'nim' => $data['nim'],
                'prodi' => $data['prodi'],
                'semester' => $data['semester'],
            ]);

            return $user;
        });
    }
}

