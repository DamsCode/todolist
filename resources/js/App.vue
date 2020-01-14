<li class="nav-item">
    <a type="button" v-on:click="logout" class="nav-link">Logout</a>
</li><template>
  <div class="container">
      <nav v-if="!usr" class="navbar navbar-expand-sm bg-dark navbar-dark">
          <ul class="navbar-nav">
              <li class="nav-item">
                <router-link to="/login" class="nav-link">Login</router-link>
              </li>
              <li class="nav-item">
                <router-link to="/signin" class="nav-link">Sign in</router-link>
              </li>
          </ul>
      </nav>
      <nav v-if="usr" class="navbar navbar-expand-sm bg-dark navbar-dark">
          <ul class="navbar-nav">
              <li class="nav-item">
                  <router-link to="/projets" class="nav-link">My Projets</router-link>
              </li>
              <li class="nav-item">
                  <a type="button" v-on:click="logout" class="nav-link">Logout</a>
              </li>
              <!--        <li class="nav-item">-->
              <!--          <router-link to="/projet" class="nav-link">Projet</router-link>-->
              <!--        </li>-->
              <!--        <li class="nav-item">-->
              <!--          <router-link to="/create" class="nav-link">Create List</router-link>-->
              <!--        </li>-->
              <!--        <li class="nav-item">-->
              <!--          <router-link to="/lists" class="nav-link">Lists</router-link>-->
              <!--        </li>-->
          </ul>
      </nav>
      <router-view></router-view>
  </div>
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


