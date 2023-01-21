<?php

namespace App\Console\Commands;

use App\Models\Plan;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CreateSubscriptionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zz_own:CreateSubscriptionCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tworzenie subskrypcji po zapłaceniu tej za 1zł';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $plan = Plan::where('slug', 'basic')->first();

        $users = User::with('subscriptions')->whereHas('subscriptions', function($query){
            return $query->where('stripe_status', 'active')->where('name', '1_zl');
        })->get();

        foreach( $users as $user){
            if( !$user->subscriptions->where('name', 'basic')->count() ) $user->newSubscription( $plan->slug, $plan->stripe_plan )->create();

            Log::info('Dla usera od id: '.$user->id.' subskrypcja została: '.($user->subscriptions->where('name', 'basic')->count() ? 'nie ':'').'utworzona' );
            dump('Dla usera od id: '.$user->id.' subskrypcja została: '.($user->subscriptions->where('name', 'basic')->count() ? 'nie ':'').'utworzona' );
        }
    }
}
