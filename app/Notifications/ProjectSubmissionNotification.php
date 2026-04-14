<?php

namespace App\Notifications;

use App\Models\ProjectSubmission;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProjectSubmissionNotification extends Notification implements ShouldQueue
{
    use Queueable;

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
            ->subject('Yeni Proje Başvurusu - ' . $this->submission->name)
            ->greeting('Yeni Proje Başvurusu!')
            ->line('Sitenizden yeni bir proje başvurusu geldi.')
            ->line('')
            ->line('**Başvuru Sahibi Bilgileri:**')
            ->line('Ad Soyad: ' . $this->submission->name)
            ->line('E-posta: ' . $this->submission->email)
            ->line('Telefon: ' . $this->submission->phone)
            ->line('')
            ->line('**Talep Edilen Hizmetler:**')
            ->line($services)
            ->line('')
            ->line('**Proje Detayları:**')
            ->line($this->submission->message ?: 'Mesaj girilmemiş')
            ->line('')
            ->line('Tarih: ' . $this->submission->created_at->format('d.m.Y H:i'))
            ->action('Admin Panelde Görüntüle', $url)
            ->salutation('Grapen Studio');
    }
}
