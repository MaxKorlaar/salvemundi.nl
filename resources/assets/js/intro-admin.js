require('./bootstrap');
const Vue = require('vue');

new Vue({
    el:       '#intro-applications',
    data:     {
        loading:      true,
        applications: [],
        search:       ""
    },
    methods:  {},
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
        this.applications = window.SalveMundi.introduction.applications;
        this.loading      = false;
    },
});