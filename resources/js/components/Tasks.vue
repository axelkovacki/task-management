<template>
    <div>
        <task-form v-if="showModal" :task="task"/>
        <div class="text-right">
            <button type="button" class=" btn btn-primary mb-2" id="show-modal" @click="createItem()">
                Add Task
            </button>
        </div>

        <div class="card">
            <table class="min-w-full divide-y divide-gray-200 border w-100">
                <thead class="card-header">
                    <tr>
                        <th class="px-6 py-3 bg-gray-50 text-center">
                            <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Name</span>
                        </th>
                        <th class="px-6 py-3 bg-gray-50 text-center">
                            <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Description</span>
                        </th>
                        <th class="px-6 py-3 bg-gray-50 text-center">
                            <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Status</span>
                        </th>
                        <th class="px-6 py-3 bg-gray-50 text-center">
                            <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Actions</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 divide-solid">
                    <task-item v-for="(task, index) in tasks" :key="index">
                    <p class="mb-0" slot="title">{{ task.title }}</p>
                    <p class="mb-0" slot="body">{{ task.body }}</p>
                    <p class="mb-0" slot="status">{{ task.status }}</p>
                    <a href="#" slot="play-button" @click.prevent="playItem(index)">Take on</a>
                    <a href="#" slot="edit-button" @click.prevent="editItem(index)">Edit</a>
                    <a href="#" slot="delete-button" @click.prevent="deleteItem(index)">Delete</a>
                    </task-item>
                </tbody>
            </table>

            <div v-show="noTasksYet" class="text-center p-5">
                <p class="mb-0 text-secondary">There is no tasks in your list yet.</p>
            </div>

            <div v-show="loading" class="text-center p-5">
                <div class="spinner-border text-primary" role="status">
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            tasks: [],
            task: null,
            loading: true,
            noTasksYet: false,
            showModal: false,
        }
    },
    methods: {
        createItem() {
            this.showModal = true;
            this.task = null
        },
        editItem(index) {
            this.showModal = true;
            this.task = this.tasks[index]
            this.task.index = index
        },
        playItem(index) {
            let task = this.tasks[index];

            if (task.status != 'To Do') {
                return this.$toast.warning("The task's status must be 'To Do' to taken on!");
            }

            task.status = 'In Progress'

            axios.put(`./tasks/${task.id}`,task)
                .then(_ => this.$toast.info("Changed the task's status."))
                .catch(err => {
                    console.log(err)
                    this.$toast.error("Oops! An error occurred, contact our support.");
                });
        },
        deleteItem(index) {
            let taskID = this.tasks[index].id;
            this.tasks.splice(index, 1);

            axios.delete(`./tasks/${taskID}`,{id:taskID})
                .then(_ => this.$toast.info("Task Deleted."))
                .catch(err => {
                    console.log(err)
                    this.$toast.error("Oops! An error occurred, contact our support.");
                });

            if (this.tasks.length < 1) this.noTasksYet = true;
        },
    },
    created() {
        axios.get('./tasks')
            .then(response => {
                this.loading = false;

                response.data.userTotalTasks < 1
                    ? this.noTasksYet = true
                    : this.tasks = response.data.tasks;
            });

        Event.$on('new-task', task => this.tasks.push(task));
        Event.$on('edit-task', task => this.tasks[task.index] = task);
        Event.$on('no-results', data => this.noTasksYet = data);
        Event.$on('close-modal', _ => this.showModal = false);
    }

}
</script>
