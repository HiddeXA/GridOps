<script setup lang="ts">
    const props = defineProps({
        eventLocation: String,
        eventDate: {
            required: true,
            type: Date,
        },
        personalBestTime: String,
    })

    const daysUntil = Math.floor(Math.abs(new Date().getTime() - props.eventDate.getTime())/ (1000 * 3600 * 24));
</script>

<template>
    <div
        class="grid grid-cols-2 bg-stone-900 border-2 border-blue-500 rounded p-3 "
    >
        <h2
            class="text-2xl col-span-2 md:col-span-1"
        >{{props.eventLocation}}</h2>
        <p
            class="col-span-2 md:col-span-1"
        >Datum: {{props.eventDate?.getDate() }} / {{props.eventDate?.getMonth() }} / {{props.eventDate?.getFullYear() }}</p>
        <p
            class="text-yellow-300 col-span-1"
        >nog {{daysUntil}} dagen</p>
        <p
            class="text-green-500 text-end"
        >PB: {{props.personalBestTime??'00:00:000'}}</p>
    </div>
</template>

<style scoped>

</style>
