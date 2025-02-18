<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TDL PaundraDewa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" 
          rel="stylesheet" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<style>
    body {
        background-color:rgb(42, 48, 54);
    }
    .todo-container {
        max-width: 700px;
        margin: auto;
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    }
    .doneText {
        text-decoration: line-through;
        color: red;
    }
    .todo-item {
        padding: 10px;
        border-radius: 8px;
        transition: all 0.3s ease-in-out;
    }
    .todo-item:hover {
        background:rgb(143, 255, 188);
    }
    .btn-custom {
        width: 100px;
    }
    
    .logout-btn {
        margin-top: 20px;
        background-color:rgb(46, 112, 255);
        color: white;
        border: none;
        padding: 12px 24px;
        font-size: 16px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background-color 0.3s ease, transform 0.3s ease;
        text-decoration: none; 
    }

    .logout-btn:hover {
        background-color:rgb(46, 112, 255);
        color: white;
        transform: scale(1.05);
    }

    .logout-btn i {
        margin-right: 8px;
    }
</style>

<body>
    <div id="app" class="container mt-5">
        <div class="todo-container">
            <h1 class="text-center text-primary">📌 TDL Paundra</h1>

            <div class="row g-2 mt-4">
                <div class="col-3">
                    <input type="time" class="form-control" v-model="startTime">
                </div>
                <div class="col-3">
                    <input type="time" class="form-control" v-model="endTime">
                </div>
                <div class="col-4">
                    <input type="text" class="form-control" placeholder="Tambahkan tugas..." v-model="activity">
                </div>
                <div class="col-2">
                    <button class="btn btn-primary form-control" @click="addTodo"><i class="fas fa-plus"></i> Tambah</button>
                </div>
            </div>

            <div class="mt-4">
                <div v-for="(item, index) in todoList" class="todo-item d-flex align-items-center justify-content-between border-bottom p-2">
                    <div>
                        <button class="btn btn-outline-danger btn-sm me-1" @click="deleteTodo(index)">
                            <i class="fas fa-trash"></i>
                        </button>
                        <button class="btn btn-success btn-sm me-1" @click="doneTodo(index)" :disabled="item.done">
                            <i class="fas fa-check"></i>
                        </button>
                        <button class="btn btn-warning btn-sm me-1" @click="editTodo(index)">
                            <i class="fas fa-edit"></i>
                        </button>
                        <span v-if="editIndex !== index" :class="{doneText: item.done}">{{ item.start }} - {{ item.end }} : {{ item.text }}</span>
                    </div>

                    <div v-if="editIndex === index" class="d-flex gap-2">
                        <input type="time" v-model="editStart" class="form-control form-control-sm">
                        <input type="time" v-model="editEnd" class="form-control form-control-sm">
                        <input type="text" v-model="editText" class="form-control form-control-sm">
                        <button class="btn btn-info btn-sm" @click="saveEdit(index)">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                    </div>
                </div>
            </div>

            <a href="logout.php" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </div>

    <script type="module">
        import { createApp } from 'https://unpkg.com/vue@3/dist/vue.esm-browser.js'

        createApp({
            data() {
                return {
                    startTime: '',
                    endTime: '',
                    activity: '',
                    todoList: [],  
                    editIndex: null,
                    editStart: '',
                    editEnd: '',
                    editText: ''
                }
            },
            methods: {
                addTodo() {
                    if (this.activity.trim() === '' || this.startTime === '' || this.endTime === '') {
                        alert('Mohon isi semua field!');
                        return;
                    }

                    let newItem = {
                        text: this.activity,
                        start: this.startTime,
                        end: this.endTime,
                        done: false
                    };

                    this.todoList.push(newItem);
                    this.saveTodos();
                    
                   
                    this.startTime = '';
                    this.endTime = '';
                    this.activity = '';
                },
                deleteTodo(index) {
                    this.todoList.splice(index, 1);
                    this.saveTodos();
                },
                doneTodo(index) {
                    this.todoList[index].done = true;
                    this.saveTodos();
                },
                editTodo(index) {
                    this.editIndex = index;
                    this.editStart = this.todoList[index].start;
                    this.editEnd = this.todoList[index].end;
                    this.editText = this.todoList[index].text;
                },
                saveEdit(index) {
                    if (this.editText.trim() === '' || this.editStart === '' || this.editEnd === '') {
                        alert('Mohon isi semua field!');
                        return;
                    }

                    this.todoList[index].start = this.editStart;
                    this.todoList[index].end = this.editEnd;
                    this.todoList[index].text = this.editText;
                    this.editIndex = null;
                    this.saveTodos();
                },
                saveTodos() {
                    localStorage.setItem('todos', JSON.stringify(this.todoList));
                },
            }
        }).mount('#app');
    </script>
</body>
</html>
