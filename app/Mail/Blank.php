<?php

    namespace App\Mail;

    use Illuminate\Bus\Queueable;
    use Illuminate\Mail\Mailable;
    use Illuminate\Queue\SerializesModels;

    /**
     * Class Blank
     *
     * @package App\Mail
     */
    class Blank extends Mailable {
        use Queueable, SerializesModels;
        public $content;

        /**
         * Create a new message instance.
         *
         * @param $content
         */
        public function __construct($content, $subject) {
            $this->content = $content;
            $this->subject = $subject;
        }

        /**
         * Build the message.
         *
         * @return $this
         */
        public function build() {
            return $this->view('emails.blank');
        }
    }
