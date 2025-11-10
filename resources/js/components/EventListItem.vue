<script setup lang="ts">
    import { Link } from '@inertiajs/vue3';

    const props = defineProps({
        eventLocation: String,
        eventStartDate: {
            required: true,
            type: Date,
        },
        eventEndDate: {
            required: true,
            type: Date,
        },
        personalBestTime: String,
        href: String,
    })

    const daysUntil = Math.floor(Math.abs(new Date().getTime() - props.eventStartDate.getTime())/ (1000 * 3600 * 24));
    const eventLengthInDays = Math.ceil(Math.abs(props.eventStartDate.getTime() - props.eventEndDate.getTime())/ (1000 * 3600 * 24));
</script>

<template>
    <Link :href="href">
        <div
            class="grid grid-cols-2 bg-stone-900 border-2 border-blue-500 rounded p-3 "
        >
            <h2
                class="text-2xl col-span-2"
            >{{props.eventLocation}}</h2>
            <p>Start datum: {{props.eventStartDate?.getDate() }} / {{props.eventStartDate?.getMonth() + 1 }} / {{props.eventStartDate?.getFullYear() }}</p>
            <div class="">
                <p v-if="daysUntil > 0"
                    class="bg-green-500 rounded-full w-2/5 ml-auto text-center px-1"
                >Gepland</p>

                <p v-if="daysUntil <= 0 && daysUntil >= daysUntil - eventLengthInDays"
                    class="bg-amber-500 rounded-full w-2/5 ml-auto text-center px-1"
                >Bezig</p>

                <p v-if="daysUntil < 0 - eventLengthInDays"
                    class="bg-red-500 rounded-full w-2/5 ml-auto text-center px-1"
                >Afgerond</p>
            </div>
            <p v-if="daysUntil >= 0"
                class="text-yellow-300 col-span-1"
            >nog {{daysUntil}} dagen</p>
            <p
                class="text-green-500 text-end"
            >PB: {{props.personalBestTime??'00:00:000'}}</p>
        </div>
    </Link>
</template>

<style scoped>

</style>
