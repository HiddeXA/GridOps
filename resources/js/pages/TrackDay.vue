<script setup lang="ts">

import SessionList from '@/components/SessionList.vue';
import axios from 'axios';

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

function updateTrackDay(trackDay: TrackDay) {

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
    <div
        class="mt-5 mb-2 bg-gray-800 border-black border-2 rounded w-2/3 mx-auto text-center text-white"
    >
        <input
            class="text-center"
            :value="props.trackDay.location"
            v-on:change="updateTrackDay(props.trackDay = {...props.trackDay, location: ($event.target as HTMLInputElement).value})"
        >
    </div>

    <div
        class="grid grid-cols-2 text-white"
    >
        <div
            class="col-span-2 bg-gray-800 border-black border-2 rounded w-4/5 mx-auto text-white p-2 space-y-2"
        >
            <p>Van: <input v-on:change="updateTrackDay(props.trackDay = {...props.trackDay, start_date: ($event.target as HTMLInputElement).value })" :value="trackDay.start_date"  type="datetime-local"></p>
            <p>Tot: <input v-on:change="updateTrackDay(props.trackDay = {...props.trackDay, end_date: ($event.target as HTMLInputElement).value })" :value="trackDay.end_date"  type="datetime-local"></p>
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
</template>

<style scoped>

</style>
