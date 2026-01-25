<?php

namespace App\Notifications;

use App\Models\ProjectSubmission;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProjectSubmissionNotification extends Notification
{
    public function __construct(
        public ProjectSubmission $submission
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $services = is_array($this->submission->services)
            ? implode(', ', $this->submission->services)
            : (string) $this->submission->services;

        $url = route('filament.admin.resources.project-submissions.view', [
            'record' => $this->submission,
        ]);

        return (new MailMessage)
            ->subject('Yeni proje talebi: ' . $this->submission->name)
            ->greeting('Yeni proje talebi alındı')
            ->line('**Ad:** ' . $this->submission->name)
            ->line('**E-posta:** ' . $this->submission->email)
            ->line('**Telefon:** ' . $this->submission->phone)
            ->line('**Seçilen hizmetler:** ' . $services)
            ->line('**Mesaj:**')
            ->line($this->submission->message)
            ->action('Panelde görüntüle', $url)
            ->salutation('Bu e-posta otomatik gönderilmiştir.');
    }
}
