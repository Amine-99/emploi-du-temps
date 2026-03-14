<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LinkUpdatedNotification extends Notification
{
    use Queueable;

    protected $professeur;

    public function __construct($professeur)
    {
        $this->professeur = $professeur;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => "Le lien de cours de Mr/Mme " . $this->professeur->nom . " a été mis à jour.",
            'professeur_id' => $this->professeur->id,
            'type' => 'link_update'
        ];
    }
}
