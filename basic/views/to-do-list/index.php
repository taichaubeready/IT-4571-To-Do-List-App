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
    <?php $this->head() ?>
</head>

<body>
    <?php $this->beginBody() ?>

    <!-- To Do List Application -->
    <div class="mb-5 box" x-data="{ 
    todos: $persist([]).as('todos_array'),
     userInput: '',
      message: '',
      state: $persist('all').as('state'),
      removeTodo(id) {
        this.todos = this.todos.filter((currTodo, todoIndex) => todoIndex !== id)
      },
      get todosSortedByCompleted() {
        return this.todos.sort((a,b) => b.completed - a.completed)
      },
       }">

        <!-- Counts Todos -->
        <div class="mb-5 flex items-center justify-between">
            <p class="text-lg font-bold">
                To Dos: <span x-text="todos.length"></span> |
                Completed: <span x-text="todos.filter((todo) => todo.completed).length"></span>
            </p>
            <div>
                <select x-model="state">
                    <option value="all">All</option>
                    <option value="no">Item Not Completed</option>
                    <option value="yes">Item Completed</option>
                </select>
            </div>
        </div>

        <!-- Message Todos -->
        <div class="mb-5" x-show="todos.length > todos.filter((todo) => todo.completed).length">
            <p class="text-lg font-bold">
                <span x-text="todos.length - todos.filter((todo) => todo.completed).length"></span> <span
                    x-text="message = 'more to go!'"></span>
            </p>
        </div>
        <div class="mb-5" x-show="
            todos.length === todos.filter((todo) => todo.completed).length
        ">
            <p class="text-lg font-bold">
                <span x-text="message = 'Congrats you finished your list!'"></span>
            </p>
        </div>

        <!-- Foreach Loop Todos -->
        <div class="mb-5" x-show="state">
            <!-- State False -> Item Not Completed -->
                <template x-for="todo in todos" :key="todo.id">
                    <div class="bg-red-500 text-white p-2 mb-4 rounded-md w-[100%] flex items-enter justify-between">
                        <div class="w-[100%]">
                            <input type="checkbox" x-model="todos[todo.id].completed" class="input">
                            <span x-text="todo.name" :class="{ 'completed': todos[todo.id].completed }"
                                class="text-[40px] font-bold"></span>
                        </div>
                        <button type="button" @click="removeTodo(todo.id)" class="delete btn">Remove</button>
                    </div>
                </template>
        </div>

        <!-- Button Clear All Todos -->
        <div class="mb-5">
            <button type="button" @click="todos = [], message = '', userInput = ''" x-show="todos.length"
                class="btn">Clear All</button>
        </div>

        <!-- Form -->
        <div class="mb-5">
            <form x-on:submit.prevent>
                <input x-model="userInput" type="text" placeholder="Enter todos item" class="input">
                <button type="button" class="btn" @click="
                if(userInput.trim().length > 0 && todos.length == 0) { 
                 todos.push({ id: 0, name: userInput, completed: false })
                 } else if(userInput.trim().length > 0){
                  todos.push({ id: todos.length, name: userInput, completed: false })
                  }; userInput = '' ">Add</button>
            </form>
        </div>

    </div>

    <?php $this->endBody() ?>
</body>

</html>

<?php $this->endPage() ?>