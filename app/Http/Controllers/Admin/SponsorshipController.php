<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Sponsorship;
use App\Apartment;

class SponsorshipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $customer = Auth::user();
      $sponsorships = Sponsorship::all();

      //query di tutti gli appartamenti dell'utente loggato
      $apartments = DB::table('apartments')->select('*')->where('user_id', $customer->id)->get();

      // quando l'utente schiaccia il bottone di checkout
      if( $request->isMethod('post') )
      {
         // variabile nouce (una tantum) del pagamento corrente
         $payment_method_nonce = $request->get('payment_method_nonce');

         // controllo univocità del nounce
         if ( !$customer->braintree_nonce )
           {
             // viene salvato il nounce dell'utente
             $result = \Braintree_PaymentMethod::create([
               'customerId' => $customer->braintree_customer_id,
               'paymentMethodNonce' => $payment_method_nonce
             ]);

             $customer->braintree_nonce = $result->paymentMethod->token;
             $customer->save();
           }

         // viene processato il pagamento dell'utente
         $client_nonce = \Braintree_PaymentMethodNonce::create($customer->braintree_nonce);
         $result = \Braintree_Transaction::sale([
            'amount' => 100,
            'options' => [ 'submitForSettlement' => True ],
            'paymentMethodNonce' => $client_nonce->paymentMethodNonce->nonce
         ]);

         if( !empty($result->transaction) ) {
           // il pagamento è avvenuto con successo
         }
         else {
           // il pagamento non è avvenuto
         }
      }

     return view('admin.sponsorships.index', compact('sponsorships','apartments', 'customer'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $data = $request->all();
      $apartments = Apartment::all();

      //scorro tutti gli appartamenti e aggiungo un nuovo record alla tabella ponte appartamenti_sponsorizzazioni se il pagamento è andato a buon fine
      foreach ($apartments as $apartment) {
        if ($apartment['id'] == $data['apartment_id']){
          if (isset($data['payment_method_nonce'])){
            $apartment->sponsorships()->sync($data['sponsorship_id']);
          }

          return redirect()->route('admin.apartments.show', $apartment);
        }
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
