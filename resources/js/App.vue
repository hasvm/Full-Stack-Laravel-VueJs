<template>
    <div>
        <candidates-header></candidates-header>
        <candidates></candidates>
    </div>
</template>
<script>
import CandidatesHeader from './candidates/components/CandidatesHeader.vue';
import Candidates from './candidates/components/Candidates.vue';

export default {
    components: {
        CandidatesHeader,
        Candidates,
    }
}
</script>