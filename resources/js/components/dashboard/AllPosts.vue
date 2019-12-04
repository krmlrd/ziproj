<template>
  <v-row>
    <v-col
      v-for="(post, i) in posts"
      :key="i"
      md="6"
    >
      <v-card
        class="mx-auto"
      >
        <div v-if="post.images[0]">
        <v-img
          :src="post.images[0].image_path"
          height="200px"
        ></v-img>
        </div>
        <v-card-title>
          {{ post.title }}
        </v-card-title>
        <v-card-subtitle>
           {{ truncateText(post.body) }}
        </v-card-subtitle>
        <v-card-actions>
          <v-btn
            color="primary"
            @click="viewPost(i)"
          >View</v-btn>
          <v-btn
            color="error"
            @click="deletePost(i)"
          >Delete</v-btn>
        </v-card-actions>
      </v-card>
    </v-col>
    <!-- <el-dialog v-if="currentPost" :visible.sync="postDialogVisible" width="40%">
      <span>
        <h3>{{ currentPost.title }}</h3>
        <div class="row">
          <div class="col-md-6" v-for="(img, i) in currentPost.images" :key=i>
            <v-img
              :src="img.image_path"
              class="img-thumbnail"
            ></v-img>
          </div>
        </div>
        <hr>
        <p>{{ currentPost.body }}</p>
      </span>
      <span slot="footer" class="dialog-footer">
        <el-button type="primary" @click="postDialogVisible = false">Okay</el-button>
      </span>
    </el-dialog> -->
  </v-row>
</template>

<script>
import { mapState } from 'vuex';
export default {
  name: 'all-posts',
  data() {
    return {
      postDialogVisible: false,
      currentPost: '',
    };
  },
  computed: {
    ...mapState(['posts'])
  },
  beforeMount() {
    this.$store.dispatch('getAllPosts');
  },
  methods: {
    truncateText(text) {
      if (text.length > 24) {
        return `${text.substr(0, 24)}...`;
      }
      return text;
    },
    viewPost(postIndex) {
      const post = this.posts[postIndex];
      this.currentPost = post;
      this.postDialogVisible = true;
    },
    deletePost(postIndex) {
      const post = this.posts[postIndex];
      if(confirm("Do you really want to delete?")) {
        this.$store.dispatch('deletePost', {
          id: post.id,
        }).then(() => {
          this.$store.dispatch('getAllPosts');
        });
      }
    }
  },
}
</script>
