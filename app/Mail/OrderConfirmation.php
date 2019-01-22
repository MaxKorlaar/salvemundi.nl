<?php

    namespace App\Mail;

    use App\Store\Order;
    use Illuminate\Bus\Queueable;
    use Illuminate\Mail\Mailable;
    use Illuminate\Queue\SerializesModels;

    /**
     * Class OrderConfirmation
     *
     * @package App\Mail
     */
    class OrderConfirmation extends Mailable {
        use Queueable, SerializesModels;
        public $order;
        public $vat;
        public $total;
        public $subtotal;

        /**
         * Create a new message instance.
         *
         * @param Order $order
         *
         * @throws \Throwable
         */
        public function __construct(Order $order) {
            $this->order = $order;
            $total = 0;
            foreach ($order->items as $item) {
                $total += $item->amount * $item->price;
            }

            $this->vat     = 0.21 * $total;
            $this->total   = $total;
            $this->subtotal = $total;
            $this->subject = trans('email.store.order_confirmation.subject', [ 'invoice' => $order->calculateInvoiceNumber() ]);
        }

        /**
         * Build the message.
         *
         * @return $this
         */
        public function build() {
            return $this->view('emails.store.order_confirmation');
        }
    }
