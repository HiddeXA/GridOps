<script setup lang="ts">

import axios from 'axios';

const emit = defineEmits<{
    deleted: [id: number],

}>();

const props = defineProps<{
    iteration: number;
    session: Session;
}>()
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

const lapTimeFormater = new Intl.DateTimeFormat('us-US', {
    minute: '2-digit',
    second: '2-digit',
    fractionalSecondDigits: 3
});

function deleteSession(id: number) {
  axios.delete(`/api/session/delete/${id}`)
      .then(response => {
          emit('deleted', id);
      })
}

function updateRoundTime(id: number, input: string) {
    console.log(input);
    axios.put(`/api/round/update/${id}`, {
        lap_time: input
    })
}

function deleteRound(id: number) {
    axios.delete(`/api/round/delete/${id}`)
        .then(response => {
            props.session.rounds.forEach((x, index) => {
                if (x.id === id) {
                    props.session.rounds.splice(index, 1);
                }
            })
    })
}

function addRound(input: HTMLInputElement) {
    axios.post('/api/round/create', {
        'session_id': props.session.id,
        'lap_time': input.value
    }).then(response => {
        if (props.session.rounds == null) props.session.rounds = [];

        props.session.rounds.push(response.data);
        input.value = '';
    })

}
</script>

<template>
    <div :key="props.session.id"
        class="bg-gray-800 rounded border-2 border-black text-white p-4"
    >
        <div class="border-b border-black flex-row flex justify-between">
            <h2
                class="text-xl mb-2 pb-2"
            >Sessie {{props.iteration + 1}}</h2>
            <button v-on:click="deleteSession(props.session.id)" class="bg-red-500 rounded w-1/12 h-1/12 ">X</button>
        </div>

        <div v-for="x in props.session.rounds" :key="x.id"
            class="text-2xl"
        >
            <input
                type="text"
                pattern="[0-9]{2}:[0-9]{2}:[0-9]{3}"
                placeholder="00:00:000"
                maxlength="9"
                :value="lapTimeFormater.format(new Date(x.lap_time))"

                v-on:change="updateRoundTime(x.id, ($event.target as HTMLInputElement).value)"
            >
            <button v-on:click="deleteRound(x.id)" class="bg-red-500 rounded text-xl px-3" >X</button>
        </div>
        <input
            type="text"
            pattern="[0-9]{2}:[0-9]{2}:[0-9]{3}"
            placeholder="00:00.000"
            maxlength="9"

            v-on:change="addRound(($event.target as HTMLInputElement))"
        >
    </div>
</template>

<style scoped>

</style>
