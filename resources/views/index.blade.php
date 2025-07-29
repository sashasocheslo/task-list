{{-- Устаткування шаблонів макету і фактичного шаблону --}}
@extends('layouts.app')
{{-- Визначаємо розділ для розширення макету app.blade.php за допомогою директиви section--}}
@section('title', 'The list of tasks!')


{{-- Використання умовного рендерингу та директиви --}}
{{-- @isset($name)
<div>The name is: {{ $name }}</div>
@endisset --}}

{{-- <div>
    @if(count($tasks))
    @foreach ($tasks as $task)
    <div>{{$task->title}}</div>
    @endforeach
    @else
    <div>There are no tasks!</div>
    @endif
</div> --}}

@section('content')

{{--Додаємо кнопку для створення завдання--}}
<nav class="mb-4"> {{--Додаємо стилі--}}
    <a href="{{route('task.create')}}" class="link">Add Task</a> {{--Додаємо стилі--}}
</nav>
    {{-- @if(count($tasks)) --}}
    @forelse ($tasks as $task)
    {{-- <div>{{$task->title}}</div> --}}
    <div>
        {{--Змінємо параметр id  на task--}}
        <a href="{{ route('tasks.show', ['task' => $task]) }}"
            @class([{{--'font-bold'--}} 'line-through'=> $task->completed])>{{ $task->title }}</a> {{--Використовуємо директиву class для використання стилізації--}}
    </div>
  @empty
    <div>There are no tasks!</div>
  @endforelse
    {{-- @endif --}}

    {{--Додаємо диретиву оператора if якщо завдання є, то відображаємо посилання links()--}}
    @if ($task->count())
        <nav class="mt-4">
            {{ $tasks->links() }}
        </nav>
    @endif
@endsection
