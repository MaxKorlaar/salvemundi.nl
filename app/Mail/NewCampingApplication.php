<?php

    namespace App\Mail;

    use App\CampingApplication;
    use Illuminate\Bus\Queueable;
    use Illuminate\Mail\Mailable;
    use Illuminate\Queue\SerializesModels;

    /**
     * Class NewCampingApplication
     *
     * @package App\Mail
     */
    class NewCampingApplication extends Mailable {
        use Queueable, SerializesModels;
        public $application;

        /**
         * Create a new message instance.
         *
         * @param CampingApplication $application
         */
        public function __construct(CampingApplication $application) {
            $this->application = $application;
            $this->subject(trans('email.camping.new_application.subject', ['name' => $application->first_name . ' ' . $application->last_name]));
        }

        /**
         * Build the message.
         *
         * @return $this
         */
        public function build() {
            return $this->view('emails.camping.new_application')
                ->text('emails.plaintext.camping.new_application');
        }
    }
