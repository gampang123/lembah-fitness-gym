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
    protected $type;


    public function __construct(Transaction $transaction, $type = 'user')
    {
        $this->transaction = $transaction;
        $this->type = $type;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        if ($this->type === 'admin') {
            return (new MailMessage)
                ->subject('Notifikasi Admin: Transaksi Berhasil')
                ->greeting('Halo Admin')
                ->line('Ada transaksi baru yang telah berhasil dibayar.')
                ->line('Pelanggan : ' . $this->transaction->user->name)
                ->line('Jumlah: Rp ' . number_format($this->transaction->package->price ?? 0, 0, ',', '.'))
                ->line('Paket: ' . $this->transaction->package->name)
                ->action('Lihat Detail', url('/transaction' . $this->transaction->id));
        }

        return (new MailMessage)
            ->subject('Pembayaran Berhasil')
            ->greeting('Hai ' . $notifiable->name)
            ->line('Terima kasih! Pembayaran Anda telah berhasil.')
            ->line('Jumlah: Rp ' . number_format($this->transaction->package->price ?? 0, 0, ',', '.'))
            ->line('Paket: ' . $this->transaction->package->name)
            ->line('Kami telah mengaktifkan layanan Anda.')
            ->action('Lihat Transaksi', url('/member/report-transaction-member/' . $this->transaction->id))
            ->line('Terima kasih telah menggunakan layanan kami.');
    }
}
