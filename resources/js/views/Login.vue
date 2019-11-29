<template>
    <v-container>
        <v-card
          class="mx-auto"
        >
            <v-card-title>Log in</v-card-title>
            <v-form>
              <div v-if="successMessage" class="success-message">{{ successMessage }}</div>
              <div v-if="errorMessage" class="error-message">{{ errorMessage }}</div>
              <v-text-field
                prepend-icon="person"
                v-model="email"
                label="email"
                required
              ></v-text-field>
              <v-text-field
                prepend-icon="lock"
                v-model="password"
                label="password"
                required
              ></v-text-field>
              <v-card-actions>
                <v-btn class="mr-4" @click="login">Login</v-btn>
              </v-card-actions>
            </v-form>
        </v-card>
    </v-container>
</template>
<script>
  export default {
    name: 'login',
    props: {
      dataSuccessMessage: {
        type: String,
      }
    },
    data() {
      return {
        email: null,
        password: null,
        errorMessage: '',
        successMessage: this.dataSuccessMessage,
      }
    },
    mounted() {
      //
    },
    methods: {
      login() {
          this.$store.dispatch('retrieveToken', {
          email: this.email,
          password: this.password,
        })
          .then(response => {
            this.$router.push({ name: 'dashboard' })
          })
          .catch(err => {
            this.$store.dispatch('destroyToken')
            this.errorMessage = err.response.data.error || err.response.data.errors
            this.password = ''
            this.successMessage = ''
          })
      }
    }
  }
</script>
