<template>
    <div>
        <img class="w-full" src="/avatar.png" alt="">
        <div class="px-6 py-4">
            <div class="font-bold text-xl mb-2">
                {{candidate.name}}
            </div>
            <p class="text-gray-700 text-base">{{candidate.description}}</p>
        </div>
        <div class="px-6 pt-4 pb-2">
            <span v-for="strength in JSON.parse(candidate.strengths)" v-bind:key="strength" :class="getStrengthStyle()">
                {{strength}}
            </span>
        </div>
    </div>
</template>

<script>

export default {
    name: 'candidate',
    props: ['candidate'],
    methods: {
        getStrengthStyle()
        {
            return 'inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2';
        },
    },
}

</script>