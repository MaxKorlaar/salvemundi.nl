<?php

    namespace App\Mail;

    use App\IntroApplication;
    use Illuminate\Bus\Queueable;
    use Illuminate\Mail\Mailable;
    use Illuminate\Queue\SerializesModels;

    /**
     * Class NewIntroApplication
     *
     * @package App\Mail
     */
    class NewIntroApplication extends Mailable {
        use Queueable, SerializesModels;
        public $application;

        /**
         * Create a new message instance.
         *
         * @param IntroApplication $application
         */
        public function __construct(IntroApplication $application) {
            $this->application = $application;
            $this->subject(trans('email.intro.new_application.subject', ['name' => $application->first_name . ' ' . $application->last_name]));
        }

        /**
         * Build the message.
         *
         * @return $this
         */
        public function build() {
            return $this->view('emails.intro.new_application')
                ->text('emails.plaintext.intro.new_application');
        }
    }
