@extends('layouts.master')

@section('title')
Assignment 3 - Tip Calculator
@endsection

@section('content')
<h1 class='text-center'>Tip Calculator</h1>

<form method='get' action='/calculateTip' class='form-horizontal'>
    <div class='form-group'>
        <label for='initialBill' class='col-sm-5 control-label'>How much is your initial bill?<span class="required">*</span></label>
        <div class='col-sm-3'>
            <input type='text' name='initialBill' id='initialBill' value='{{ $initialBill or '' }}' class='form-control' required>
        </div>
<!--        @if(count($errors) > 0)-->
<!--            <ul>-->
<!--                @foreach ($errors->all() as $error)-->
<!--                <li>{{ $error }}</li>-->
<!--                @endforeach-->
<!--            </ul>-->
<!--        @endif-->
    </div>
    <div class='form-group'>
        <label for='splitNumber' class='col-sm-5 control-label'>Split bill how many ways?<span class="required">*</span></label>
        <div class='col-sm-3'>
            <input type='number' name='splitNumber' id='splitNumber' value='{{ $splitNumber or '' }}' class='form-control' required>
        </div>
    </div>
    <div class='form-group'>
        <label for='service' class='col-sm-5 control-label'>How was the service?<span class="required">*</span></label>
        <div class='col-sm-3'>
            <select class='form-control' name='service' id='service' required>
                <option value='' @if($service == '') SELECTED @endif>Choose One</option>
                <option value='excellent' @if($service == 'excellent') SELECTED @endif>Excellent - 20% Tip</option>
                <option value='good' @if($service == 'good') SELECTED @endif>Good - 18% Tip</option>
                <option value='average' @if($service == 'average') SELECTED @endif>Average - 15% Tip</option>
                <option value='poor' @if($service == 'poor') SELECTED @endif>Poor - 10% Tip</option>
                <option value='horrible' @if($service == 'horrible') SELECTED @endif>Horrible - No Tip</option>
            </select>
        </div>
    </div>
    <div class='form-group'>
        <label class='col-sm-5 control-label'>Round tip?</label>
        <div class='col-sm-3 radio-padding'>
            <p class='radio'><input type='radio' name='roundTip' value='roundUp' @if($roundTip == 'roundUp') CHECKED @endif />Round Up</p>
            <p class='radio'><input type='radio' name='roundTip' value='roundDown' @if($roundTip == 'roundDown') CHECKED @endif />Round Down</p>
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
@endsection