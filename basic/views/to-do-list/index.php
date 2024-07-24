<?php
/** @var yii\web\View $this */
/** @var string $content */
use app\assets\AppAsset;

AppAsset::register($this);
?>

<?php $this->beginPage() ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo 'Nhat Tai - ToDoList Application' ?></title>
    <style>
        .delete:hover {
            cursor: pointer;
        }

        .completed {
            text-decoration: line-through;
        }
    </style>
    <?php $this->head() ?>
</head>

<body>
    <?php $this->beginBody() ?>

    <div class="" x-data="{ todos: [], userInput: '', message: 'more to go!' }">

        <!-- Counts Todos -->
        <div class="">
            <h1 class="text-lg font-bold">
                To Dos: <span x-text="todos.length"></span> |
                Completed: <span x-text="todos.filter((todo) => todo.completed).length"></span>
            </h1>
        </div>

        <br>

        <!-- Counts text Todos -->
        <div>
            <h1 class="text-lg font-bold">
                <span x-text="todos.length"></span> <span x-text="message"></span>
            </h1>
        </div>

        <br>

        <!-- Foreach Loop Todos -->
        <template x-for="(todo, index) in todos">
            <div class="bg-red-500 text-white p-2 mb-4 rounded-md w-1/2 flex items-enter justify-between">
                <div>
                    <input type="checkbox" x-model="todo.completed">
                    <span x-text="todo.name" :class="{ 'completed': todo.completed }"></span>
                </div>
                <button type="button" @click="todos = todos.filter((currTodo, todoIndex) => todoIndex !== index)"
                    class="delete text-white">Remove</button>
            </div>
        </template>

        <br>

        <!-- Button Clear All Todos -->
        <button type="button" @click="todos = []" x-show="todos.length">Clear All</button>

        <br><br>

        <!-- Form -->
        <form x-on:submit.prevent>
            <input x-model="userInput" type="text" placeholder="Enter todos item">
            <button type="button"
                @click="if(userInput.trim().length > 0) { todos.push({ name: userInput, completed: false }) }; userInput = '' ">Add</button>
        </form>

    </div>

    <?php $this->endBody() ?>
</body>

</html>

<?php $this->endPage() ?>