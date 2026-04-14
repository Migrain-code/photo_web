<?php

namespace App\Notifications;

use App\Models\ContactSubmission;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContactSubmissionNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public ContactSubmission $submission
    ) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Yeni İletişim Formu Talebi - ' . $this->submission->name)
            ->greeting('Yeni İletişim Formu Talebi!')
            ->line('Sitenizden yeni bir iletişim formu talebi geldi.')
            ->line('')
            ->line('**Gönderen Bilgileri:**')
            ->line('Ad Soyad: ' . $this->submission->name)
            ->line('E-posta: ' . $this->submission->email)
            ->line('Konu: ' . $this->submission->subject)
            ->line('')
            ->line('**Mesaj:**')
            ->line($this->submission->message)
            ->line('')
            ->line('Tarih: ' . $this->submission->created_at->format('d.m.Y H:i'))
            ->action('Admin Panelde Görüntüle', url('/admin/contact-submissions/' . $this->submission->id))
            ->salutation('Grapen Studio');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'submission_id' => $this->submission->id,
            'name' => $this->submission->name,
            'email' => $this->submission->email,
        ];
    }
}
