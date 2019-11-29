<template>
  <v-card
    class="mx-auto"
  >
      <v-card-title>New Post</v-card-title>
      <v-card-subtitle>
        <div v-if=status_msg :class="{'alert-success': status, 'alert-danger': !status }" class="alert" role="alert">
          {{ status_msg }}
        </div>
      </v-card-subtitle>
        <v-form>
          <v-text-field
            prepend-icon="title"
            v-model="title"
            label="Title"
            required
          ></v-text-field>
          <v-textarea
            prepend-icon="short_text"
            v-model="body"
            label="Post Content"
            required
          ></v-textarea>
          <div class="">
            <el-upload
              action = ""
              list-type="picture-card"
              :on-preview="handlePictureCardPreview"
              :on-change="updateImageList"
              :auto-upload="false">
              <i class="el-icon-plus"></i>
            </el-upload>
            <el-dialog :visible.sync="dialogVisible">
              <img width="100%" :src="dialogImageUrl" alt="">
            </el-dialog>
          </div>
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
import { setTimeout } from 'timers';
import { mapState, mapActions } from 'vuex';
export default {
  name: 'create-post',
  props: ['posts'],
  data() {
    return {
      dialogImageUrl: '',
      dialogVisible: false,
      imageList: [],
      status_msg: '',
      status: '',
      isCreatingPost: false,
      title: '',
      body: '',
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
    handlePictureCardPreview(file) {
      this.dialogImageUrl = file.url;
      this.imageList.push(file);
      this.dialogVisible = true;
    },
    createPost(e) {
      e.preventDefault();
      if (!this.validateForm()) {
        return false;
      }
      this.isCreatingPost = true;
      let formData = new FormData();
      formData.append('title', this.title);
      formData.append('body', this.body);
      $.each(this.imageList, function(key, image) {
        formData.append(`images[${key}]`, image);
      });
      axios.post('/post/create', formData, {headers: {'Content-Type': 'multipart/form-data'}})
        .then((res) => {
          this.title = this.body = '';
          this.status = true;
          this.showNotification('Post Successfully Created');
          this.isCreatingPost = false;
          this.$store.dispatch('getAllPosts')
        });
    },
    validateForm() {
      if (!this.title) {
        this.status = false;
        this.showNotification('Post title cannot be empty');
        return false;
      }
      if (!this.body) {
        this.status = false;
        this.showNotification('Post body cannot be empty');
        return false;
      }
      return true;
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
