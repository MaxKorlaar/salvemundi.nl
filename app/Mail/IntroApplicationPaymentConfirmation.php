<?php

    namespace App\Mail;

    use App\IntroApplication;

    use Illuminate\Bus\Queueable;
    use Illuminate\Mail\Mailable;
    use Illuminate\Queue\SerializesModels;

    /**
     * Class IntroApplicationPaymentConfirmation
     *
     * @package App\Mail
     */
    class IntroApplicationPaymentConfirmation extends Mailable {
        use Queueable, SerializesModels;
        public $application;

        /**
         * Create a new message instance.
         *
         * @param IntroApplication $application
         */
        public function __construct(IntroApplication $application) {
            $this->application = $application;
            $this->subject(trans('email.intro.payment_confirmation.subject', ['name' => $application->first_name . ' ' . $application->last_name]));
        }

        /**
         * Build the message.
         *
         * @return $this
         */
        public function build() {
            return $this->view('emails.intro.payment_confirmation')->text('emails.plaintext.intro.payment_confirmation');
        }
    }
