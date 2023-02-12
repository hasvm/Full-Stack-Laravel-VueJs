<template>
    <div class="w-full p-6 bg-teal-100 text-right font-bold">
        <div v-if="!loading">
            Your wallet has: {{ coins }} coins
        </div>
    </div>
</template>

<script>

import { useWalletStore } from '../../stores/wallet-store';
import { storeToRefs } from 'pinia';

export default {
    setup() {
        const walletStore = useWalletStore();
        const { coins, loading } = storeToRefs(walletStore);

        walletStore.getWallet();

        return {walletStore, coins, loading};
    },
}
</script>