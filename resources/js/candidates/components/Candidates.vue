<template>
    <div>
        <div class="p-10">
            <h1 class="text-4xl font-bold">Candidates</h1>
        </div>
        <div :class="getCandidatesStyle()" v-if="!loading">
            <div v-for="candidate in candidates" v-bind:key="candidate.id" class="rounded overflow-hidden shadow-lg">
                <Candidate :candidate="candidate"></Candidate>
                <div class="p-6 float-right">
                    /**add if contacted, hired or not to the button */
                    <button :class="getContactButtonStyle()" @click="contactCandidate(candidate.id)"> {{ candidatesStore.contactStatus(candidate.id) }}</button>
                    <button :class="getHireButtonStyle()" @click="hireCandidate(candidate.id)"> {{ candidatesStore.hireStatus(candidate.id) }} </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import Candidate from './Candidate';
import { useCandidatesStore } from '../../stores/candidates-store';
import { storeToRefs } from 'pinia';

export default {
    setup() {
        const candidatesStore = useCandidatesStore();
        const { candidates, loading } = storeToRefs(candidatesStore);
        candidatesStore.getCandidates();
        return {candidatesStore, candidates, loading};
    },
    components: {
        Candidate,
    },
    methods: {
        contactCandidate(candidateId)
        {
            // This message is not being used but we could show it to the user with a pop-up to inform him
            let msg = this.candidatesStore.contactCandidate(candidateId);
        },
        hireCandidate(candidateId)
        {
            // This message is not being used but we could show it to the user with a pop-up to inform him
            let msg = this.candidatesStore.hireCandidate(candidateId);     
        },
        getContactButtonStyle()
        {
            return 'bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow';
        },
        getHireButtonStyle()
        {
            return 'bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 hover:bg-teal-100 rounded shadow';
        },
        getCandidatesStyle()
        {
            return 'p-10 grid grid-cols-1 sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-3 gap-5';
        },
    },
}
</script>
