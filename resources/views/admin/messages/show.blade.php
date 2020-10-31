@extends('layouts.app')
@section('content')
  <div class="fix-nav">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12 message-box">
          <a class="get-back-button" href="{{route('admin.messages.index', $apartment)}}">Torna indietro</a>
          <h1>{{$apartment->title}}</h1>
          <h4>Messaggi ricevuti:</h4>
            @foreach ($apartment->emails as $email)
              <ul class="card toggle-msg sender-box">
                <li>Da: {{$email->sender_email}}</li>
                 <li>
                  <ul hidden class="msg-received" >
                    <li class="message-obj">Oggetto: {{$email->object}}</li>
                    <li>"{{$email->content}}"</li>
                  </ul>
                </li>
              </ul>
            @endforeach
        </div>
      </div>
    </div>
  </div>

  <script>
    //visibilità messaggi
      $(document).on("click", ".toggle-msg", function() {
        if ( $(this).find('.msg-received').attr('hidden') ) {
          $(this).find('.msg-received').removeAttr('hidden');
        }
        else {
          $(this).find('.msg-received').attr('hidden', true);
        }
      });
  </script>
@endsection
