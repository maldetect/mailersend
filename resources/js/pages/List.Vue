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
  @keyup.enter.prevent='actionSearch'
></v-text-field>
                </v-toolbar>
                <v-card-text>
                    <v-card
                        v-for="email in emails"
                        :key="email.id_email"
                        class="mt-2"
                    >
                        <v-card-title>{{email.subject}}</v-card-title>
                        <v-card-text>
                            <p>
                                Created at:
                                <timeago
                                    :datetime="email.created_at"
                                    :auto-update="5"
                                ></timeago>
                            </p>
                            <p>From: {{ email.from }}</p>
                            <p>To: {{ email.to }}</p>
                            <p>Status: {{ email.status }}</p>
                            <p>{{ email.text_content }}</p>
                            <v-list-item no-action>
                                <v-list-item-content>
                                    <v-list-item-subtitle
                                        v-html="email.html_content"
                                    ></v-list-item-subtitle>
                                </v-list-item-content>
                            </v-list-item>
                            <p> Attachments</p>
                            <div
                                style="display:inline"
                                v-for="attachment in email.attachments"
                            >
                                {{ attachment.filename }}
                                <v-btn
                                    icon
                                    color="primary"
                                    @click="
                                        downloadFile(
                                            attachment.base64,
                                            attachment.filename
                                        )
                                    "
                                >
                                    <v-icon>mdi-file-download</v-icon>
                                </v-btn>
                            </div>
                        </v-card-text>
                    </v-card>

                    <infinite-loading @infinite="infiniteHandler" ref="infinite">
                        <div slot="no-more"></div>
                        <div slot="no-results">
                            Nenhuma movimentação encontrada
                        </div>
                    </infinite-loading>
                </v-card-text>
            </v-card>
        </v-col>
    </v-row>
</template>

<script>
import InfiniteLoading from "vue-infinite-loading";
import axios from "axios";
export default {
    components: {
        InfiniteLoading
    },

    data: () => ({
        emails: [],
        offset: 0,
        loading: false,
        search:''
    }),

    methods: {
        actionSearch(){
            this.offset=0;
            this.emails=[]
            this.$refs.infinite.stateChanger.reset();
        },
        downloadFile(base64, filename) {

            const link = document.createElement("a");
            link.href = 'data:application/octet-stream;base64,'+base64;
            link.download = filename.replaceAll('"', "").replaceAll("'", "");
            link.click();
        },
        infiniteHandler($state) {
            axios
                .get("/api/list/" + this.offset+'/'+this.search)
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
