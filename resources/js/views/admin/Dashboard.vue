<template>
  <v-container fluid>
      <v-layout row>
          <v-col cols="2">
              <admin-navbar />
          </v-col>
          <v-col cols="10">
            <router-view></router-view>
          </v-col>
      </v-layout>
  </v-container>
</template>
<script>
  export default {
    mounted() {
      //
    }
  }
</script>
