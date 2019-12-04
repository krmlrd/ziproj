<template>
  <v-card
    class="mx-auto"
  >
      <v-card-title>New Post</v-card-title>
        <v-form>
          <v-text-field
            prepend-icon="title"
            v-model="title"
            label="Title"
            required
            :error-messages="titleErrors"
            @input="$v.title.$touch()"
            @blur="$v.title.$touch()"
          ></v-text-field>
          <v-textarea
            prepend-icon="short_text"
            v-model="body"
            label="Post Content"
            required
            :error-messages="bodyErrors"
            @input="$v.body.$touch()"
            @blur="$v.body.$touch()"
          ></v-textarea>
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
        </v-form>
      <v-card-actions>
        <v-btn
          class="mr-4"
          color="primary"
          @click="createPost"
        >Create Post</v-btn>
      </v-card-actions>
  </v-card>
</template>

<style>
</style>

<script>
import { mapState, mapActions } from 'vuex';
import { required } from 'vuelidate/lib/validators';
export default {
  name: 'create-post',
  props: ['posts'],
  data() {
    return {
      dialogImageUrl: '',
      dialogVisible: false,
      images: [],
      status_msg: '',
      status: '',
      isCreatingPost: false,
      title: '',
      body: '',
    };
  },
  computed: {
    titleErrors () {
      const errors = []
      if (!this.$v.title.$dirty) return errors
      !this.$v.title.required && errors.push('Title is required!')
      return errors
    },
    bodyErrors () {
      const errors = []
      if (!this.$v.body.$dirty) return errors
      !this.$v.body.required && errors.push('Body is required!')
      return errors
    },
    imagesErrors () {
      const errors = []
      if (!this.$v.images.$dirty) return errors
      !this.$v.images.required && errors.push('Images are required!')
      return errors
    },
  },
  validations: {
    title: { required },
    body: { required },
    images: { required },
  },
  mounted() {
  },
  methods: {
    createPost(e) {
      e.preventDefault();
      this.$v.$touch()
      if (this.$v.$pending || this.$v.$error) return
      this.isCreatingPost = true;
      let formData = new FormData();
      formData.append('title', this.title);
      formData.append('body', this.body);
      this.images.forEach(function(image, key){
        formData.append(`images[${key}]`, image)
      })

      this.$store.dispatch('createPost', formData)
        .then(response => {
          console.log(response)
          this.title = this.body = '';
          this.status = true;
          this.isCreatingPost = false;
          this.$store.dispatch('getAllPosts')
        })
        .catch(err => {
          console.log(err)
        })
    },
  },
};
</script>
