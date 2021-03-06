@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>You have now been logged in. Click here to continue.</h1>
                @if(isset($type) && $type == 'google')
                    <form action="{{ url('google-post') }}" method="POST">
                        <input type="hidden" name="code" value="{{ $access_token  }}"/>
                        <button class="btn btn-primary">Continue</button>
                    </form>
                @else
                <form action="{{ url('fb-post') }}" method="POST">
                    <input type="hidden" name="code" value="{{ $access_token  }}"/>
                    <button class="btn btn-primary">Continue</button>
                </form>
                @endif
            </div>
        </div>
    </div>
@endsection