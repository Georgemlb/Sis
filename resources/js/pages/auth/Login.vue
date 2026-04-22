<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import PasswordInput from '@/components/PasswordInput.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { store } from '@/routes/login';

defineOptions({
    layout: {
        title: 'Sign in to your account',
        description: 'Enter your credentials to access the system',
    },
});

defineProps<{
    status?: string;
    canResetPassword: boolean;
    canRegister: boolean;
}>();
</script>

<template>
    <Head title="Sign In" />

    <div
        v-if="status"
        class="mb-4 rounded-md bg-green-50 px-4 py-3 text-center text-sm font-medium text-green-700 dark:bg-green-950/30 dark:text-green-400"
    >
        {{ status }}
    </div>

    <Form
        v-bind="store.form()"
        :reset-on-success="['password']"
        v-slot="{ errors, processing }"
        class="flex flex-col gap-5"
    >
        <div class="grid gap-5">
            <div class="grid gap-1.5">
                <Label for="username" class="text-sm font-medium">Username</Label>
                <Input
                    id="username"
                    type="text"
                    name="username"
                    required
                    autofocus
                    :tabindex="1"
                    autocomplete="username"
                    placeholder="Enter your username"
                    class="h-10"
                />
                <InputError :message="errors.username" />
            </div>

            <div class="grid gap-1.5">
                <Label for="password" class="text-sm font-medium">Password</Label>
                <PasswordInput
                    id="password"
                    name="password"
                    required
                    :tabindex="2"
                    autocomplete="current-password"
                    placeholder="Enter your password"
                    class="h-10"
                />
                <InputError :message="errors.password" />
            </div>

            <Button
                type="submit"
                class="mt-1 h-10 w-full font-semibold"
                :tabindex="3"
                :disabled="processing"
                data-test="login-button"
            >
                <Spinner v-if="processing" class="mr-2" />
                {{ processing ? 'Signing in…' : 'Sign in' }}
            </Button>
        </div>
    </Form>
</template>
