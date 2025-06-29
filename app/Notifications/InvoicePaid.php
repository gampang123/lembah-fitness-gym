<?php

namespace App\Notifications;

use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InvoicePaid extends Notification implements ShouldQueue
{
    use Queueable;

    public $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Pembayaran Berhasil')
            ->greeting('Hai ' . $notifiable->name)
            ->line('Terima kasih! Pembayaran Anda telah berhasil.')
            ->line('Jumlah: Rp ' . number_format($this->transaction->amount, 0, ',', '.'))
            ->line('Order ID: ' . $this->transaction->midtrans_order_id)
            ->line('Kami telah mengaktifkan layanan Anda.')
            ->action('Lihat Transaksi', url('/transaksi/' . $this->transaction->id))
            ->line('Terima kasih telah menggunakan layanan kami.');
    }
}
