{{-- Inizializzo Braintree (chiavi da nascondere) --}}
@php
  $gateway = new \Braintree\Gateway([
   'environment' => 'sandbox',
   'merchantId' => 'ctnsy5nzc67bcxs9',
   'publicKey' => '37j252dqyn8knhm9',
   'privateKey' => '472ed33db6e375cace43f9f60f95c57d'
   ]);

  $clientToken = $gateway->clientToken()->generate();
@endphp

@extends('layouts.app')
@section('content')
  <div class="fix-nav">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <h1>Sponsorizza il tuo appartamento</h1>
          <form class="" action="{{route('admin.sponsorships.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            @method('POST')

            {{-- select appartamenti utente --}}
            <div class="apartment">
              <label>Appartamento</label>
              <select name="apartment_id">
                @foreach ($apartments as $apartment)
                  <option value="{{$apartment->id}}">{{$apartment->title}} ({{$apartment->address}} - {{$apartment->city}})</option>
                @endforeach
              </select>
            </div>

            {{-- select sponsorizzazioni --}}
            <div class="amount">
              <label>Importo</label>
              <select name="sponsorship_id">
                @foreach ($sponsorships as $sponsorship)
                  <option value="{{$sponsorship->id}}">{{$sponsorship->amount}}€ ({{$sponsorship->duration}}h)</option>
                @endforeach
              </select>
            </div>

               <div id="payment-form"></div>
               {{-- Invio form pagamento --}}
               <button type="submit">Submit Order</button>
            </form>

            <script src="https://js.braintreegateway.com/js/braintree-2.32.1.min.js"></script>
            <script type="text/javascript">
                $(function () {
                    braintree.setup('{{ $clientToken }}', 'dropin', {
                        container: 'payment-form'
                    });
                });
            </script>
        </div>
      </div>
    </div>
  </div>
@endsection
