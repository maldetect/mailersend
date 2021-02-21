<template>
    <v-row align="center" justify="center">
        <v-col cols="12">
            <v-card :loading="loading" class="elevation-12 ">
                <v-toolbar color="grey lighten-2 " dark flat>
                    <v-toolbar-title class="black--text"
                        >Emails</v-toolbar-title
                    >
                    <div class="flex-grow-1"></div>
                    <v-text-field
                        class="mt-3"
                        hide-details
                        prepend-icon="search"
                        single-line
                        v-model="search"
                        @keyup.enter.prevent="actionSearch"
                    ></v-text-field>
                </v-toolbar>
                <v-card-text>
                    <CardEmail
                        v-for="email in emails"
                        :key="email.id_email"
                        class="mt-2"
                        :email.sync="email"
                    ></CardEmail>

                    <infinite-loading
                        @infinite="infiniteHandler"
                        ref="infinite"
                    >
                        <div slot="no-more"></div>
                        <div slot="no-results">
                            No data available
                        </div>
                    </infinite-loading>
                </v-card-text>
            </v-card>
        </v-col>
    </v-row>
</template>

<script>
import InfiniteLoading from "vue-infinite-loading";
import CardEmail from "../components/EmailCard";
import axios from "axios";
export default {
    components: {
        InfiniteLoading,
        CardEmail
    },

    data: () => ({
        emails: [],
        offset: 0,
        loading: false,
        search: ""
    }),

    methods: {
        actionSearch() {
            this.offset = 0;
            this.emails = [];
            this.$refs.infinite.stateChanger.reset();
        },
        infiniteHandler($state) {
            axios
                .get("/api/list/" + this.offset + "/" + this.search)
                .then(response => {
                    this.emails.push(...response.data.data);
                    if (response.data.data.length > 0) {
                        this.offset = this.offset + 1;
                        $state.loaded();
                    } else {
                        $state.complete();
                    }
                })
                .catch(error => {
                    console.log(error);
                });
        }
    }
};
</script>
