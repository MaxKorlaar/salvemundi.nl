<?php

    namespace App\Mail;

    use App\MemberApplication;
    use Illuminate\Bus\Queueable;
    use Illuminate\Mail\Mailable;
    use Illuminate\Queue\SerializesModels;

    /**
     * Class ConfirmApplication
     *
     * @package App\Mail
     */
    class ConfirmApplication extends Mailable {
        use Queueable, SerializesModels;
        public $application;

        /**
         * Create a new message instance.
         *
         * @param MemberApplication $application
         */
        public function __construct(MemberApplication $application) {
            $this->application = $application;
            $this->subject(trans('email.confirm_application.subject', ['name' => $application->first_name . ' ' . $application->last_name]));
        }

        /**
         * Build the message.
         *
         * @return $this
         */
        public function build() {
            return $this->view('emails.confirm_application')->text('emails.plaintext.confirm_application');
        }
    }
