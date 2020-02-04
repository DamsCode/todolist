<template>
  <b-container fluid>
      <b-navbar class="mb-3" v-if="!usr" type="dark" variant="dark">
          <b-navbar-nav>
              <b-nav-item>
                <router-link to="/login" class="nav-link">Login</router-link>
              </b-nav-item>
              <b-nav-item>
                <router-link to="/signin" class="nav-link">Sign in</router-link>
              </b-nav-item>
        </b-navbar-nav>
      </b-navbar>

      <b-navbar class="mb-3" v-if="usr" type="dark" variant="dark">
          <b-navbar-nav>
              <b-nav-item>
                  <router-link to="/projets" class="nav-link">Projets</router-link>
              </b-nav-item>
              <b-nav-item>
                  <a type="button" v-on:click="logout" class="nav-link">Logout</a>
              </b-nav-item>
              <!--        <li class="nav-item">-->
              <!--          <router-link to="/projet" class="nav-link">Projet</router-link>-->
              <!--        </li>-->
              <!--        <li class="nav-item">-->
              <!--          <router-link to="/create" class="nav-link">Create List</router-link>-->
              <!--        </li>-->
              <!--        <li class="nav-item">-->
              <!--          <router-link to="/lists" class="nav-link">Lists</router-link>-->
              <!--        </li>-->
          </b-navbar-nav>
      </b-navbar>

      <router-view></router-view>
  </b-container>
</template>

<style>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s;
}
.fade-enter,
.fade-leave-active {
  opacity: 0;
}
</style>

<script>
    export default {
        data() {
            return{
                usr:localStorage.key('usr')
            }
        },
        updated: function () {
            this.$nextTick(function () {
                this.usr=localStorage.key('usr')
            })
        },
        methods:{
            logout(){
                if (this.usr)
                    localStorage.clear();
                this.$router.push('/login');
            }
        },
    }
</script>


