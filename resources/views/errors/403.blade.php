@extends('errors::custom')

@section('code', '403')
@section('message', __($exception->getMessage() ?: 'Forbidden Request'))
