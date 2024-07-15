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

    <div class="" x-data="{ todos: [], userInput: '' }">
        

        <br>

        <!-- Form -->
        <form x-on:submit.prevent>
            <input x-model="userInput" type="text" placeholder="Enter todos item">
            <button type="button"
                @click="if(userInput.trim().length > 0) { todos.push({ name: userInput, completed: false }) }; userInput = '' ">Add</button>
        </form>

        <!-- Foreach Loop Todos -->
        <!-- <template x-for="(todo, index) in todos">
            <div>
                <input type="checkbox" x-model="todo.completed">
                <span x-text="todo.name" :class="{ 'completed': todo.completed }"></span>
                <button type="button"
                    @click="todos = todos.filter((currTodo, todoIndex) => { return index !== todoIndex })"
                    class="delete">x</button>
            </div>
        </template> -->

        <template x-for="todo in todos">
            <div>
                <input type="checkbox" x-model="todo.completed">
                <span x-text="todo.name" :class="{ 'completed': todo.completed }"></span>
                <button type="button"
                    @click="todos = todos.filter((currTodo, todoIndex) => { return index !== todoIndex })"
                    class="delete">x</button>
            </div>
        </template>

        <br>

        <!-- Button Clear All Todos -->
        <button type="button" @click="todos = []" x-show="todos.length">Clear All</button>

        <br><br>

        <!-- Counts Todos -->
        <div class="">
            <h1>
                <span x-text="todos.filter((todo) => todo.completed).length"></span> /
                <span x-text="todos.length"></span> Todos Completed
            </h1>
        </div>

    </div>

    <?php $this->endBody() ?>
</body>

</html>

<?php $this->endPage() ?>