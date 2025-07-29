{{-- Устаткування шаблонів макету і фактичного шаблону --}}
@extends('layouts.app')
{{-- Визначаємо розділ для розширення макету app.blade.php за допомогою директиви section--}}
@section('title', $task->title) {{-- $task - зміна завдання, ця зміна є об'єктом і має властивість title --}}

@section('content')
{{--Додаємо посилання яке поверне користувача назад до списку--}}
    <div class="mb-4"> {{--Додаємо стилізацію--}}
        <a href="{{route('tasks.index')}}"class="link">← Go back to the task list!</a> {{--Додаємо стилі--}}
    </div>
<p class="mb-4 text-slate-700">{{ $task->description }}</p> {{--Додаємо стилі--}}
{{-- Використовуємо директиву if --}}
@if($task->long_description)
    <p class="mb-4 text-slate-700">{{ $task->long_description }}</p> {{--Додаємо стилі--}}
@endif

<p class="mg-4 text-sm text-slate-500">
    Created
    {{ $task->created_at->diffForHumans() }}
    • Updated
    {{ $task->updated_at->diffForHumans() }}</p> {{--Додаємо стилі також використовуємо метод diffForHumans для обробки дат--}}
</p>

<p class="mb-4"> {{--Додаємо стилі--}}
    @if ($task->completed)
        <span class="font-medium text-green-500">Completed</span>{{--Додаємо стилі--}}
    @else
        <span class="font-medium text-red-500">Not Completed</span> {{--Додаємо стилі--}}
    @endif
</p>

{{--Додаємло посилання на редагування форми--}}
<div class="flex gap-2"> {{--Додаємо стилі--}}
    <a href="{{ route('tasks.edit', ['task' => $task]) }}"
        class="btn">Edit</a> {{--Додаємо стилі--}}

{{--Додаємо посилання на маршрут перемикання--}}
    <form method="POST" action="{{route('tasks.toggle-complete', ['task' => $task])}}">
        {{--Додавання директиви csrf використання цієї директиви допомагає нам захистити користувачів від так званної атаки csrf, що означає підробку міжсайтових запитів--}}
        @csrf
        {{--Використовуємо директиву методу спуфінг--}}
        @method('PUT')
        <button type="submit" class="btn">
            Mark as {{$task->completed ? 'not completed' : 'completed'}}
        </button>
    </form>

    {{--Додаємо посилання на маршрут видалення--}}
    <form action="{{route('tasks.destroy', ['task' => $task])}}" method="POST">
        {{--Додавання директиви csrf використання цієї директиви допомагає нам захистити користувачів від так званної атаки csrf, що означає підробку міжсайтових запитів--}}
       @csrf
       {{--Використовуємо директиву методу спуфінг для видалення--}}
       @method('DELETE')
       <button type="submit" class="btn">
            DELETE
       </button>
    </form>
</div>
@endsection
