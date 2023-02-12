import { defineStore } from "pinia";
import requests from '../wallet/requests/requests';

export const useWalletStore = defineStore('walletStore', {
    state: () => ({
        wallet: {},
        value: 0,
        loading: true,
    }),

    getters: {
        coins() {
            return typeof this.wallet.coins !== "undefined" ? this.wallet.coins : '?';
        },
    },

    actions: {
        contact() {
            this.wallet.coins -= this.value;
        },
        hire() {
            this.wallet.coins += this.value;
        },
        async getWallet() {
            //could have defined a store for the company and get the company id throught a getter
            requests.getWallet(1).then(response => {
                this.wallet = response.wallet;
                this.value = response.value;
                this.loading = false;
            });
        },
    },
});