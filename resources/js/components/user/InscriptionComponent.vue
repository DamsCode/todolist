<template>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">Sign in</div>
                <div class="card-body">
<!--                    <div v-if="loading">Authentication in progress...</div>-->
<!--                    <div v-else class="flex-center position-ref full-height">-->
                        <form
                            id="formsignin"
                            @submit="signin"
                            method="post"
                        >
                            <div v-if="errors.length">
                                <p class="alert alert-danger" v-for="error in errors">{{ error }}</p>
                            </div>

                            <div class="form-group">
                                <label for="name">name</label>
                                <input id="name"  type="text" v-model="name" class="form-control" required>
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
                            <div class="form-group">
                                <label for="c_password">Password Verify</label>
                                <input id="c_password" type="password" v-model="c_password" class="form-control" required >
                            </div>
                            <input type="submit" value="submit" class="btn btn-primary">
                        </form>
<!--                    </div>-->
                </div>
            </div>
        </div>
    </div>


</template>

<script>
export default {
    data() {
        return {
            name:null,
            password:null,
            email:null,
            errors: [],
            c_password:null
        }
    },
    methods:{
        signin(e){

        }
    }
};
</script>
