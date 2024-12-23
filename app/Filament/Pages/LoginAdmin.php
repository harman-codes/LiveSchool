<?php
namespace App\Filament\Pages;

use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Auth\Login;
use Illuminate\Validation\ValidationException;

/*This is independent page for login. It can be deleted if not needed*/

class LoginAdmin extends Login
{
//    public function form(Form $form): Form
//    {
//        return $form
//            ->schema([
//                TextInput::make('mobile')
//                    ->required()
//                    ->maxLength(255),
//                TextInput::make('password')
//                    ->required()
//                    ->password(),
//                Checkbox::make('remember')
//                    ->label(__('filament-panels::pages/auth/login.form.remember.label'))
//            ]);
//    }

    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getMobileFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getRememberFormComponent(),
                    ])
                    ->statePath('data'),
            ),
        ];
    }

    protected function getMobileFormComponent(): Component
    {
        return TextInput::make('mobile')
            ->required()
            ->autofocus();
    }

    protected function throwFailureValidationException(): never
    {
        throw ValidationException::withMessages([
            'data.mobile' => __('filament-panels::pages/auth/login.messages.failed'),
        ]);
    }


    protected function getCredentialsFromFormData(array $data): array
    {
        return [
            'mobile' => $data['mobile'],
            'password' => $data['password'],
        ];
    }


}
