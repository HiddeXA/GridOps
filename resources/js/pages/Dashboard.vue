<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import EventListItem from '@/components/EventListItem.vue';
import { ref } from 'vue';

interface TrackDay {
    id: number;
    start_date: Date;
    end_date: Date;
    vehicle: string;
    location: string;
    personal_best_time: string;
}

const props = defineProps<{
    trackDays: TrackDay[]
}>();

const searchInput = ref("")

const dateInput = ref(null)

function filteredTrackDays() {
    let filteredTrackDays = props.trackDays.filter((trackDay) =>
        trackDay.location.toLowerCase().includes(searchInput.value.toLowerCase())
    );

    filteredTrackDays = filteredTrackDays.filter((trackDay) =>
        dateInput.value === null ||
        trackDay.start_date.toString().includes(dateInput.value)
    );

    return filteredTrackDays;
}

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
        class="w-2/3 m-auto mt-5"
    >
        <input v-model="searchInput" class="bg-white border border-gray rounded p-1" type="text" placeholder="Zoeken">
        <input v-model="dateInput" class="bg-white border border-gray rounded p-1" type="date">
    </div>
    <div
        class="md:grid-cols-2 grid-cols-1 m-auto w-2/3 text-white mt-5"
    >
        <div
            class="row-span-2 grid grid-cols-1 space-y-3"
        >
            <event-list-item v-for="x in filteredTrackDays()" :href="`dashboard/track-day/${x.id}`" :key="x.id" :event-start-date="new Date(x.start_date)" :event-end-date="new Date(x.end_date)" :event-location="x.location" :personal-best-time="x.personal_best_time"/>
        </div>
    </div>

</template>
