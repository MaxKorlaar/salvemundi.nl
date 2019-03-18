<?php

    namespace App\Console\Commands;

    use App\Member;
    use Carbon\Carbon;
    use Illuminate\Console\Command;

    /**
     * Class PermanentlyDeleteTrashedMembers
     *
     * @package App\Console\Commands
     */
    class PermanentlyDeleteTrashedMembers extends Command {

        /**
         * The name and signature of the console command.
         *
         * @var string
         */
        protected $signature = 'members:delete-trashed';

        /**
         * The console command description.
         *
         * @var string
         */
        protected $description = 'Verwijder leden permanent die al meer dan 31 dagen verwijderd zijn';

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
         * @throws \Exception
         */
        public function handle() {
            \Log::debug("Verwijderde leden worden nu permanent verwijderd.");
            Member::onlyTrashed()->where('deleted_at', '>', Carbon::today()->subDays(31))->each(function (Member $member) {
                $result = $member->reallyDelete();
                \Log::debug('Lid is permanent verwijderd', ['id' => $member->id, 'result' => $result]);
            });
            $this->info('Verwijderde leden zijn automatisch permanent verwijderd.');
            \Log::debug("Verwijderde leden zijn automatisch permanent verwijderd.");
        }
    }
