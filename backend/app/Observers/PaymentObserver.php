<?php

namespace App\Observers;

use App\Helpers\Model;
use App\Models\{Payment,Log};

class PaymentObserver
{
    use Model;
    /**
     * Handle the Payment "created" event.
     *
     * @param  \App\Models\Payment  $payment
     * @return void
     */
    public function created(Payment $payment)
    {
        self::setData([
            'entity' => 'Payment',
            'new_values' => json_encode($payment),
            'action' => 'create',
            'user_id' => $payment->user_id
        ],Log::class);
    }

    /**
     * Handle the Payment "updated" event.
     *
     * @param  \App\Models\Payment  $payment
     * @return void
     */
    public function updated(Payment $payment)
    {
        self::setData([
            'entity' => 'Payment',
            'old_values' => json_encode($payment->getOriginal()),
            'new_values' => json_encode($payment),
            'action' => 'update',
            'user_id' => $payment->user_id,
        ],Log::class);
    }

    /**
     * Handle the Payment "deleted" event.
     *
     * @param  \App\Models\Payment  $payment
     * @return void
     */
    public function deleted(Payment $payment)
    {
        self::setData([
            'entity' => 'Payment',
            'old_values' => json_encode($payment->getOriginal()),
            'new_values' => json_encode($payment->getOriginal()),
            'action' => 'delete',
            'user_id' => $payment->user_id,
        ],Log::class);
    }

    /**
     * Handle the Payment "restored" event.
     *
     * @param  \App\Models\Payment  $payment
     * @return void
     */
    public function restored(Payment $payment)
    {
        //
    }

    /**
     * Handle the Payment "force deleted" event.
     *
     * @param  \App\Models\Payment  $payment
     * @return void
     */
    public function forceDeleted(Payment $payment)
    {
        //
    }
}
