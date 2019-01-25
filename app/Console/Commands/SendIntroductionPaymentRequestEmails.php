<?php

    namespace App\Console\Commands;

    use App\IntroApplication;
    use App\Introduction;
    use App\Mail\IntroApplicationPaymentRequest;
    use Carbon\Carbon;
    use Illuminate\Console\Command;
    use Illuminate\Support\Facades\Log;
    use Illuminate\Support\Facades\Mail;

    /**
     * Class SendIntroductionPaymentRequestEmails
     *
     * @package App\Console\Commands
     */
    class SendIntroductionPaymentRequestEmails extends Command {
        /**
         * The name and signature of the console command.
         *
         * @var string
         */
        protected $signature = 'intro:sendmails';

        /**
         * The console command description.
         *
         * @var string
         */
        protected $description = 'Stuur automatische mails naar de reserveringen van een introductie, dat het mogelijk is om te gaan betalen';

        /**
         * Create a new command instance.
         *
         * @return void
         */
        public function __construct() {
            parent::__construct();
        }

        /**
         * Execute the console command.
         *
         * @return mixed
         */
        public function handle() {
            Log::debug('Controleren of er een introductie is waarbij vandaag de betaalde inschrijvingen openen...');
            $introduction = Introduction::where('mail_reservations_at', Carbon::today())->first();
            Log::debug('Dit heb ik gevonden', [$introduction]);
            if ($introduction !== null) {
                $applications = $introduction->applications()
                    ->where('status', IntroApplication::STATUS_RESERVED)
                    ->where('type', '!=', IntroApplication::TYPE_ANONYMISED)->get();
                $applications->each(function (IntroApplication $application) {
                    $application->email_confirmation_token = str_random(64);
                    $mail = new IntroApplicationPaymentRequest($application);
                    $mail->to($application->email, $application->first_name . ' ' . $application->last_name);
                    Mail::send($mail);
                    $application->saveOrFail();
                });
                Log::debug("Mails verstuurd naar inschrijvingen", ['count' => $applications->count()]);
            }
        }
    }
