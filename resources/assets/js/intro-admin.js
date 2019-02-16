import axios from "axios";
import truncate from "lodash/truncate";

require('./bootstrap');
const Vue = require('vue');

new Vue({
    el:       '#intro-applications',
    data:     {
        loading:      true,
        error: false,
        applications: [],
        search:       "",
        applications_url: "",
        introduction: {}
    },
    methods:  {
        fetchApplications() {
            let that = this;
            this.loading = true;
            axios.get(this.applications_url).then(function (response) {
                let data = response.data;
                if(data.success) {
                    that.applications = data.applications;
                    that.introduction = data.introduction;
                } else {
                    that.error = data.error;
                }
            }).catch(function (error) {
                console.error(error);
                that.error   = true;
            }).finally(() => {
                that.loading = false;
                setTimeout(() => {
                    that.fetchApplications();
                }, 5 * 1000);
            });
        }
    },
    computed: {
        filteredApplications() {
            return this.applications.filter(application => {
                const search = this.search.toLowerCase();
                for (let property in application) {
                    if (typeof application[property] === "string" || typeof application[property] === "number") {
                        if (application[property].toString().toLowerCase().includes(search)) {
                            return true;
                        }
                    } else if (typeof application[property] === "object") {
                        let obj = application[property];
                        for (let property in obj) {
                            if (typeof obj[property] === "string" || typeof obj[property] === "number") {
                                if (obj[property].toString().toLowerCase().includes(search)) {
                                    return true;
                                }
                            }
                        }
                    }
                }
                return false;
            });
        }
    },
    mounted() {
        this.introduction = window.SalveMundi.introduction;
        this.applications_url = this.$el.attributes['data-url'].value;
        this.fetchApplications();
    },
});