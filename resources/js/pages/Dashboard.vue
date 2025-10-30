<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import EventListItem from '@/components/EventListItem.vue';

interface TrackDay {
    id: number;
    date: Date;
    vehicle: string;
    location: string;
    personal_best_time: string;
}

const props = defineProps<{
    trackDays: TrackDay[]
}>();

</script>

<template>
    <Head title="Dashboard" />
    <header
        class="w-screen bg-blue-500 text-white p-3"
    >
        <h2 class="text-2xl">TrackDays</h2>
        <p>selecteer een track day voor meer informatie</p>
    </header>
    <div
        class="md:grid-cols-2 grid-cols-1 m-auto w-2/3 text-white mt-5"
    >
        <div
            class="row-span-2 grid grid-cols-1 space-y-3"
        >
            <event-list-item v-for="x in props.trackDays" :key="x.id" :event-date="new Date(x.date)" :event-location="x.location" :personal-best-time="x.personal_best_time"/>
        </div>
        <div></div>
        <div></div>
    </div>

</template>
