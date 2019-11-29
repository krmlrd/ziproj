<template>
    <v-app>
      <div>
        <v-toolbar>
          <v-toolbar-items>
            <v-btn
              :to="{ name: 'home' }"
              text
              exact
            >Home</v-btn>
            <v-btn
              text
              v-if="!loggedIn"
              :to="{ name: 'login' }"
            >Login</v-btn>
            <v-btn
              text
              v-if="loggedIn"
              :to="{ name: 'dashboard' }"
            >Admin</v-btn>
            <v-btn
              text
              v-if="!loggedIn"
              :to="{ name: 'register' }"
            >Register</v-btn>
            <v-btn
              text
              v-if="loggedIn"
              :to="{ name: 'logout' }"
            >Logout</v-btn>
          </v-toolbar-items>
        </v-toolbar>
      </div>
      <v-content>
        <router-view></router-view>
      </v-content>
    </v-app>
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
