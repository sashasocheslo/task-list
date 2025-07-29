<?php

use App\Http\Requests\TaskRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use App\Models\Task;


// class Task
// {
//   public function __construct(
//     public int $id,
//     public string $title,
//     public string $description,
//     public ?string $long_description,
//     public bool $completed,
//     public string $created_at,
//     public string $updated_at
//   ) {
//   }
// }

// $tasks = [
//   new Task(
//     1,
//     'Buy groceries',
//     'Task 1 description',
//     'Task 1 long description',
//     false,
//     '2023-03-01 12:00:00',
//     '2023-03-01 12:00:00'
//   ),
//   new Task(
//     2,
//     'Sell old stuff',
//     'Task 2 description',
//     null,
//     false,
//     '2023-03-02 12:00:00',
//     '2023-03-02 12:00:00'
//   ),
//   new Task(
//     3,
//     'Learn programming',
//     'Task 3 description',
//     'Task 3 long description',
//     true,
//     '2023-03-03 12:00:00',
//     '2023-03-03 12:00:00'
//   ),
//   new Task(
//     4,
//     'Take dogs for a walk',
//     'Task 4 description',
//     null,
//     false,
//     '2023-03-04 12:00:00',
//     '2023-03-04 12:00:00'
//   ),
// ];


Route::get('/', function() {
    return redirect()->route('tasks.index');
});

Route::get('/tasks', function () {
    // Оскільки функція анонімна використовуємо ключове слово use з прааметром $tasks
    // Позбуваємося оператора use($task)
    return view('index', [
        // 'tasks' =>  $tasks // Додавання аргументу який є масивом, де ключ це ім'я змінної tasks та значення $tasks
        'tasks' => Task::latest()->paginate(10) // Заміняємо метод get() на метод розбиття на сторінки він внутрішньо викликає метод get(), він автоматично зчитує будь-які параметри запиту, які додаються до URL - адреси
        //Метод latest  конструктор запитів, метод get(останнє отримання комбінації) використовується для фактичного виконання запитів і отримання результатів
        //where('completed', true)->get()
        // Далі ми також використовуємо метод where()-це також один із методів контруктора запитів, вказуємо що заповнений стовпець(completed), має бути істинним, true
        // Коли ми використовуємо конструктор запитів на відміну від деяких простих методів  викликати get() обов'язково!!! Щоб фактично виконати ці запити
    ]);
})->name('tasks.index');

// Коли не потрібно використовувати метод get(), ми просто використовуємо перегляд
Route::view('/tasks/create', 'create') //Визначаємо url-адресу, яка буде створювати завдання
    ->name('task.create');
// Ще одна річ, і це може бути проблемою, з якою ми можемо часто стикатися, полягає в тому, що порядок значення маршрутів може бути не вірним, оскільки Route::get('/tasks/{id}' має так званний жадібний параметр{id}. Якщо ми намагаємося створити URL-адресу за допомогою маршруту create, то якщо цей маршрут буде стояти піся маршруту Route::get('/tasks/{id}', то маршрут create буде хешируватись цим маршрутом, то ми просто переміщаємо цей маршрут вгору

// Додаємо метод для оновлення даних у базі даних
// Виконуємо при'язку до машруту змінюємо аргумент id на task, також вводимо клас Task в функцію, яка є моделлю керування
Route::get('/tasks/{task}/edit', function(Task $task)  {
    // $task = collect($tasks)->firstWhere('id', $id); // функція collect перетворю цей масив на об'єкт колекції, який дозволяє викликати різні завдання

    // if (!$task){
    //     abort(Response::HTTP_NOT_FOUND); // функція abort переривання яка просто зупинить цей запит. Response - клас який має деякі відповіді, в даному випадку http не знайдено.
    // }
     return view('edit',
        ['task' => $task// Task::findOrFail($id)
    ]); // Завантаження даних з бази даних якщо ці дані існують використовуєть модель Task метод find, якщо ні то не існуть метод fail
})->name('tasks.edit');

