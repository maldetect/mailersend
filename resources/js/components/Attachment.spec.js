import Vue from "vue";
import Vuetify from "vuetify";
import Attachment from "./Attachment";
import { createLocalVue, mount } from "@vue/test-utils";
Vue.use(Vuetify);
const attachments = [
    {
        id_attachment: 1,
        base64: "AABBGGHH",
        filename: "filename.jpg"
    }
];
describe("Attachment.vue", () => {
    const localVue = createLocalVue();
    let vuetify;

    beforeEach(() => {
        vuetify = new Vuetify();
    });
    it("mounted", () => {
        const wrapper = mount(Attachment, {
            localVue,
            vuetify,
            propsData: {
                attachments
            }
        });
        expect(wrapper.vm).toBeDefined();
        expect(wrapper.html()).toContain("filename.jpg");
    });

    it("should download the file", () => {
        const wrapper = mount(Attachment, {
            localVue,
            vuetify,
            propsData: {
                attachments
            }
        });
        const link = {
            click: jest.fn()
        };
        jest.spyOn(document, "createElement").mockImplementation(() => link);
        const button = wrapper.find(".v-btn");
        //console.log(wrapper.html());
        button.trigger("click");

        // expect(link.className).toEqual("download-helper");
        expect(link.download).toEqual("filename.jpg");
        expect(link.href).toEqual(
            "data:application/octet-stream;base64,AABBGGHH"
        );
        expect(link.click).toHaveBeenCalledTimes(1);
    });
});
