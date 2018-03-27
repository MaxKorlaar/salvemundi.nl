<?php

    namespace App\Mail;

    use App\IntroSupervisorApplication;
    use Illuminate\Bus\Queueable;
    use Illuminate\Mail\Mailable;
    use Illuminate\Queue\SerializesModels;

    /**
     * Class NewIntroSupervisorApplication
     *
     * @package App\Mail
     */
    class NewIntroSupervisorApplication extends Mailable {
        use Queueable, SerializesModels;
        public $application;

        /**
         * Create a new message instance.
         *
         * @param IntroSupervisorApplication $application
         */
        public function __construct(IntroSupervisorApplication $application) {
            $this->application = $application;
            $this->subject(trans('email.intro.supervisor.new_application.subject', ['name' => $application->first_name . ' ' . $application->last_name]));
        }

        /**
         * Build the message.
         *
         * @return $this
         */
        public function build() {
            return $this->view('emails.intro.supervisor.new_application');
        }
    }
