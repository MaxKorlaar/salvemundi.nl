<?php

    namespace App\Mail;

    use App\Member;
    use App\Membership;
    use Illuminate\Bus\Queueable;
    use Illuminate\Mail\Mailable;
    use Illuminate\Queue\SerializesModels;

    /**
     * Class MembershipRenewPaymentConfirmation
     *
     * @package App\Mail
     */
    class MembershipRenewPaymentConfirmation extends Mailable {
        use Queueable, SerializesModels;
        public $member;
        public $membership;

        /**
         * Create a new message instance.
         *
         * @param Member     $member
         * @param Membership $membership
         */
        public function __construct(Member $member, Membership $membership) {
            $this->member     = $member;
            $this->membership = $membership;
            $this->subject(trans('email.membership.payment_confirmation.subject', ['name' => $member->first_name . ' ' . $member->last_name]));
        }

        /**
         * Build the message.
         *
         * @return $this
         */
        public function build() {
            return $this->view('emails.membership.payment_confirmation');
        }
    }
