<template>
   <transition name="modal">
      <div class="modal-mask">
        <div class="modal-wrapper">
          <div class="modal-dialog" role="document">
            <form class="modal-content" @submit.prevent="sendTask()" method="POST">
              <div class="modal-header">
                <h5 class="modal-title">{{ task ? 'Update a Task' : 'Create a Task' }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true" @click="closeModal()">&times;</span>
                </button>
              </div>
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="taskBody">Title</label>
                        <input autocomplete="off" type="text" v-model="taskTitle" @keyup="disabledBtn()" id="taskBody" class="form-control" placeholder="e.g. Making a coffe" required>
                        <label class="mt-4" for="taskTitle">Description</label>
                        <textarea autocomplete="off" v-model="taskBody" @keyup="disabledBtn()" id="taskTitle" class="form-control" placeholder="Write something.." cols="30" rows="5"></textarea>
                        <label class="mt-4" for="taskObservation">Observation</label>
                        <textarea autocomplete="off" v-model="taskObservation" @keyup="disabledBtn()" id="taskObservation" class="form-control" placeholder="Write additional informationg.." cols="30" rows="2"></textarea>
                        <label class="mt-4" for="taskStatus">Status</label>
                        <select class="form-control" id="taskStatus" v-model="taskStatus" required>
                            <option disabled value="">Please select one Status</option>
                            <option>To Do</option>
                            <option>In Progress</option>
                            <option>Completed</option>
                        </select>
                    </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" @click="closeModal()">Close</button>
                <button :disabled="isDisabled" type="submit" class="btn btn-primary">
                  <span v-show="sending" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                  <span v-show="!sending">Save Task</span>
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </transition>
</template>

<script>
    export default {
        props: ['close', 'task'],
        data() {
            return{
                taskBody : '',
                taskTitle : '',
                taskObservation : '',
                taskStatus : '',
                isDisabled : true,
                sending : false,
            }
        },
        mounted() {
            if (this.task) {
                this.taskBody = this.task.body;
                this.taskTitle = this.task.title;
                this.taskObservation = this.task.observation;
                this.taskStatus = this.task.status;
                this.isDisabled = false;
            }
        },
        methods: {
            closeModal() {
                Event.$emit('close-modal');
            },
            disabledBtn() {
                this.isDisabled = $.trim(this.taskTitle).length == 0 && $.trim(this.taskBody).length == 0;
            },
            lockForm() {
                this.isDisabled = true;
                this.sending = true;
            },
            unlockForm() {
                this.isDisabled = false;
                this.sending = false;
            },
            cleanForm() {
                this.taskTitle = "";
                this.taskBody = "";
                this.taskObservation = "";
                this.taskStatus = null
            },
            sendTask() {
                if (this.task && this.task.id) {
                    return this.updateTask()
                }

                this.createTask()
            },
            createTask() {
                this.lockForm()

                const payload = {
                    title: this.taskTitle,
                    body: this.taskBody,
                    observation: this.taskObservation,
                    status: this.taskStatus,
                }

                axios.post('./tasks', payload)
                    .then(response => {
                        Event.$emit('new-task', response.data);
                        Event.$emit('no-results', false);
                        this.closeModal()
                        this.cleanForm()
                        this.$toast.success("Saved with success!");
                    })
                    .catch(err => {
                        console.log(err)
                        this.$toast.error("Oops! An error occurred, contact our support.");
                    })
                    .finally(() => this.unlockForm());
            },
            updateTask() {
                this.lockForm()

                this.sending = true;
                this.isDisabled = true;
                this.sending = true;

                const payload = {
                    title: this.taskTitle,
                    body: this.taskBody,
                    observation: this.taskObservation,
                    status: this.taskStatus,
                }

                axios.put(`./tasks/${this.task.id}`, payload)
                    .then(response => {
                        Event.$emit('edit-task', {...this.task, ...payload});
                        Event.$emit('no-results', false);
                        this.closeModal()
                        this.$toast.success("Saved with success!");
                    })
                    .catch(err => {
                        console.log(err)
                        this.$toast.error("Oops! An error occurred, contact our support.");
                        vm.sending = false;
                    })
                    .finally(() => this.unlockForm());
            },
        }
    }
</script>

<style>
.modal-mask {
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, .5);
  display: table;
  transition: opacity .3s ease;
}

.modal-wrapper {
  display: table-cell;
  vertical-align: middle;
}
</style>