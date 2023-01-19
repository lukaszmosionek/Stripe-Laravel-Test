<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

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

        $users = User::with('subscriptions')->whereHas('subscriptions', function($query){
            return $query->where('stripe_status', 'active')->where('name', '1_zl');
        })->get();

        foreach( $users as $user){
            if( !$user->subscriptions->where('name', 'basic')->count() ) $user->newSubscription('basic','price_1MQzVXKh1i2J84rhGzfLMnGM')->trialDays(1)->create();
            dump('Dla usera od id: '.$user->id.' subskrypcja została: '.($user->subscriptions->where('name', 'basic')->count() ? 'nie ':'').'utworzona' );
        }
    }
}
