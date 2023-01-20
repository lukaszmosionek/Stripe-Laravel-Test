@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Select Plane:</div>

                <form action="{{ route('plans.show') }}" method="GET">

                <div class="card-body">

                    @guest
                    <div class="row mb-5">
                        <div class="">
                            <div class="form-group">
                                <label for="">Email:</label>
                                <input type="email" required name="email" id="card-holder-email" class="form-control" value="test{{ rand(999,9999) }}@onet.pl" placeholder="Email">
                            </div>
                        </div>
                    </div>
                    @endguest

                    <div class="row">
                        @foreach($plans as $plan)
                            <div class="col-md-6">
                                <div class="card mb-3">
                                  <div class="card-header">
                                        ${{ $plan->price }}/Mo
                                  </div>
                                  <div class="card-body">
                                    <h5 class="card-title">{{ $plan->name }}</h5>
                                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the cards content.</p>

                                    <input type="hidden" value="{{ $plan->slug }}" name="plan" />
                                    <input type="submit" value="Choose" class="btn btn-primary pull-right">

                                  </div>
                                </div>
                            </div>
                            {{--  @break  --}}
                        @endforeach
                    </div>

                </div>
            </form>
            </div>
        </div>
    </div>
</div>
@endsection
