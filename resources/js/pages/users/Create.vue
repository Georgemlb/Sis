<script setup lang="ts">
import { Form, Head, Link } from '@inertiajs/vue3';
import Heading from '@/components/Heading.vue';
import InputError from '@/components/InputError.vue';
import PasswordInput from '@/components/PasswordInput.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import { index, store } from '@/routes/users';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Users',
                href: '/users',
            },
            {
                title: 'New User',
                href: '/users/create',
            },
        ],
    },
});
</script>

<template>
    <Head title="New User" />

    <div class="space-y-6 p-4">
        <Heading title="New User" description="Create a user account." variant="small" />

        <div class="max-w-2xl rounded-xl border border-sidebar-border/70 p-6">
            <Form v-bind="store.form()" class="space-y-5" v-slot="{ errors, processing }">
                <div class="grid gap-2">
                    <Label for="username">Username</Label>
                    <Input id="username" name="username" placeholder="Username" required />
                    <InputError :message="errors.username" />
                </div>

                <div class="grid gap-2">
                    <Label for="account_type">Account type</Label>
                    <Select name="account_type" default-value="student">
                        <SelectTrigger id="account_type">
                            <SelectValue placeholder="Select account type" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem value="student">Student</SelectItem>
                            <SelectItem value="teacher">Teacher</SelectItem>
                            <SelectItem value="staff">Staff</SelectItem>
                            <SelectItem value="admin">Admin</SelectItem>
                        </SelectContent>
                    </Select>
                    <InputError :message="errors.account_type" />
                </div>

                <div class="grid gap-2">
                    <Label for="password">Password</Label>
                    <PasswordInput id="password" name="password" autocomplete="new-password" placeholder="Password" required />
                    <InputError :message="errors.password" />
                </div>

                <div class="grid gap-2">
                    <Label for="password_confirmation">Confirm password</Label>
                    <PasswordInput id="password_confirmation" name="password_confirmation" autocomplete="new-password" placeholder="Confirm password" required />
                    <InputError :message="errors.password_confirmation" />
                </div>

                <div class="flex items-center gap-3">
                    <Button :disabled="processing" type="submit">Save user</Button>
                    <Button as-child variant="outline">
                        <Link :href="index()">Cancel</Link>
                    </Button>
                </div>
            </Form>
        </div>
    </div>
</template>
