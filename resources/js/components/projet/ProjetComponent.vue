<template>
       <b-container fluid="sm">
               <b-alert v-if="!isError" variant="success" v-model="showMsg" dismissible>
                   Your projet has been deleted.
               </b-alert>
                <b-alert v-else variant="danger" v-model="showMsg" dismissible>
                    Your projet has been deleted.
                </b-alert>
           <b-row>
               <b-button v-on:click="onClick(null)" variant="outline-primary" v-b-modal.modal-projet>Add Projet</b-button>
           </b-row>

           <b-row>
        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col">Title</th>
                <th scope="col">Description</th>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            <tr  v-for="projet in projets" :key="projet.id">
                <td >{{projet.title}}</td>
                <td>{{projet.description}}</td>
                <td>
                    <b-button v-on:click="onClick(projet)" variant="outline-info" v-b-modal.modal-projet>Edit</b-button>
                </td>
                <td>
                    <b-button v-on:click="deleteDialog(projet)" variant="outline-danger">Delete</b-button>
                </td>
                <td>
                    <b-button variant="outline-secondary" :to="{ name: 'lists', params: { id: projet.id }}" >Go to the todo lists</b-button>
                </td>
            </tr>
            </tbody>
        </table>

   <!--MODAL-->
        <validation-observer ref="observer" v-slot="{ handleSubmit }">
        <b-modal
            id="modal-projet"
            ref="modal"
            title="Form Projet"
            @hidden="resetModal"
            @ok="handleOk"
        >

            <form ref="form" @submit.stop.prevent="handleSubmit(onSubmit)">
                <validation-provider name="title" rules="required|alpha_spaces" v-slot="validationContext">
                <b-form-group
                    label="title"
                    label-for="title-input"
                >
                    <b-form-input
                        id="title-input"
                        v-model="form.title"
                        :state="getValidationState(validationContext)"
                    />
                    <b-form-invalid-feedback
                        id="title-input-live-feedback"
                    >{{validationContext.errors[0]}}</b-form-invalid-feedback>
                </b-form-group>
                </validation-provider>
                <validation-provider name="description" rules="required|alpha_spaces" v-slot="validationContext">

                <b-form-group
                        label="description"
                        label-for="description-input"
                    >
                    <b-form-input
                        id="description-input"
                        v-model="form.description"
                        :state="getValidationState(validationContext)"
                    />
                    <b-form-invalid-feedback
                        id="description-input-live-feedback"
                    >{{validationContext.errors[0]}}</b-form-invalid-feedback>
                    </b-form-group>
                </validation-provider>
            </form>
        </b-modal>
        </validation-observer>
           </b-row>
        </b-container>
</template>
<script>
export default {
    data(){
        return{
            isError:false,
            variant:"success",
            message:null,
            showMsg:false,
            projets:[],
            form:{
                title:null,
                description:null,
            },
            isModeCreat:false,
        }
    },
    async beforeMount() {
        try {
            const {data} = await this.$http.get('projets',{
                headers: { 'Authorization': 'Bearer '+localStorage.getItem('api_token')},
            });
            this.projets = data.data;
        }catch ({response}) {
            if (response.status === 401) {
                this.isError = true;
                this.message = response.data;
            }
        }
    },
    methods:{
        getValidationState({ dirty, validated, valid = null }) {
            return dirty || validated ? valid : null;
        },
        onClick(proj){
            if (proj == null)
                this.isModeCreat = true;
            Object.assign(this.form,proj);
        },
        resetModal() {
            this.isModeCreat = false;
            this.form = {
                title: null,
                description: null
            };
            this.$nextTick(() => {
                this.$refs.observer.reset();
            });

        },
        handleOk(bvModalEvt) {
            bvModalEvt.preventDefault();

            this.$refs.observer.validate().then(success => {
                    if (!success)
                        return;

                this.onSubmit()
            });
        },
        async onSubmit() {
            try {
                if (!this.isModeCreat){
                const {data} = await this.$http.put(`projets/${this.form.id}`,JSON.stringify(this.form),{
                    headers: { 'Authorization': 'Bearer '+localStorage.getItem('api_token')},
                });
                const oldProjet = this.projets.find(({id})=>id === this.form.id);
                Object.assign(oldProjet,this.form);
                }else{
                    const {data} = await this.$http.post(`projets`,JSON.stringify(this.form),{
                        headers: { 'Authorization': 'Bearer '+localStorage.getItem('api_token')},
                    });
                    this.projets.push(data.data);
                }
            }catch (e) {
                console.error(e);
            }
            this.$nextTick(() => {
                this.$bvModal.hide('modal-projet');
            })
        },
        deleteDialog(projet){
            this.$bvModal.msgBoxConfirm('Please confirm that you want to delete.', {
                title: 'Please Confirm Before Delete',
                size: 'sm',
                buttonSize: 'sm',
                okVariant: 'danger',
                okTitle: 'YES',
                cancelTitle: 'NO',
                footerClass: 'p-2',
                hideHeaderClose: false,
                centered: true
                }).then(async (value) => {
                    this.showMsg = value;
                    if (this.showMsg) {
                        try {
                            const {data} = await this.$http.delete(`projets/${projet.id}`, {
                                headers: {'Authorization': 'Bearer ' + localStorage.getItem('api_token')},
                            });
                            const index = this.projets.indexOf(projet);
                            this.projets.splice(index,1);
                        }catch (e) {
                            this.isError = true;
                            console.error(e);
                        }
                    }
                }).catch(err => {
                    // An error occurred
                })
        }
    }
}
</script>
