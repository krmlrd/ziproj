<template>
  <v-card
    class="mx-auto"
  >
      <v-card-title>Upload Images</v-card-title>
      <v-card-subtitle>
        <div v-if=status_msg :class="{'alert-success': status, 'alert-danger': !status }" class="alert" role="alert">
          {{ status_msg }}
        </div>
      </v-card-subtitle>

      <v-card-actions>
        <v-btn
          class="mr-4"
          color="primary"
          @click="uploadImages"
        >Upload Images</v-btn>
      </v-card-actions>
  </v-card>
</template>

<style>
</style>

<script>
import { setTimeout } from 'timers';
import { mapState, mapActions } from 'vuex';
export default {
  name: 'upload-images',
  props: ['images'],
  data() {
    return {
      imageList: [],
      status_msg: '',
      status: '',
      title: '',
    };
  },
  // computed: {
  //   ...mapActions(['getAllPosts']),
  // },
  mounted() {
  },
  methods: {
    updateImageList(file) {
      this.imageList.push(file.raw);
    },
    uploadImages(e) {
      e.preventDefault();
      if (!this.validateForm()) {
        return false;
      }
      // let formData = new FormData();
      // formData.append('title', this.title);
      // $.each(this.imageList, function(key, image) {
      //   formData.append(`images[${key}]`, image);
      // });
      // axios.post('/image/create', formData, {headers: {'Content-Type': 'multipart/form-data'}})
      //   .then((res) => {
      //     this.title = this.body = '';
      //     this.status = true;
      //     this.showNotification('Images Successfully Uploaded');
      //     this.$store.dispatch('getAllImages')
      //   });
    },
    validateForm() {
      if (!this.images) {
        this.status = false;
        this.showNotification('Images cannot be empty!');
        return false;
      }
    },
    showNotification(message) {
      this.status_msg = message;
      setTimeout(() => {
        this.status_msg = '';
      }, 3000);
    }
  },
};
</script>
