<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        VerifyEmail::toMailUsing(function (object $notifiable, string $verification_url) {
            return (new MailMessage)
                ->subject('Vérification de votre adresse email')
                ->greeting('Salut '.ucfirst($notifiable->first_name).' !')
                ->line('Merci de vous être inscrit sur notre application !
                veuillez cliquer sur le bouton ci-dessous pour vérifier votre adresse email.')
                ->action('Vérification de votre adresse email', $verification_url)
                ->line('Si vous n\'avez pas créé de compte, aucune action n\'est requise.')
                ->salutation('Cordialement, l\'équipe '.config('app.name'));
        });

        $this->registerPolicies();

        ResetPassword::toMailUsing(function (object $notifiable, string $token) {
            return (new MailMessage)
                ->subject('Réinitialisation de votre mot de passe')
                ->greeting('Salut '.ucfirst($notifiable->first_name).' !')
                ->line('Vous recevez cet email car nous avons reçu une demande de réinitialisation de mot de passe pour votre compte.')
                ->action('Réinitialiser le mot de passe', env("APP_URL", "localhost:3000")."/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}")
                ->line('Ce lien de réinitialisation de mot de passe expirera dans 60 minutes.')
                ->line('Si vous n\'avez pas demandé de réinitialisation de mot de passe, aucune action n\'est requise.')
                ->salutation('Cordialement, l\'équipe '.config('app.name'));
        });

    }
}
