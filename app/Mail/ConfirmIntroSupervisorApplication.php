<?php

    namespace App\Mail;

    use App\IntroSupervisorApplication;
    use Illuminate\Bus\Queueable;
    use Illuminate\Mail\Mailable;
    use Illuminate\Queue\SerializesModels;

    /**
     * Class ConfirmIntroSupervisorApplication
     *
     * @package App\Mail
     */
    class ConfirmIntroSupervisorApplication extends Mailable {
        use Queueable, SerializesModels;
        public $application;

        /**
         * Create a new message instance.
         *
         * @param IntroSupervisorApplication $application
         */
        public function __construct(IntroSupervisorApplication $application) {
            $this->application = $application;
            $this->subject(trans('email.intro.supervisor.confirm_application.subject', [
                'name' => $application->member->first_name . ' ' . $application->member->last_name
            ]));
        }

        /**
         * Build the message.
         *
         * @return $this
         */
        public function build() {
            return $this->view('emails.intro.supervisor.confirm_application');
        }
    }
