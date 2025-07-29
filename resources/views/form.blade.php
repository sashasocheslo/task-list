@extends('layouts.app')

@section('title', isset($task) ? 'Edit Task' : 'Add Taks') {{--Перевіряємо чи поставленне завдання--}}

{{-- Визначаємо спеціальний розділ і назвемо його стилями --}}
{{-- @section('styles')
<style>
    /* Створюємо клас до якого додаємо колір та розмір шрифту */
    .error-message {
        color: red;
        font-size: 0.8rem;
    }
</style>
@endsection --}}

@section('content')
    <form method="POST" action="{{ isset($task) ? route('tasks.update', ['task' => $task]) : route('tasks.store')}}">
        {{--Перевіряємо чи була передана зміна завдання чи ні--}}
       @csrf
       {{-- Використовуємо директиву @isset --}}
       @isset($task)
        {{--Викликаємо спуфінг метод--}}
        @method('PUT')
       @endisset
       <div class="mb-4">
           <label for="title">
                Title
           </label>
           <input type="text" name="title" id="title"
           {{--Додаємо стилі--}}
                @class(['border-red-500' => $errors->has('title')])
                {{-- class = "@error('title')  border-red-500 @enderror" --}}
                value="{{ $task->title ?? {{-- В іншому випадку використовуємо знаки питання, це означає що це значання не є нульовим--}}  old('title')}}"/> {{--Додаємо атрибут value і викликаємо помічник old вказуємо назву поля title--}}
            {{-- Використовуємо спеціальну директиву про помилку --}}
           @error('title')
            {{-- До кожного параграфу додаємо класс error-message --}}
                <p class="error">{{$message}}</p>
            @enderror
       </div>

       <div class="mb-4">
            <label for="description">
                Description
            </label>
            <textarea name="description" id="description"
             {{--Додаємо стилі--}}
                @class(['border-red-500' => $errors->has('description')])
                rows="5">{{ $task->description ??  old('description')}} {{-- Викликаємо помічник old вказуємо опис поля description--}}
            </textarea>
                {{-- Використовуємо спеціальну директиву про помилку --}}
            @error('description')
                {{-- До кожного параграфу додаємо класс error-message --}}
                <p class="error">{{$message}}</p>
            @enderror
       </div>

       <div class="mb-4">
            <label for="long_description">
                Long Description
            </label>
            <textarea name="long_description" id="long_description"
             {{--Додаємо стилі--}}
                @class(['border-red-500' => $errors->has('long_description')])
                rows="10">{{$task->long_description ?? old('long_description')}} {{-- Викликаємо помічник old вказуємо довгий опис поля long_description--}}
            </textarea>
            {{-- Використовуємо спеціальну директиву про помилку --}}
            @error('long_description')
            {{-- До кожного параграфу додаємо класс error-message --}}
                <p class="error">{{$message}}</p>
            @enderror
        </div>

        {{--Додаємо стилі--}}
        <div class="flex gap-2 items-center">
            <button type="submit" class="btn">
            @isset($task)
                Update Task
                @else
                Add Task
            @endisset
            </button> {{--Використовуємо директиву @isset() для кнопки--}}
            <a href="{{route('tasks.index')}}" class="link">Cancel</a>
        </div>
    </form>
@endsection