// Виконуємо при'язку до машруту змінюємо аргумент id на task, також вводимо клас Task в функцію, яка є моделлю
Route::get('/tasks/{task}', function(Task $task)  {
    // $task = collect($tasks)->firstWhere('id', $id); // функція collect перетворю цей масив на об'єкт колекції, який дозволяє викликати різні завдання

    // if (!$task){
    //     abort(Response::HTTP_NOT_FOUND); // функція abort переривання яка просто зупинить цей запит. Response - клас який має деякі відповіді, в даному випадку http не знайдено.
    // }
     return view('show',
        ['task' => $task // Task::findOrFail($id)
    ]); // Завантаження даних з бази даних якщо ці дані існують використовуєть модель Task метод find, якщо ні то не існуть метод fail
})->name('tasks.show');

Route::post('/tasks', function (TaskRequest $request) {
    // Використовуємо Загальний клас запиту
    // dd(/$request->all()); // Читаємо всі поля даних, надіслані до форми
    // Створюємо нову модель завдань Task використовуємо статичний метод create() - який означає створення атрибутів моделі та передавання результату перевірки запиту;
    $task = Task::create($request->validated());
    // Перенаправляємося на  сторінку до доданих завдань
    return redirect()->route('tasks.show', ['task' =>$task->id])
    // Додаємо миттєве повідомлення викликаючи метод with()
    ->with('success', 'Task created successfully!'); //Створюємо змінну сеансу succes та назву повідомлення Task created successfully!
})->name('tasks.store');

// Використовуємо метод put який використовується для оновлення та ідентифікатор id
// Виконуємо при'язку до машруту змінюємо аргумент id на task, також вводимо клас Task в функцію,яка є моделлю  та використовуємо тип запиту TaskRequest
Route::put('/tasks/{task}', function (Task $task, TaskRequest $request) {
    // dd($request->all()); // Читаємо всі поля даних, надіслані до форми
    // Оновлюємо  модель завдань Task використовуємо статичний метод updated() - який змінює деякі атрибути та передає результат перевірки запиту;
    $task->update($request->validated());
    // Перенаправляємося на іншу сторінку до доданих завдань
    return redirect()->route('tasks.show', ['task' =>$task->id])
    // Додаємо миттєве повідомлення викликаючи метод with()
    ->with('success', 'Task updated successfully!'); //Створюємо змінну сеансу updated та назву повідомлення Task updated successfully!
})->name('tasks.update');

// Додаємо маршрут для видалення даних з бази даних, також використовуємо прив'язку моделі з маршруту Task
Route::delete('/tasks/{task}', function(Task $task) {
    $task->delete(); // Використовуємо метод видалення delete() який видаляє дані з бази даних;
    // Перенаправляємося на  сторінку до доданих завдань
    return redirect()->route('tasks.index')
    // Додаємо миттєве повідомлення викликаючи метод with()
    ->with('success','Task deleted successfully!');//Створюємо змінну сеансу succes та назву повідомлення Task created successfully!
})->name('tasks.destroy');

// Створюємо маршрут для переходу на сторінку завершення завдання
Route::put('/tasks/{task}/toggle-complete', function(Task $task){
    $task->toggleCopmlete();

    return redirect()->back()->with('success', 'Task completed successfully!');// Додаємо миттєве повідомлення викликаючи метод with()
})->name('tasks.toggle-complete');


// Route::get('/xxx', function () {
//     return 'Hello';
// })->name('hello');

// Route::get('/hallo', function(){
//     // return redirect('/hello');
//     return redirect()->route('hello');
// });


// Route::get('greet/{name}', function ($name) { // Динамічний параметр
//     return 'Hello ' . $name . '!';
// });

// Запасний маршрут
Route::fallback(function () {
    return 'Still got somewhere!';
});
