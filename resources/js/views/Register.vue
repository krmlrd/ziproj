<template>
    <div class="container">
        <div class="card card-default">
            <div class="card-header">Registration</div>
            <div class="card-body">
              <div v-if="serverErrors" class="server-error">
                <div v-for="(value, key) in serverErrors" :key="key">
                  {{ value[0] }}
                </div>
              </div>
                <form autocomplete="off" @submit.prevent="register" method="post">
                    <div class="form-group" v-bind:class="{ 'input-error': serverErrors && serverErrors.name }">
                        <label for="name">Name</label>
                        <input type="name" id="name" class="form-control" placeholder="user" v-model="name">
                        <span class="help-block">{{ serverErrors.name }}</span>
                    </div>
                    <div class="form-group" v-bind:class="{ 'input-error': serverErrors && serverErrors.email }">
                        <label for="email">E-mail</label>
                        <input type="email" id="email" class="form-control" placeholder="user@example.com" v-model="email">
                        <span class="help-block">{{ serverErrors.email }}</span>
                    </div>
                    <div class="form-group" :class="{ 'input-error': serverErrors && serverErrors.password }">
                        <label for="password">Password</label>
                        <input type="password" id="password" class="form-control" v-model="password">
                        <span class="help-block">{{ serverErrors.password }}</span>
                    </div>
                    <div class="form-group" v-bind:class="{ 'input-error': serverErrors && serverErrors.password }">
                        <label for="password_confirmation">Password confirmation</label>
                        <input type="password" id="password_confirmation" class="form-control" v-model="password_confirmation">
                    </div>
                    <button type="submit" class="btn btn-primary">Registration</button>
                </form>
            </div>
        </div>
    </div>
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
