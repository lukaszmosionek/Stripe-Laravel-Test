<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Cashier\Exceptions\IncompletePayment;

class PlanController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        $plans = Plan::where('is_visible', true)->get();

        return view("plans", compact("plans"));
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function show(Request $request)
    {
        $plan = Plan::where('slug', request('plan') )->first();

        if(! auth()->check() ){
                $user = User::create([
                    'name' => $request->email,
                    'email' => $request->email,
                    'password' => Hash::make('password'),
                ]);

                auth()->login($user);
        }

        $intent = auth()->user()->createSetupIntent();

        return view("subscription", compact("plan", "intent"));
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function subscription(Request $request)
    {
        // $plan = Plan::find($request->plan);
        $plan = Plan::where('slug', 'one-day-trial')->first();



                        try {
                            $subscription = $request->user()->newSubscription('1_zl', $plan->stripe_plan)->create($request->token);

                            // $request->user()->update('1zl_subs_ends_at', now()->addDays(2) );
                        } catch (IncompletePayment $exception) {
                            return redirect()->route(
                                'cashier.payment',
                                [$exception->payment->id, 'redirect' => route('plans.index')]
                            );
                        }

        return view("subscription_success");
    }
}
