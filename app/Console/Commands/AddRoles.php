<?php

    namespace App\Console\Commands;

    use Illuminate\Console\Command;
    use Spatie\Permission\Models\Permission;
    use Spatie\Permission\Models\Role;

    /**
     * Class AddRoles
     *
     * @package App\Console\Commands
     */
    class AddRoles extends Command {
        /**
         * The name and signature of the console command.
         *
         * @var string
         */
        protected $signature = 'roles:create';

        /**
         * The console command description.
         *
         * @var string
         */
        protected $description = 'Add roles for the users of SalveMundi.nl';

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
        public static function handle() {
            $memberNamePermission     = Permission::create(['name' => 'view member names']);
            $memberAddressPermission  = Permission::create(['name' => 'view member addresses']);
            $memberEmailPermission    = Permission::create(['name' => 'view member emails']);
            $memberPersonalPermission = Permission::create(['name' => 'view member personal info']);
            $memberViewPermission     = Permission::create(['name' => 'view members']);
            $memberEditPermission     = Permission::create(['name' => 'edit members']);
            $memberDeletePermission   = Permission::create(['name' => 'delete members']);

            $membershipAddPermission  = Permission::create(['name' => 'add memberships']);
            $membershipViewPermission = Permission::create(['name' => 'view memberships']);
            $membershipEditPermission = Permission::create(['name' => 'edit memberships']);

            $memberTransactionsViewPermission = Permission::create(['name' => 'view member transactions']);
            $memberCampsViewPermission        = Permission::create(['name' => 'view member camps']);
            $memberOrdersViewPermission       = Permission::create(['name' => 'view member orders']);

            $storeViewPermission   = Permission::create(['name' => 'view store items']);
            $storeEditPermission   = Permission::create(['name' => 'edit store items']);
            $storeDeletePermission = Permission::create(['name' => 'delete store items']);

            $introViewPermission = Permission::create(['name' => 'view introductions']);
            $introEditPermission = Permission::create(['name' => 'edit introductions']);
            $introDeletePermission = Permission::create(['name' => 'delete introductions']);

            Permission::create(['name' => 'view introduction signups']);
            Permission::create(['name' => 'edit introduction signups']);
            Permission::create(['name' => 'delete introduction signups']);

            Permission::create(['name' => 'view introduction supervisor signups']);
            Permission::create(['name' => 'edit introduction supervisor signups']);
            Permission::create(['name' => 'delete introduction supervisor signups']);


            $admin = Role::create(['name' => 'admin']); // Super-admin. Heeft alle permissions automatisch

            //        $storemanager = Role::create(['name' => 'storemanager']); // Heeft inzicht en beheer over de winkel
            //        $storemanager->givePermissionTo('view store items', 'edit store items', 'delete store items');

        }
    }
