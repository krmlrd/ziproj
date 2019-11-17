<template>
    <div class="container">
        <div class="card card-default">
            <div class="card-header">Log in</div>
            <div class="card-body">
                <form autocomplete="off" @submit.prevent="login" method="post">
                  <div v-if="successMessage" class="success-message">{{ successMessage }}</div>
                  <div v-if="errorMessage" class="error-message">{{ errorMessage }}</div>
                  <div class="form-group">
                      <label for="email">E-mail</label>
                      <input type="email" id="email" class="form-control" placeholder="user@example.com" v-model="email" required>
                  </div>
                  <div class="form-group">
                      <label for="password">Password</label>
                      <input type="password" id="password" class="form-control" v-model="password" required>
                  </div>
                  <button type="submit" class="btn btn-primary">
                    Enter
                  </button>
              </form>
            </div>
        </div>
    </div>
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
