<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Achat;
use App\Models\Vignette;
use App\Models\Voiture;

class TransactionComplete extends Mailable
{
    public $achat;
    public $qrPath;
    public $vignette;
    public $voiture;

    public function __construct(Achat $achat, $qrPath, Vignette $vignette, Voiture $voiture)
    {
        $this->achat = $achat;
        $this->qrPath = $qrPath;
        $this->vignette = $vignette;
        $this->voiture = $voiture;
    }

    public function build()
    {
        return $this->view('emails.transaction-complete')
                    ->subject('Transaction Complète - Votre E-Vignette')
                    ->with([
                        'achat' => $this->achat,
                        'vignette' => $this->vignette,
                        'voiture' => $this->voiture,
                    ])
                    ->attach($this->qrPath, [
                        'as' => 'qr-code.svg',
                        'mime' => 'image/svg+xml',
                    ]);
    }
}
