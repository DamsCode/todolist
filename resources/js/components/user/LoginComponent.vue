<template>
    <b-container>
        <b-row  class="text-center justify-content-center">
            <b-card title="Login" border-variant="primary">
                <b-card-body class="card-body">
            <div v-if="loading">Authentication in progress...</div>
            <div v-else class="flex-center position-ref full-height">
                <form
                    id="formLogin"
                    @submit="login"
                    method="post"
                    >
                    <div v-if="errors.length">
                        <p class="alert alert-danger" v-for="error in errors">{{ error }}</p>
                    </div>

                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input id="email"  type="email" v-model="email" class="form-control" aria-describedby="emailHelp" required>
                        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input id="password" type="password" v-model="password" class="form-control" required >
                    </div>
                    <input type="submit" value="login" class="btn btn-primary">
                </form>
                </div>
                </b-card-body>
            </b-card>
        </b-row>
    </b-container>


</template>

<script>
export default {
    data: function () {
        return {
            loading: false,
            errors: [],
            email: null,
            password: null,
        }
    },
    methods:{
         async login(e){
            e.preventDefault();
            this.$data.errors = [];
             this.$data.loading =true;
             try {
                 const {data} = await this.$http.post('login',{
                         email: this.email,
                         password: this.password
                     });
                 localStorage.setItem('name', data.success.user.name);
                 localStorage.setItem('api_token', data.success.user.api_token);
                 await this.$router.push('/home');
             }catch (e) {
                 if (e.response.status === 401) {
                     this.$data.errors.push("Email/Password incorrect");
                 }
             }finally {
                 this.$data.loading =false;
             }
        },
    }
};
</script>
