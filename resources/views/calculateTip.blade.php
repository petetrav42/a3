@extends('layouts.master')

@section('title')
Assignment 3 - Tip Calculator
@endsection

@section('content')
<h1 class='text-center'>Tip Calculator</h1>

<form method='GET' action='/calculateTip' class='form-horizontal'>
    <div class='form-group'>
        <label for='initialBill' class='col-sm-5 control-label'>How much is your initial bill?<span class="required">*</span></label>
        <div class='col-sm-3'>
            <input type='text' name='initialBill' id='initialBill' value='@if($errors->get('initialBill')){{old('initialBill')}}@else{{$initialBill}}@endif' class='form-control' required>
            @if($errors->get('initialBill'))
                <div class="alert-danger text-center">
                    @foreach($errors->get('initialBill') as $error)
                        {{ $error }}
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    <div class='form-group'>
        <label for='splitNumber' class='col-sm-5 control-label'>Split bill how many ways?<span class="required">*</span></label>
        <div class='col-sm-3'>
            <input type='text' name='splitNumber' id='splitNumber' value='@if($errors->get('splitNumber')){{old('splitNumber')}}@else{{$splitNumber}}@endif' class='form-control' required>
            @if($errors->get('splitNumber'))
                <div class="alert-danger text-center">
                    @foreach($errors->get('splitNumber') as $error)
                        {{ $error }}
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    <div class='form-group'>
        <label for='service' class='col-sm-5 control-label'>How was the service?<span class="required">*</span></label>
        <div class='col-sm-3'>
            <select class='form-control' name='service' id='service' required>
                <option value='' @if($errors->get('service')) SELECTED @endif>Choose One</option>
                <option value='{{'excellent'}}' @if((!$errors->get('service')) && $service == 'excellent') SELECTED @endif>Excellent - 20% Tip</option>
                <option value='{{'good'}}' @if((!$errors->get('service')) && $service == 'good') SELECTED @endif>Good - 18% Tip</option>
                <option value='{{'average'}}' @if((!$errors->get('service')) && $service == 'average') SELECTED @endif>Average - 15% Tip</option>
                <option value='{{'poor'}}' @if((!$errors->get('service')) && $service == 'poor') SELECTED @endif>Poor - 10% Tip</option>
                <option value='{{'horrible'}}' @if((!$errors->get('service')) && $service == 'horrible') SELECTED @endif>Horrible - No Tip</option>
            </select>
            @if($errors->get('service'))
                <div class="alert-danger text-center">
                    @foreach($errors->get('service') as $error)
                        {{ $error }}
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    <div class='form-group'>
        <label class='col-sm-5 control-label'>Round tip?</label>
        <div class='col-sm-3 radio-padding'>
            <p class='radio'><input type='radio' name='roundTip' value='{{'roundUp'}}' @if($roundTip == 'roundUp') CHECKED @endif />Round Up</p>
            <p class='radio'><input type='radio' name='roundTip' value='{{'roundDown'}}' @if($roundTip == 'roundDown') CHECKED @endif />Round Down</p>
            <p class='radio'><input type='radio' name='roundTip' value='' @if($roundTip == '') CHECKED @endif />Don't Round</p>
        </div>
    </div>
    <div class='form-group'>
        <div class='col-sm-offset-5 col-sm-10'>
            <input type='submit' class='btn btn-default'>
        </div>
        <div class='col-sm-offset-5 col-sm-6'>
            <p><span class="required">*</span> Required</p>
        </div>

    </div>
</form>

@if($initialBill)
    <div class='text-center'>
        @if(!$errors->all())
            <div class='alert alert-success'>
                <p>Initial Bill: ${{$initialBill}}</p>

                @if ($splitNumber > 1)
                    <p>Splitting Bill: {{$splitNumber}} ways</p>
                @endif

                <p>Service Quality: {{$service}}</p>

                <p>Tip percentage: {{$tipPercentage}}%</p>

                @if ($splitNumber > 1)
                    <p>Amount each person pays without rounding: ${{$billWithTip}}</p>
                    @if($roundTip)
                        <p>Amount each person pays when rounding: ${{$finalBill}}</p>
                    @endif
                @else
                    <p>Amount you pay without rounding: ${{$billWithTip}}</p>
                    @if($roundTip)
                        <p>Amount you pay when rounding: ${{$finalBill}}</p>
                    @endif
                @endif
            </div>
        @endif
    </div>
@endif

@endsection