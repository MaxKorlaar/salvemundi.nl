<?php

    namespace App\Mail;

    use App\MemberApplication;
    use Illuminate\Bus\Queueable;
    use Illuminate\Mail\Mailable;
    use Illuminate\Queue\SerializesModels;

    /**
     * Class NewMemberApplication
     *
     * @package App\Mail
     */
    class NewMemberApplication extends Mailable {
        use Queueable, SerializesModels;
        public $application;

        /**
         * Create a new message instance.
         *
         * @param MemberApplication $application
         */
        public function __construct(MemberApplication $application) {
            $this->application = $application;
            $this->subject(trans('email.new_member_application.subject', ['name' => $application->first_name . ' ' . $application->last_name]));
        }

        /**
         * Build the message.
         *
         * @return $this
         */
        public function build() {
            $picturePath = $this->application->getImagePath();

            return $this->view('emails.new_member_application')
                ->attach($picturePath, ['as' => 'pasfoto_' . $this->application->pcn . '.' . \File::extension($picturePath)])
                ->text('emails.plaintext.new_member_application');
        }
    }
