<?php

namespace App\Filament\Auth;

use App\Models\MahasiswaProfile;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Auth\Login as BaseLogin;
use Illuminate\Validation\ValidationException;

class Login extends BaseLogin
{
    protected static string $view = 'filament.pages.auth.login';

    protected function getEmailFormComponent(): Component 
    {
        return TextInput::make('email')
            ->label('Email atau NIM')
            ->required()
            ->autocomplete()
            ->autofocus()
            ->extraInputAttributes(['tabindex' => 1])
            ->placeholder('Masukkan email atau NIM');
    }

    protected function getCredentialsFromFormData(array $data): array
    {
        $login = $data['email'];

        // Check if login is NIM
        $mahasiswaProfile = MahasiswaProfile::where('nim', $login)->first();
        
        if ($mahasiswaProfile) {
            // Login with NIM, get the email from user
            $user = $mahasiswaProfile->user;
            return [
                'email' => $user->email,
                'password' => $data['password'],
            ];
        }

        // Login with email (default)
        return [
            'email' => $login,
            'password' => $data['password'],
        ];
    }
}
