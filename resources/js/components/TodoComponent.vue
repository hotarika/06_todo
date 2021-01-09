<template>
    <main id="app" class="main">
        <!-- from -->
        <form class="form">
            <div class="inputArea">
                <input
                    type="text"
                    class="inputText"
                    value=""
                    v-model="content"
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
                v-model="searchText"
                placeholder="ここに絞り込みたいキーワードを入力する"
            />
        </div>

        <!-- list -->
        <ul class="list">
            <li
                v-for="todo in filteredTodos"
                class="list__item"
                :class="{ 'list__item--done': todo.is_done }"
                :key="todo.id"
            >
                <i
                    class="fa"
                    :class="{
                        'fa-square-o': !todo.is_done,
                        'fa-check-square': todo.is_done
                    }"
                    @click="toggleTask(todo)"
                    aria-hidden="true"
                ></i>

                <span
                    v-if="!todo.edit_mode"
                    class="js-todo_list-text"
                    @click="editTask(todo)"
                    >{{ todo.content }}</span
                >
                <input
                    v-if="todo.edit_mode"
                    type="text"
                    class="editText"
                    v-model="todo.content"
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
    props: ["tasks", "user", "path"],
    data: function() {
        return {
            // todos: [
            //     {
            //         id: 1,
            //         content: "野菜を片付ける",
            //         is_done: false,
            //         edit_mode: false
            //     },
            //     {
            //         id: 2,
            //         content: "買い物に行く",
            //         is_done: false,
            //         edit_mode: false
            //     }
            // ],
            content: "",
            searchText: "",
            errors: false,
            todos: this.tasks
        };
    },
    methods: {
        addTask() {
            // エラー表示
            let text = this.content;
            if (!text) {
                this.errors = true;
                return;
            }

            let that = this;
            axios
                .post(this.path + "json", {
                    content: that.content,
                    user_id: 1
                })
                .then(res => {
                    // タスクの追加
                    that.todos.push({
                        content: text,
                        user_id: that.user.id
                    });
                })
                .catch(err => {
                    console.log(err);
                });

            // データを初期状態に戻す
            this.errors = false;
            this.content = "";
        },
        toggleTask(todo) {
            // is_done toggle
            todo.is_done = !todo.is_done;

            axios
                .post(this.path + "json/done_" + todo.id, {
                    is_done: todo.is_done
                })
                .then(res => {
                    console.log("toggle ok");
                })
                .catch(err => {
                    console.log(err);
                });
        },
        editTask(todo) {
            todo.edit_mode = true;
        },
        closeEditTask(todo) {
            todo.edit_mode = false;

            axios
                .post(this.path + "json/cont_" + todo.id, {
                    content: todo.content
                })
                .then(res => {
                    console.log("content ok");
                })
                .catch(err => {
                    console.log(err);
                });
        },
        removeTask(todo) {
            let that = this;
            axios //delete
                .delete(this.path + "json/" + todo.id)
                .then(res => {
                    let index = that.todos.indexOf(todo);
                    that.todos.splice(index, 1);
                })
                .catch(err => {
                    console.log(err);
                });
        }
    },
    computed: {
        filteredTodos() {
            // const regexp = new RegExp("^" + this.searchText, "i");
            const regexp = new RegExp(this.searchText, "i");
            return this.todos.filter(elm => {
                return elm.content.match(regexp);
            });
        }
    }
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
    padding: 5px 15px;
    width: 100%;
    height: 40px;
    border: 1px solid #e8e8e8;
    font-size: 14px;
}
.btn {
    margin: 0;
    padding: 5px 20px;
    border: none;
    background: rgb(0, 0, 0);
    color: #fff;
    text-align: right;
    font-size: 14px;
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
    font-size: 14px;
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
    font-size: 14px;
}
</style>
