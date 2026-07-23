<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PromoTestCompleted
{
    use Dispatchable, SerializesModels;

    public $leadId;
    public $whatsappNumber;
    public $aiFeedback;

    public function __construct($leadId, $whatsappNumber, $aiFeedback)
    {
        $this->leadId = $leadId;
        $this->whatsappNumber = $whatsappNumber;
        $this->aiFeedback = $aiFeedback;
    }
}
