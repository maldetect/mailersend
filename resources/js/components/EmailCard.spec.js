import Vue from "vue";
import Vuetify from "vuetify";
import VueTimeago from "vue-timeago";

import EmailCard from "./EmailCard";
import { createLocalVue, mount } from "@vue/test-utils";
import { wrap } from "lodash";
Vue.use(Vuetify);

const email = {
    created_at: "2021-02-21 00:00:00",
    subject: "Subject test",
    from: "from@from.com",
    to: "to@to.com",
    text_content: "text content",
    html_content: "<strong>It works</strong>",
    attachments: []
};
describe("EmailCard.vue", () => {
    const localVue = createLocalVue();
    let vuetify;
    localVue.use(VueTimeago, {
        name: "Timeago", // Component name, `Timeago` by default
        locale: "en" // Default locale
    });

    beforeEach(() => {
        vuetify = new Vuetify();
    });
    it("mounted", () => {
        const wrapper = mount(EmailCard, {
            localVue,
            vuetify,

            propsData: {
                email
            }
        });
        expect(wrapper.vm).toBeDefined();
    });

    it("verify render email", () => {
        const wrapper = mount(EmailCard, {
            localVue,
            vuetify,

            propsData: {
                email
            }
        });
        expect(wrapper.html()).toContain("Subject test");
        expect(wrapper.html()).toContain("from@from.com");
        expect(wrapper.html()).toContain("to@to.com");
        expect(wrapper.html()).toContain("text content");
        expect(wrapper.html()).toContain("<strong>It works</strong>");
    });
});
