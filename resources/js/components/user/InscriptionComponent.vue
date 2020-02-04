<template>
    <b-container>
        <b-alert v-if="isSign" variant="success" show>Your have register successfully, now you can <router-link to="/login"><strong>Login</strong></router-link></b-alert>
        <b-row v-else class="text-center justify-content-center">
            <b-card title="Sign in" border-variant="primary">
                <b-card-body class="card-body">
<!--                    <div v-if="loading">Authentication in progress...</div>-->
<!--                    <div v-else class="flex-center position-ref full-height">-->
                        <validation-observer ref="observer" v-slot="{ handleSubmit }">
                        <form
                            ref="form"
                            @submit.stop.prevent="handleSubmit(signin)">
<!--                            <div v-if="errors.length">-->
<!--                                <p class="alert alert-danger" v-for="error in errors">{{ error }}</p>-->
<!--                            </div>-->

                            <validation-provider name="name" rules="required|alpha_spaces" v-slot="validationContext">
                                <b-form-group
                                    label="name"
                                    label-for="name-input"
                                >
                                    <b-form-input
                                        id="name-input"
                                        v-model="form.name"
                                        :state="getValidationState(validationContext)"
                                    />
                                    <b-form-invalid-feedback
                                        id="name-input-live-feedback"
                                    >{{validationContext.errors[0]}}</b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                            <validation-provider name="email" vid="email" rules="required|email" v-slot="validationContext">
                                <b-form-group
                                    label="email"
                                    label-for="email-input"
                                >
                                    <b-form-input
                                        id="email-input"
                                        type="email"
                                        v-model="form.email"
                                        :state="getValidationState(validationContext)"
                                    />
                                    <b-form-invalid-feedback
                                        id="email-input-live-feedback"
                                    >{{validationContext.errors[0]}}</b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                            <validation-provider name="password" rules="required|min:6" vid="confirmation" v-slot="validationContext">
                                <b-form-group
                                    label="password"
                                    label-for="password-input"
                                >
                                    <b-form-input
                                        id="password-input"
                                        type="password"
                                        v-model="form.password"
                                        :state="getValidationState(validationContext)"
                                    />
                                    <b-form-invalid-feedback
                                        id="password-input-live-feedback"
                                    >{{validationContext.errors[0]}}</b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                            <validation-provider name="c_password" rules="required|confirmed:confirmation" v-slot="validationContext" >
                                <b-form-group
                                    label="confirmation password"
                                    label-for="c_password-input"
                                >
                                    <b-form-input
                                        id="c_password-input"
                                        type="password"
                                        v-model="form.c_password"
                                        :state="getValidationState(validationContext)"
                                    />
                                    <b-form-invalid-feedback
                                        id="c_password-input-live-feedback"
                                    >{{validationContext.errors[0]}}</b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                            <input type="submit" value="Register" class="btn btn-primary">
                        </form>
                    </validation-observer>
<!--                    </div>-->
                </b-card-body>
            </b-card>
        </b-row>
    </b-container>


</template>

<script>
export default {
    data() {
        return{
            isError:false,
            form :{
                name:null,
                password:null,
                email:null,
                c_password:null
            },
            errors: [],
            isSign:false
        }
    },
    methods:{
        getValidationState({ dirty, validated, valid = null }) {
            return dirty || validated ? valid : null;
        },
        async signin(){
            try {
                // console.log(JSON.stringify(this.form))
                const {data} = await this.$http.post(`register/`,JSON.stringify(this.form));
                this.isSign = true;
            }catch (e) {
                if (e.response.status === 401) {
                    this.$refs.observer.setErrors({
                        email: ['This email is already taken']
                    });
                }
            }
        }
    }
};
</script>
