<template>
    <v-card>
        <v-card-title>{{ email.subject }}</v-card-title>
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
            <Attachment :attachments.sync="email.attachments"></Attachment>

        </v-card-text>
    </v-card>
</template>
<script>
import Attachment from './Attachment'
export default {
  components: { Attachment },
    name: "CardEmail",

    data() {
        return {};
    },
    props: ["email"]
};
</script>
