<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe;
use Session;

class StripeController extends Controller
{
    /**
     * payment view
     */
    public function handleGet()
    {
        return view('stripe');
    }

    /**
     * handling payment with POST
     */
    public function handlePost(Request $request)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
          $response = Stripe\Charge::create ([
                  "amount" => request('amount'),
                  "currency" => "usd",
                  "source" => $request->stripeToken,
                  "description" => "Making test payment of 200 ruppes. Rati"
          ]);

      dd($response);


        //$respomse obj if paid set to 1
        Session::flash('success', 'Payment has been successfully processed.');

        return back();
    }
}
