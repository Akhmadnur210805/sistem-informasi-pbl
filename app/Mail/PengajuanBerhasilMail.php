<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PengajuanBerhasilMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pengajuan;

    public function __construct($pengajuan)
    {
        $this->pengajuan = $pengajuan;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Notifikasi Pengajuan BAZNAS - ' . $this->pengajuan->nomor_pengajuan,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.pengajuan_berhasil', // Kita akan buat file view-nya setelah ini
        );
    }
}