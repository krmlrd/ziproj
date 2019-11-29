<template>
  <div>
  <v-card
    height="400"
    width="256"
    class="mx-auto"
  >
    <v-navigation-drawer permanent>
      <v-list-item>
        <v-list-item-content>
          <v-list-item-title class="title">
            Admin dashboard
          </v-list-item-title>
          <v-list-item-subtitle>
            choose sub-category
          </v-list-item-subtitle>
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
  }
</script>
