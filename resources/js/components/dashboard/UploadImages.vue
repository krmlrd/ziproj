<template>
  <v-card
    class="mx-auto"
  >
      <v-card-title>Upload Images</v-card-title>
      <v-file-input
        small-chips
        multiple
        label="Select images"
        prepend-icon="mdi-camera"
        v-model="images"
        :error-messages="imagesErrors"
        @input="$v.images.$touch()"
        @blur="$v.images.$touch()"
      ></v-file-input>

      <v-card-actions>
        <v-btn
          class="mr-4"
          color="primary"
          @click="uploadImages"
        >Upload</v-btn>
      </v-card-actions>
  </v-card>
</template>

<style>
</style>

<script>
import { mapState, mapActions } from 'vuex';
import { required } from 'vuelidate/lib/validators';
export default {
  name: 'upload-images',
  props: ['uploads'],
  data() {
    return {
      images: [],
      status_msg: '',
      status: '',
      title: '',
    };
  },
  computed: {
    imagesErrors () {
      const errors = []
      if (!this.$v.images.$dirty) return errors
      !this.$v.images.required && errors.push('Images are required!')
      return errors
    },
  },
  validations: {
    images: { required },
  },
  mounted() {
  },
  methods: {
    uploadImages(e) {
      e.preventDefault();
      this.$v.$touch()
      if (this.$v.$pending || this.$v.$error) return
      let formData = new FormData()
      this.images.forEach(function(image, key){
        formData.append(`images[${key}]`, image)
      })

      this.$store.dispatch('uploadImages', formData)
        .then(response => {
          console.log(response)
          this.$store.dispatch('getAllImages')
        })
        .catch(err => {
          console.log(err)
        })
    },
  },
};
</script>
