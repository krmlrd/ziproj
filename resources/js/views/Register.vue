<template>
  <v-container>
      <v-card
        class="mx-auto"
      >
            <v-card-title>Registration</v-card-title>
              <div v-if="serverErrors" class="server-error">
                <div v-for="(value, key) in serverErrors" :key="key">
                  {{ value[0] }}
                </div>
              </div>
              <v-form>
                  <v-text-field
                    prepend-icon="person"
                    v-model="name"
                    label="Name"
                    required
                  ></v-text-field>
                  <v-text-field
                    prepend-icon="person"
                    v-model="email"
                    label="E-mail"
                    required
                  ></v-text-field>
                  <v-text-field
                    prepend-icon="person"
                    v-model="password"
                    label="Password"
                    required
                  ></v-text-field>
                  <v-text-field
                    prepend-icon="person"
                    v-model="password_confirmation"
                    label="Password confirmation"
                    required
                  ></v-text-field>
                  <v-card-actions>
                    <v-btn class="mr-4" @click="register">Registration</v-btn>
                  </v-card-actions>
              </v-form>
            </div>
        </v-card>
    </v-container>
</template>
<script>
  export default {
    data() {
      return {
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
        serverErrors: '',
        success: false
      }
    },
    methods: {
      register() {
        this.$store.dispatch('register', {
          name: this.name,
          email: this.email,
          password: this.password,
          password_confirmation: this.password_confirmation,
        })
          .then(response => {
            this.successMessage = 'Registered Successfully!'
            this.$router.push({ name: 'login', params: { dataSuccessMessage: this.successMessage } })
          })
          .catch(err => {
            this.serverErrors = Object.values(err.response.data.errors) || {}
            this.successMessage = ''
          })
      }
    }
  }
</script>
