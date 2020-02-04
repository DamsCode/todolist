<template>
  <b-container>
      <b-row>
          <b-button variant="primary"@click="addList">add list of task</b-button>
      </b-row>
      <b-list-group flush>
          <b-list-group-item>
              <b-card :key="list.id" v-for="list in lists">
                  <b-card-header>
                      <b-row>
                              <b-col> <b-card-text align="center">{{list.title}}</b-card-text></b-col>
                              <b-button variant="primary">add task</b-button>
                      </b-row>
                  </b-card-header>
                  <b-card-body>
        <!--Faire une liste !!-->
                      <b-list-group flush>
                          <b-list-group-item>
                              <b-row>
                                  <b-col>
                                    <b-card-text>Ma tache</b-card-text>
                                  </b-col>
                                  <b-checkbox></b-checkbox>
                                  <b-button variant="light"><b-icon icon="x" font-scale="1" variant="danger"></b-icon></b-button>
                              </b-row>
                          </b-list-group-item>
                      </b-list-group>
        <!--              <b-form>-->
        <!--                  <b-row>-->
        <!--                          <b-col> <b-card-text>test</b-card-text></b-col>-->
        <!--                      <b-form-checkbox></b-form-checkbox>-->
        <!--                          <b-button variant="light" ><b-icon icon="x" font-scale="1" variant="danger"></b-icon></b-button>-->
        <!--                  </b-row>-->
        <!--              </b-form>-->
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
      addList(){
          const newList = {
              id:0,
              title:"New title",
              dscription:"New description"
          };
          this.lists.push(newList);
      }
  }
};
</script>
