@extends('layouts.base')

@section('content')
    <div class="container">
        <form class="form-inline" id="form" action="">
            <input type="text" class="form-control" name="amount" id="inputPassword2" placeholder="Amount">
        </form>
        <div class="mt-3">
            <button id="stripe"  class="btn btn-primary" role="button">Pay with Card</button>
            <button id="paypal"  class="btn btn-primary"  role="button">Pay with Paypal</button>
        </div>
    </div>
    @push('script')
        <script src="{{asset('js/app.js')}}"></script>
        <script>
            $("#stripe").first().click(function (){
                $("#form").attr('action', '/stripe?amount=' + $("input").val());
                $("#form").submit();
            });
        </script>
    @endpush
@endsection
