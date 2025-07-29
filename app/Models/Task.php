<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    // Створюємо захищене поле $fillable для того, щоб увімкнути або змінити атрибути моделі завдання
    protected $fillable = ['title', 'description', 'long_description']; // Встановлюємо назви стовпців які можна заповнювати
    // Можемо створюємо захищене поле $guarded для того, щоб щоб увімкнути або змінити атрибути моделі завдання, які охороняються
    // protected $guarded = ['secret'];

    // Додаємо метод для перемекання
    public function toggleCopmlete() {
        $this->completed = !$this->completed;
        $this->save();
    }
}
