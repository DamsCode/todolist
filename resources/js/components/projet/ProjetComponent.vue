<template>
    <div>
        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col">Title</th>
                <th scope="col">Description</th>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            <tr  v-for="projet in projets" :key="projet.id">
                <td >{{projet.title}}</td>
                <td>{{projet.description}}</td>
                <td>
                    <b-button variant="danger" v-b-modal.modal-projet>Edit</b-button>
                </td>
                <td>
                    <b-button variant="primary">Go to the lists</b-button>
                </td>
            </tr>
            </tbody>
        </table>
        <b-modal
            id="modal-projet"
            ref="modal"
            title="Edit Form"
            @show="resetModal"
            @hidden="resetModal"
            @ok="handleOk"
        >
            <form ref="form" @submit.stop.prevent="handleSubmit">
                <b-form-group
                    label="title"
                    label-for="title-input"
                    invalid-feedback="title is required"
                >
                    <b-form-input
                        id="title-input"
                        v-model="title"
                        required
                    />
                </b-form-group>
            </form>
        </b-modal>
    </div>
</template>
<script>
export default {
    data(){
        return{
            projets:[],
            errors:[],
            title:null,
            description:null
        }
    },
    async beforeMount() {
        try {
            const {data} = await this.$http.get('projets',{
                headers: { 'Authorization': 'Bearer '+localStorage.getItem('api_token')},
            });
            this.projets = data.data;
        }catch (e) {
            if (e.response.status === 401) {

            }
        }
    },
    methods:{
        actionForm(e){
            e.preventDefault();
        },
        checkFormValidity() {
            const valid = this.$refs.form.checkValidity();
            this.errors = [valid];
            return valid
        },
        resetModal() {
            this.title = '';
            this.errors = []
        },
        handleOk(bvModalEvt) {
            bvModalEvt.preventDefault();
            this.handleSubmit()
        },
        handleSubmit() {
            // if (!this.checkFormValidity()) {
            //     return
            // }
            //api call
            this.$nextTick(() => {
                this.$bvModal.hide('modal-prevent-closing')
            })
        }
    }
}
</script>
