<template>
    <main id="app" class="main">
        <!-- from -->
        <form class="form">
            <div class="inputArea">
                <input
                    type="text"
                    class="inputText"
                    value=""
                    ref="text"
                    @keypress.enter.prevent="addTask"
                    placeholder="ここにTODO内容を書く"
                />
                <span class="error" v-if="errors">入力が空です</span>
            </div>
            <button class="btn" @click.prevent="addTask">TODOを追加</button>
        </form>

        <!-- search box -->
        <div class="searchBox">
            <i class="fa fa-search searchBox__icon" aria-hidden="true"></i>
            <input
                type="text"
                class="searchBox__input"
                value=""
                :value="searchText"
                @input="searchText = $event.target.value"
                placeholder="ここに絞り込みたいキーワードを入力する"
            />
        </div>

        <!-- list -->
        <ul class="list">
            <li
                v-for="todo in filteredTodos"
                class="list__item"
                :class="{ 'list__item--done': todo.isDone }"
                :key="todo.id"
            >
                <i
                    class="fa"
                    :class="{
                        'fa-square-o': !todo.isDone,
                        'fa-check-square': todo.isDone,
                    }"
                    @click="toggleTask(todo)"
                    aria-hidden="true"
                ></i>

                <span
                    v-if="!todo.editMode"
                    class="js-todo_list-text"
                    @click="editTask(todo)"
                    >{{ todo.taskName }}</span
                >
                <input
                    v-if="todo.editMode"
                    type="text"
                    class="editText"
                    v-model="todo.taskName"
                    @keyup.shift.enter="closeEditTask(todo)"
                />

                <i
                    class="fa fa-trash icon-trash"
                    @click="removeTask(todo)"
                    aria-hidden="true"
                ></i>
            </li>
        </ul>
    </main>
</template>

<script>
    export default {
        data: function () {
            return {
                todos: [
                    {
                        id: 1,
                        taskName: "野菜を片付ける",
                        isDone: false,
                        editMode: false,
                    },
                    {
                        id: 2,
                        taskName: "買い物に行く",
                        isDone: false,
                        editMode: false,
                    },
                ],
                errors: false,
                searchText: "",
            };
        },
        methods: {
            addTask() {
                let text = this.$refs.text;
                if (!text.value) {
                    this.errors = true;
                    return;
                }
                this.todos.push({
                    id: Math.random().toString(36).slice(-16),
                    taskName: text.value,
                    isDone: false,
                    editMode: false,
                });

                this.errors = false;
                text.value = "";
            },
            toggleTask(todo) {
                todo.isDone = !todo.isDone;
            },
            editTask(todo) {
                todo.editMode = true;
            },
            closeEditTask(todo) {
                todo.editMode = false;
            },
            removeTask(todo) {
                let index = this.todos.indexOf(todo);
                this.todos.splice(index, 1);
            },
        },
        computed: {
            filteredTodos() {
                const regexp = new RegExp("^" + this.searchText, "i");
                return this.todos.filter((elm) => {
                    return elm.taskName.match(regexp);
                });
            },
        },
    };
</script>

<style scoped>
    body {
        background: #f6f5f4;
        color: #333;
    }
    .main {
        margin: 100px auto;
        width: 400px;
    }
    .form {
        margin-bottom: 30px;
        text-align: right;
    }
    .inputArea {
        margin-bottom: 15px;
    }
    .inputText {
        box-sizing: border-box;
        margin-bottom: 15px;
        padding: 5px;
        width: 100%;
        height: 40px;
        border: 1px solid #e8e8e8;
        font-size: 16px;
    }
    .btn {
        margin: 0;
        padding: 5px 30px;
        border: none;
        background: #000;
        color: #fff;
        text-align: right;
        font-size: 16px;
    }
    .btn:hover {
        cursor: pointer;
    }
    .error {
        color: #e9573e;
    }
    .searchBox {
        display: flex;
        align-items: center;
        box-sizing: border-box;
        margin-bottom: 15px;
        padding: 0 10px;
        width: 100%;
        height: 40px;
        border: 1px solid #e8e8e8;
        border-radius: 20px;
        background: #fff;
    }
    .searchBox__icon {
        margin-right: 5px;
        width: 16px;
        font-size: 18px;
    }
    .searchBox__input {
        box-sizing: border-box;
        padding: 5px 10px;
        width: calc(100% - 30px);
        height: 100%;
        border: none;
        font-size: 16px;
    }
    .list {
        margin: 0;
        padding: 0;
        list-style: none;
    }
    .list__item {
        overflow: hidden;
        padding: 15px 15px;
        border-bottom: 1px solid #e8e8e8;
        background: #fff;
        transition: 0.5s transform;
    }
    .list__item:hover {
        transition: 0.5s transform;
        transform: scale(1.02);
    }
    .list__item--done {
        background: #d8d8d8;
        color: #888;
    }
    .icon-square,
    .icon-check,
    .icon-sort,
    .icon-trash {
        cursor: pointer;
        transition: 0.5s transform;
    }
    .icon-square:hover,
    .icon-check:hover,
    .icon-sort:hover,
    .icon-trash:hover {
        transition: 0.5s transform;
        transform: scale(1.2);
    }
    .icon-trash {
        position: relative;
        top: 4px;
        float: right;
        color: #e9573e;
    }
    .icon-square,
    .icon-check {
        margin-right: 15px;
    }
    .editText {
        padding: 5px 10px;
        width: 80%;
        height: 100%;
        border: none;
        font-size: 16px;
    }
</style>
