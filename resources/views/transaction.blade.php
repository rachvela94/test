@extends('layouts.base')

@section('content')
    <div class="container">
        <form class="form-inline" id="form" action="">
            {{ csrf_field() }}
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
            $("#stripe").click(function (){
                $("#form").attr('method', 'GET');
                $("#form").attr('action', '/paypal?amount=' + $("input").val());
                $("#form").submit();
            });
            $("#paypal").click(function (){
                $("#form").attr('method', 'POST');
                $("#form").attr('action', '/paypal?amount=' + $("input").val());
                $("#form").submit();
            });
        </script>
    @endpush
@endsection
