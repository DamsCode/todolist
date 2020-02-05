<template>
  <b-container>
      <b-row>
          <b-button variant="primary" @click="addList">add list of task</b-button>
      </b-row>
      <b-row v-if="!lists.length">
          <b-alert variant="light" show>You don't have a list</b-alert>
      </b-row>
      <b-list-group v-else flush>
          <b-list-group-item>
              <b-card :key="list.id" v-for="list in lists">
                  <b-card-header>
                      <b-row>
                          <b-col>
                              <b-card-text  class="text-center" @click="list.isEdit = true"  v-if="!list.isEdit">{{list.title}}</b-card-text>
                              <b-input v-else type="text" :autofocus="true" @keyup.enter="list.isEdit = false" @blur="list.isEdit = false" v-model="list.title"></b-input>
                          </b-col>
                              <b-button variant="outline-danger" @click="delList(list)" size="sm">
                                  <b-icon icon="trash-fill" aria-hidden="true"></b-icon>
                              </b-button>
                      </b-row>
                  </b-card-header>
                  <b-card-body>
                      <b-list-group flush :key="task.id" v-for="task in list.tasks">
                          <TaskComponent :del="delTask" :task="task"></TaskComponent>
                      </b-list-group>
                      <b-row class="mt-3">
                          <b-button variant="outline-primary" @click="addTask(list.tasks)" size="sm">Add task</b-button>
                      </b-row>
                  </b-card-body>
              </b-card>
          </b-list-group-item>
      </b-list-group>
  </b-container>
</template>

<script>
export default {
  data() {
    return {
      lists: []
    };
  },
    async beforeMount() {
        try {
            const {data} = await this.$http.get(`lists?projet_id=${this.$route.params.id}`,{
                headers: { 'Authorization': 'Bearer '+localStorage.getItem('api_token')},
            });
            this.lists = data.data;
        }catch (e) {
            if (e.response.status === 401) {

            }
        }
    },
  methods: {
      focusMyElement(e) {
          this.$refs.focusThis.focus()
      },
      addList(){
          const newList = {
              id: this.lists.length +1,
              title:"New title",
              tasks:[{
                  id: 0,
                  title:"New task",
                  isDone:false,
                  isEdit:false
              }],
              isEdit:false
          };
          this.lists.push(newList);
      },
      editList(list){
        list.isEdit= true;
      },
      delList(list){
          this.lists = this.lists.filter(e => e !== list);
      },
      addTask(tasks){
          tasks.push({
              id: tasks.length+1,
              title:"New task",
              isDone:false,
              isEdit:false
          })
      },
      delTask(task){
          console.log(this.lists.filter(e => e.tasks.filter(t => t !== task)))
          // this.lists. = this.lists.filter(e => e !== list);
      },
  }
};
</script>
