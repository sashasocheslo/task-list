@extends('layouts.app')

@section('title', 'Edit Taks')

@section('content')
    {{--Для розширення макету ми використовуємо диретиву include--}}
    @include('form', ['task' => $task]) {{--Додаємо завдання --}}
@endsection
