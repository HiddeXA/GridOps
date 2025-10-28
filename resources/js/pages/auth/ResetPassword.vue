<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthLayout from '@/layouts/AuthLayout.vue';
import { store } from '@/routes/password';
import { Form, Head } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';

defineProps<{
    email: string;
    token: string;
}>();
</script>

<template>
    <AuthLayout
        title="Wachtwoord herstellen"
        description="Voer je nieuwe wachtwoord in"
    >
        <Head title="Wachtwoord herstellen" />

        <Form
            v-bind="store.form()"
            v-slot="{ errors, processing }"
            class="space-y-6 text-white"
        >
            <div class="grid gap-2">
                <Label for="email">E-mailadres</Label>
                <Input
                    id="email"
                    type="email"
                    name="email"
                    :value="email"
                    readonly
                    disabled
                />
                <InputError :message="errors.email" />
            </div>

            <div class="grid gap-2">
                <Label for="password">Nieuw wachtwoord</Label>
                <Input
                    id="password"
                    type="password"
                    name="password"
                    required
                    autofocus
                    autocomplete="new-password"
                    placeholder="Nieuw wachtwoord"
                />
                <InputError :message="errors.password" />
            </div>

            <div class="grid gap-2">
                <Label for="password_confirmation">Bevestig wachtwoord</Label>
                <Input
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                    placeholder="Bevestig wachtwoord"
                />
                <InputError :message="errors.password_confirmation" />
            </div>

            <Input type="hidden" name="token" :value="token" />

            <Button
                type="submit"
                class="w-full"
                :disabled="processing"
                data-test="reset-password-button"
            >
                <LoaderCircle
                    v-if="processing"
                    class="h-4 w-4 animate-spin"
                />
                Wachtwoord herstellen
            </Button>
        </Form>
    </AuthLayout>
</template>
