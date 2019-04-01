require('./bootstrap');
import axios from 'axios';
import truncate from 'lodash/truncate';

window.Vue = require('vue');

new Vue({
    el:      '#store-app',
    data:    {
        loaded: false,
        item: {
            description: ''
        },
        stock: [

        ],
        selectedStock: {
            description: null
        }
    },
    methods: {
        formatPrice(value) {
            return  parseFloat(value).toFixed(2).replace('.', ',');
        }
    },
    computed: {
      description() {
          if(this.selectedStock.description !== null) {
              return this.selectedStock.description.replace(/(\r\n|\n\r|\r|\n)/g, "<br>");
          }
          return this.item.description.replace(/(\r\n|\n\r|\r|\n)/g, "<br>");
      }
    },
    mounted() {
        this.item = window.SalveMundi.store.item;
        this.stock = window.SalveMundi.store.stock;
        this.selectedStock = this.stock[0];
        this.loaded = true;
    },
});