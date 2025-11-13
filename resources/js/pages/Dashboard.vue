<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3';
import EventListItem from '@/components/EventListItem.vue';
import { ref } from 'vue';
import { VueDatePicker } from '@vuepic/vue-datepicker';
import { logout } from '@/routes';
import TextLink from '@/components/TextLink.vue';

interface TrackDay {
    id: number;
    start_date: Date;
    end_date: Date;
    vehicle: string;
    location: string;
    personal_best_time: string;
    status: string;
}

const props = defineProps<{
    trackDays: TrackDay[]
}>();

const searchInput = ref("")

const dateInput = ref(null)

const datePickerFormat = {
    input: 'dd/MM/yyyy',
    preview: 'dd/MM/yyyy',
};

function filteredTrackDays() {
    let filteredTrackDays = props.trackDays.filter((trackDay) =>
        trackDay.location.toLowerCase().includes(searchInput.value.toLowerCase())
    );

    if (dateInput.value === null) { return filteredTrackDays;}
    let input = new Date(dateInput.value).toDateString();

    filteredTrackDays = filteredTrackDays.filter((trackDay) =>
        dateInput.value === null ||
        new Date(trackDay.start_date).toDateString().includes(input)
    );
    return filteredTrackDays;
}

</script>

<template>
    <Head title="Dashboard" />
    <header
        class="w-screen bg-blue-500 text-white p-3 flex"
    >
        <div>
            <h2 class="text-2xl">TrackDays</h2>
            <p>selecteer een track day voor meer informatie</p>
        </div>
        <TextLink
            :href="logout()"
            as="button"
            class="ml-auto mr-5 block bg-blue-900 px-3 rounded "
        >
            Log out
        </TextLink>
    </header>
    <div
        class="w-2/3 m-auto mt-5 flex space-x-3"
    >
        <input v-model="searchInput" class="bg-white border border-gray rounded p-1" type="text" placeholder="Zoeken">
        <div class="w-fit">
            <vue-date-picker :formats="datePickerFormat" v-model="dateInput"></vue-date-picker>
        </div>
        <a
            href="/dashboard/create-track-day"
            class="bg-green-500 rounded p-3 text-white"
        >Nieuwe TrackDay</a>
    </div>
    <div
        class="md:grid-cols-2 grid-cols-1 m-auto w-11/12 md:w-2/3 text-white mt-5"
    >
        <div
            class="row-span-2 grid grid-cols-1 space-y-3"
        >
            <event-list-item v-for="x in filteredTrackDays()" :href="`dashboard/track-day/${x.id}`" :key="x.id" :status="x.status" :event-start-date="new Date(x.start_date)" :event-end-date="new Date(x.end_date)" :event-location="x.location" :personal-best-time="x.personal_best_time"/>
        </div>
    </div>

</template>
