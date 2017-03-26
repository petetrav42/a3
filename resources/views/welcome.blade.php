@extends('layouts.master')

@section('title')
    Assignment 3
@endsection

@section('content')
<h1 class='text-center'>Assignment 3 Welcome Page</h1>
<br />
<form method="get" action="/calculateTip" class="text-center">
    <button type="submit">Let's Calculate Your Tip</button>
</form>
<br />
@endsection
