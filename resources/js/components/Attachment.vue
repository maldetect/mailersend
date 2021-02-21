<template>
    <div>
        <p v-if="attachments.length == 0"><strong>No Attachments</strong></p>
        <p v-else><strong>Attachments</strong></p>
        <div
            style="display:inline"
            v-for="attachment in attachments"
            :key="attachment.id_attachment"
        >
            {{ attachment.filename }}
            <v-btn
                icon
                color="primary"
                @click="downloadFile(attachment.base64, attachment.filename)"
            >
                <v-icon>mdi-file-download</v-icon>
            </v-btn>
        </div>
    </div>
</template>
<script>
export default {
    name: "Attachment",
    data() {
        return {};
    },
    props: {
        attachments: {
            type: Array,
            required: true
        }
    },
    methods: {
        downloadFile(base64, filename) {
            const link = document.createElement("a");
            link.href = "data:application/octet-stream;base64," + base64;
            link.download = filename;
            link.click();
        }
    }
};
</script>
