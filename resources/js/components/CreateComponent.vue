<template>
  <div>
    <h1>Create a new list</h1>
    <form @submit.prevent="addList">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>List title:</label>
            <input type="text" class="form-control" v-model="list.title" />
          </div>
        </div>
      </div>
      <br />
      <div class="form-group">
        <button class="btn btn-primary">Create</button>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      list: {}
    };
  },
  methods: {
    addList() {
        this.list.users_id = 1;

      axios.post("/lists", this.list).then(response => {
        this.$router.push({ name: "lists" });
      });
    }
  }
};
</script>
