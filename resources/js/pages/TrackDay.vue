<script setup lang="ts">

import SessionList from '@/components/SessionList.vue';
import axios from 'axios';
import { VueDatePicker } from '@vuepic/vue-datepicker';
import { nlBE } from 'date-fns/locale';
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';

interface TrackDay {
    id: number;
    start_date: Date;
    end_date: Date;
    vehicle: string;
    location: string;
    personal_best_time: string;
    sessions: Session[];
    notes: string;
    facilities: string;

}

interface Session {
    id: number;
    start_time: Date;
    end_time: Date;
    rounds: Round[];
}

interface Round {
    id: number;
    lap_time: Date;
}

const props = defineProps<{
    trackDay: TrackDay;
}>();

const datePickerFormat = {
    input: 'dd.MM.yyyy - HH:mm',
    preview: 'dd.MM.yyyy - HH:mm',
};

const start_date = ref(new Date(props.trackDay.start_date));
const end_date = ref(new Date(props.trackDay.end_date));

function updateTrackDay(trackDay: TrackDay = props.trackDay) {

    axios.post(`/api/track-day/update/${trackDay.id}`, trackDay)
        .then(response => {
            console.log(response);
        })
        .catch(error => {
            console.log(error);
        })
}
</script>

<template>
    <Link
        href="/dashboard"
    >
        <p class="bg-blue-500 rounded text-2xl text-white w-fit p-2 m-5" >Terug naar overzicht</p>
    </Link>
    <div
        class="mt-5 mb-2 bg-gray-800 border-black border-2 rounded w-2/3 mx-auto text-center text-white"
    >
        <input
            class="text-center border-gray-300 rounded"
            v-model="props.trackDay.location"
            v-on:change="updateTrackDay(props.trackDay = {...props.trackDay, location: ($event.target as HTMLInputElement).value})"
        >
    </div>

    <div
        class="grid grid-cols-2 text-white"
    >
        <div
            class="col-span-2 bg-gray-800 border-black border-2 rounded w-4/5 mx-auto text-white p-2 space-y-2"
        >
            <p class="w-fit" >Van: <VueDatePicker :formats="datePickerFormat" :locale="nlBE" v-model="start_date" @update:model-value="updateTrackDay(props.trackDay = {...props.trackDay, start_date: start_date })" /></p>
            <p class="w-fit" >Tot: <VueDatePicker :formats="datePickerFormat" :locale="nlBE" v-model="end_date" @update:model-value="updateTrackDay(props.trackDay = {...props.trackDay, end_date: end_date })" /></p>
            <p class="text-yellow-300">Voertuig: <input v-on:change="updateTrackDay(props.trackDay = {...props.trackDay, vehicle: ($event.target as HTMLInputElement).value })" :value="trackDay.vehicle" type="text" ></p>
            <p class="text-green-500" >Snelste tijd:  {{trackDay.personal_best_time}}</p>
        </div>

    </div>

    <div
        class="text-center mt-3 grid grid-cols-2 bg-gray-800 border-black border-2 rounded w-4/5 mx-auto text-white p-2 space-y-2"
    >
        <div

        >
            <p>Faciliteiten</p>
            <textarea
                class="bg-white rounded w-11/12 text-black h-52"
                v-on:input="updateTrackDay(props.trackDay = {...props.trackDay, facilities: ($event.target as HTMLInputElement).value })"
            >{{props.trackDay.facilities}}</textarea>
        </div>

        <div>
            <p>Notities</p>
            <textarea
                class="bg-white rounded w-11/12 text-black h-52"
                v-model="props.trackDay.notes"
                v-on:input="updateTrackDay(props.trackDay = {...props.trackDay, notes: ($event.target as HTMLInputElement).value })"
            >{{props.trackDay.notes}}</textarea>
        </div>
    </div>

    <session-list :track-day-id="props.trackDay.id" :sessions="props.trackDay.sessions"/>
    <div
        class="mx-auto w-1/5 mt-20 text-center"
    >
        <a
            :href="`/dashboard/delete-track-day/${props.trackDay.id}`"
            class="bg-red-500 rounded text-white text-2xl p-4 w-1/5"
        >Verwijder TrackDay</a>
    </div>

</template>

<style scoped>

</style>
