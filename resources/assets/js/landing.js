require('./bootstrap');
import axios from 'axios';
import truncate from 'lodash/truncate';
/*
import {debounce} from "lodash/function";

require('./app');

 */

let scrollThreshold = window.innerHeight - 150; // 100vh = 100% van de hoogte van het scherm

$(window).on('resize', function () {
    scrollThreshold = window.innerHeight - 150;
});

$(window).scroll(function () {
    if ($(this).scrollTop() > scrollThreshold) {
        $("header").removeClass("no-background");
    }
    else {
        $("header").addClass("no-background");
    }
});
if ($(window).scrollTop() > scrollThreshold) {
    $("header").removeClass("no-background");
}
window.Vue = require('vue');

new Vue({
    el:      '#events',
    data:    {
        events:     {},
        loading:    true,
        error:      false,
        events_url: null
    },
    methods: {
        getEvents() {
            let that = this;
            axios.get(this.events_url).then(function (response) {
                let events = response.data;
                events.forEach(function (item) {
                    item.description = truncate(item.description, {length: 600});
                });
                that.events  = events;
                that.loading = false;
            }).catch(function (error) {
                console.error(error);
                that.loading = false;
                that.error   = true;
            });

        }
    },
    mounted() {
        this.events_url = this.$el.attributes['data-url'].value;
        this.getEvents();
    },
});