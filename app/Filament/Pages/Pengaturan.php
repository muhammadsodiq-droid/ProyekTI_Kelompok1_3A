<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Pengaturan extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string $view = 'filament.pages.pengaturan';

    protected static ?string $navigationGroup = 'Pengaturan';

    protected static ?string $navigationLabel = 'Pengaturan Akun';

    protected static ?int $navigationSort = 10;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('old_password')
                    ->label('Password Lama')
                    ->password()
                    ->required()
                    ->revealable(),
                TextInput::make('new_password')
                    ->label('Password Baru')
                    ->password()
                    ->required()
                    ->minLength(6)
                    ->revealable(),
                TextInput::make('confirm_password')
                    ->label('Konfirmasi Password Baru')
                    ->password()
                    ->required()
                    ->same('new_password')
                    ->revealable(),
            ])
            ->statePath('data');
    }

    public function changePassword(): void
    {
        $data = $this->form->getState();
        
        $user = Auth::user();
        
        // Verify old password
        if (!Hash::check($data['old_password'], $user->password)) {
            Notification::make()
                ->title('Password lama salah')
                ->danger()
                ->send();
            return;
        }

        // Update password
        $user->password = Hash::make($data['new_password']);
        $user->save();

        // Log activity
        \App\Models\ActivityLog::create([
            'actor_user_id' => $user->id,
            'mahasiswa_id' => $user->isMahasiswa() ? $user->id : null,
            'type' => 'change_password',
            'meta' => json_encode(['timestamp' => now()]),
        ]);

        Notification::make()
            ->title('Password berhasil diperbarui')
            ->success()
            ->send();

        // Reset form
        $this->form->fill();
    }

    public function editProfile(): void
    {
        $user = Auth::user();
        
        if ($user->isMahasiswa() && $user->mahasiswaProfile) {
            // Redirect to Filament resource edit page
            $this->redirect(\App\Filament\Resources\MahasiswaProfileResource::getUrl('edit', ['record' => $user->mahasiswaProfile->user_id]));
        } else {
            Notification::make()
                ->title('Profile tidak ditemukan')
                ->warning()
                ->send();
        }
    }
}

