<template>
  <div id="main">
    <ul class="nav">
      <li><router-link :to="{ name: 'home' }">Home</router-link></li>
      <li v-if="!loggedIn"><router-link :to="{ name: 'login' }">Login</router-link></li>
      <li v-if="loggedIn"><router-link :to="{ name: 'dashboard' }">Admin</router-link></li>
      <li v-if="!loggedIn"><router-link :to="{ name: 'register' }">Register</router-link></li>
      <li v-if="loggedIn"><router-link :to="{ name: 'logout' }">Logout</router-link></li>
    </ul>
    <div id="content">
        <router-view></router-view>
    </div>
  </div>
</template>
<script>
  export default {
    computed: {
      loggedIn() {
        return this.$store.getters.loggedIn
      }
    }
  }
</script>
<style lang="scss">
  * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
  }
  #main {
    font-family: 'Avenir', Helvetica, Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    color: #2c3e50;
    font-size: 24px;
    height: 100vh;
  }
  .flex-center {
    display: flex;
    justify-content: center;
  }
  .nav {
    display: flex;
    list-style: none;
    padding: 15px 0;
    margin: 0;
    justify-content: flex-end;
    background: rgba(0, 0, 0, 0.03);
    border-bottom: 1px solid lightgrey;
    margin-bottom: 24px;
  }
  .nav a {
    color: #636b6f;
    padding: 0 25px;
    font-size: 14px;
    font-weight: 600;
    letter-spacing: .1rem;
    text-decoration: none;
    text-transform: uppercase;
  }
</style>
