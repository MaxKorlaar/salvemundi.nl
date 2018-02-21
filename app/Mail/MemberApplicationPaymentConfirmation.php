<?php

    namespace App\Mail;

    use App\MemberApplication;
    use Illuminate\Bus\Queueable;
    use Illuminate\Mail\Mailable;
    use Illuminate\Queue\SerializesModels;

    /**
     * Class ConfirmMemberApplication
     *
     * @package App\Mail
     */
    class MemberApplicationPaymentConfirmation extends Mailable {
        use Queueable, SerializesModels;
        public $application;

        /**
         * Create a new message instance.
         *
         * @param MemberApplication $application
         */
        public function __construct(MemberApplication $application) {
            $this->application = $application;
            $this->subject(trans('email.signup.payment_confirmation.subject', ['name' => $application->first_name . ' ' . $application->last_name]));
        }

        /**
         * Build the message.
         *
         * @return $this
         */
        public function build() {
            return $this->view('emails.signup.payment_confirmation')->text('emails.plaintext.signup.payment_confirmation');
        }
    }
