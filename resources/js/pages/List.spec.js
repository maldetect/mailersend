import Vue from "vue";
import Vuetify from "vuetify";
import EmailCard from "../components/EmailCard";
import InfiniteLoading from "vue-infinite-loading";
import List from "./List";
import { createLocalVue, mount, shallowMount } from "@vue/test-utils";
import { wrap } from "lodash";
import axios from "axios";
Vue.use(Vuetify);
jest.mock("axios");
const emails = {
    data: {
        success: "true",
        data: [
            {
                created_at: "2021-02-21 00:00:00",
                subject: "Subject test",
                from: "from@from.com",
                to: "to@to.com",
                text_content: "text content",
                html_content: "<strong>It works</strong>",
                attachments: []
            }
        ]
    }
};
describe("List.vue", () => {
    const localVue = createLocalVue();
    let vuetify;

    beforeEach(() => {
        vuetify = new Vuetify();
    });

    afterEach(() => {
        jest.clearAllMocks();
    });

    it("mounted", () => {
        const wrapper = shallowMount(List, {
            localVue,
            vuetify
        });
        expect(wrapper.vm).toBeDefined();
    });

    it("load emails when trigger infiniteHandler", async () => {
        const wrapper = shallowMount(List, {
            localVue,
            vuetify
        });
        axios.get.mockResolvedValue(emails);
        const state = {
            complete: () => {},
            loaded: () => {}
        };
        await wrapper.vm.infiniteHandler(state);
        expect(axios.get).toHaveBeenCalledTimes(1);
        expect(axios.get).toHaveBeenCalledWith("/api/list/0/");
        expect(wrapper.vm.$data.emails.length).toBe(1);
        expect(wrapper.vm.$data.offset).toBe(1);
    });

    it("no more emails to load", async () => {
        const wrapper = shallowMount(List, {
            localVue,
            vuetify
        });
        axios.get.mockResolvedValue({ data: { success: "true", data: [] } });
        const state = {
            complete: () => {},
            loaded: () => {}
        };
        await wrapper.vm.infiniteHandler(state);
        expect(axios.get).toHaveBeenCalledTimes(1);
        expect(axios.get).toHaveBeenCalledWith("/api/list/0/");
        expect(wrapper.vm.$data.emails.length).toBe(0);
        expect(wrapper.vm.$data.offset).toBe(0);
    });

    it("get error when load emails", async () => {
        const wrapper = shallowMount(List, {
            localVue,
            vuetify
        });
        axios.get.mockResolvedValue(Promise.reject("Error test"));
        const state = {
            complete: () => {},
            loaded: () => {}
        };
        await wrapper.vm.infiniteHandler(state);
        expect(axios.get).toHaveBeenCalledTimes(1);
        expect(axios.get).toHaveBeenCalledWith("/api/list/0/");
        expect(wrapper.vm.emails.length).toBe(0);
    });

    it("search", async () => {
        const wrapper = shallowMount(List, {
            localVue,
            vuetify
        });
        //axios.get.mockResolvedValue(Promise.reject(""));
        axios.get.mockResolvedValue(emails);
        const state = {
            complete: () => {},
            loaded: () => {}
        };
        await wrapper.vm.infiniteHandler(state);
        expect(axios.get).toHaveBeenCalledTimes(1);
        expect(axios.get).toHaveBeenCalledWith("/api/list/0/");
        expect(wrapper.vm.$data.emails.length).toBe(1);
        expect(wrapper.vm.$data.offset).toBe(1);
        wrapper.vm.$refs.infinite = {
            stateChanger: {
                reset: () => {}
            }
        };
        wrapper.vm.actionSearch();
        expect(wrapper.vm.$data.emails.length).toBe(0);
        expect(wrapper.vm.$data.offset).toBe(0);
    });
});
