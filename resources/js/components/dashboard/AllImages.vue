<template>
  <v-row>
    <v-col
      v-for="(image, i) in images"
      :key="i"
      md="6"
    >
      <v-card
        class="mx-auto"
      >
        <v-img
          :src="image.image_path"
          height="200px"
        ></v-img>
        </div>
        <v-card-title>
          {{ image.title }}
        </v-card-title>
        <v-card-actions>
          <v-btn
            color="error"
            @click="deleteImage(i)"
          >Delete</v-btn>
        </v-card-actions>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>
import { mapState } from 'vuex';
export default {
  name: 'all-images',
  data() {
    return {
      currentImage: '',
    };
  },
  computed: {
    ...mapState(['images'])
  },
  beforeMount() {
    this.$store.dispatch('getAllImages');
  },
  methods: {
    deleteImage(imageIndex) {
      const image = this.images[imageIndex];
      if(confirm("Do you really want to delete?")) {
        this.$store.dispatch('deleteImage', {
          id: image.id,
        }).then(() => {
          this.$store.dispatch('getAllImages');
        });
      }
    }
  },
}
</script>
