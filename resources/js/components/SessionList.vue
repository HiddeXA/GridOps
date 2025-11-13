<script setup lang="ts">
import SessionListItem from '@/components/SessionListItem.vue';
import axios from 'axios';

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
    sessions: Session[];
    trackDayId: number;
}>();

let sessions = props.sessions;


function addSession(trackDayId: number) {
    axios.post('/api/session/create', {
        'track_day_id': trackDayId
    })
        .then(response => {
            sessions.push(response.data);
        })
        .catch(error => {
            console.log(error);
        })
}

function handleSessionDeleted(id: number) {
    sessions.forEach((x, index) => {
        if (x.id === id) {
            sessions.splice(index, 1);
        }
    })
}
</script>

<template>
    <div class="flex flex-col space-y-3">
        <h2 class="md:w-1/3 mt-5 mb-2 bg-gray-800 border-black border-2 rounded w-2/3 mx-auto text-center text-white">
            Sessies
        </h2>
        <div
            class="md:grid md:grid-cols-2 md:w-2/3 md:mx-auto space-x-1 space-y-1"
        >
            <session-list-item
                v-for="(x, index) in sessions"
                :iteration="index"
                :session="x"
                :key="x.id"
                @deleted="handleSessionDeleted"

            />
        </div>

        <button
            v-on:click="addSession(trackDayId)"
            class="bg-green-600 rounded mx-auto px-5 pb-1 w-1/5 text-white text-2xl"
        >
            +
        </button>
    </div>
</template>
