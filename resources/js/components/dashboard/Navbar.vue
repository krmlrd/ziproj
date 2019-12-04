<template>
  <div>
  <v-card
    height="400"
    max-width="256"
    class="mx-auto"
  >
    <v-navigation-drawer
      permanent
      :mini-variant="mini"
    >
      <v-list-item>
        <v-list-item-content>
          <v-list-item-title class="title">
            Z
          </v-list-item-title>
        </v-list-item-content>
      </v-list-item>
      <v-divider></v-divider>
      <v-list
        dense
        nav
      >
        <v-list-item
          v-for="item in items"
          :key="item.title"
          :to="item.link"
          link
        >
          <v-list-item-icon>
            <v-icon>{{ item.icon }}</v-icon>
          </v-list-item-icon>

          <v-list-item-content>
            <v-list-item-title>{{ item.title }}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>
  </v-card>
</div>
</template>

<script>
  export default {
    data () {
      return {
        items: [
          { title: 'Photos', icon: 'mdi-image', link: '/admin/images' },
          { title: 'Posts', icon: 'mdi-message-image', link: '/admin/posts' },
        ],
        right: null,
      }
    },
    computed: {
      mini() {
        return this.$vuetify.breakpoint.mdAndDown;
      }
    }
  }
</script>
