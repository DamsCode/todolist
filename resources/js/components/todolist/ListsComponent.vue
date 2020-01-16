<template>
  <b-container>
      <b-alert show="true" variant="success">Bravoooo !!!!</b-alert>
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
        console.log(this.$route.params.id);
        // try {
        //     const {data} = await this.$http.get('projets',{
        //         headers: { 'Authorization': 'Bearer '+localStorage.getItem('api_token')},
        //     });
        //     this.projets = data.data;
        // }catch (e) {
        //     if (e.response.status === 401) {
        //
        //     }
        // }
    },
  methods: {
  }
};
</script>
