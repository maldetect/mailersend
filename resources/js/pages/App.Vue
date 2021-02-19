<template>
    <v-app id="inspire">
        <v-navigation-drawer v-model="drawer" app>
            <v-list flat>

      <v-list-item-group
        v-model="selectedItem"
        color="primary"
      >
        <v-list-item
          v-for="(item, i) in items"
          :key="i"
          :to="item.to"
        >
          <v-list-item-icon>
            <v-icon v-text="item.icon"></v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title v-text="item.text"></v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list-item-group>
    </v-list>
        </v-navigation-drawer>

        <v-app-bar app>
            <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>

            <v-toolbar-title>Mailer Send</v-toolbar-title>
        </v-app-bar>

        <v-main>

                <v-container fill-height>
                    <router-view></router-view>
                </v-container>

        </v-main>
    </v-app>
</template>

<script>
export default {
    data: () => ({
        drawer:false,
      selectedItem: 1,
      items: [
        { text: 'List', icon: 'mdi-account',to:'/' },

      ],
     })
};
</script>
