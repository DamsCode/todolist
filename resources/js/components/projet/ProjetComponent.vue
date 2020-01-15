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

   <!--MODAL-->
        <validation-observer ref="observer" v-slot="{ handleSubmit }">
        <b-modal
            id="modal-projet"
            ref="modal"
            title="Edit Form"
            @show="resetModal"
            @hidden="resetModal"
            @ok="handleOk"
        >

            <form ref="form" @submit.stop.prevent="handleSubmit(onSubmit)">
                <validation-provider :rules="{ required: true }" v-slot="validationContext">
                <b-form-group
                    label="title"
                    label-for="title-input"
                    invalid-feedback="title is required"
                >
                    <b-form-input
                        id="title-input"
                        v-model="form.title"
                        :state="getValidationState(validationContext)"
                    />
                </b-form-group>
                </validation-provider>
                <validation-provider :rules="{ required: true }" v-slot="validationContext">

                <b-form-group
                        label="description"
                        label-for="description-input"
                        invalid-feedback="description is required"
                    >
                    <b-form-input
                        id="description-input"
                        v-model="form.description"
                        :state="getValidationState(validationContext)"
                    />
                    </b-form-group>
                </validation-provider>
            </form>
        </b-modal>
        </validation-observer>
    </div>
</template>
<script>
export default {
    data(){
        return{
            projets:[],
            errors:[],
            form:{
                title:null,
                description:null,
            },
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
        getValidationState({ dirty, validated, valid = null }) {
            return dirty || validated ? valid : null;
        },
        resetModal() {
            this.form = {
                name: null,
                food: null
            };
            this.errors = [];
            this.$nextTick(() => {
                this.$refs.observer.reset();
            });

        },
        handleOk(bvModalEvt) {
            bvModalEvt.preventDefault();
            // if(!invalid)
            //     this.handleSubmit()
        },
        onSubmit() {
            console.log(JSON.stringify(this.form));
            //api call
            this.$nextTick(() => {
                this.$bvModal.hide('modal-projet');
            })
        }
    }
}
</script>
