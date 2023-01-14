<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;
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
        $plans = Plan::get();

        return view("plans", compact("plans"));
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function show(Plan $plan, Request $request)
    {
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
        $plan = Plan::find($request->plan);
        // $plan = Plan::where('slug', 'one-day-trial')->first();



                        try {
                            $subscription = $request->user()->newSubscription($request->plan, $plan->stripe_plan)->trialDays(1)
                            ->create($request->token);
                        } catch (IncompletePayment $exception) {
                            return redirect()->route(
                                'cashier.payment',
                                [$exception->payment->id, 'redirect' => route('plans.index')]
                            );
                        }

        return view("subscription_success");
    }
}
