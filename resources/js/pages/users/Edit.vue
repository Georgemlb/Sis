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
import { index, update } from '@/routes/users';

type UserRecord = {
    id: number;
    username: string;
    account_type: string;
};

defineProps<{
    user: UserRecord;
}>();

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Users',
                href: '/users',
            },
            {
                title: 'Edit User',
                href: '#',
            },
        ],
    },
});
</script>

<template>
    <Head title="Edit User" />

    <div class="space-y-6 p-4">
        <Heading title="Edit User" description="Update user account details." variant="small" />

        <div class="max-w-2xl rounded-xl border border-sidebar-border/70 p-6">
            <Form
                v-bind="update.form(user.id)"
                class="space-y-5"
                v-slot="{ errors, processing }"
            >
                <div class="grid gap-2">
                    <Label for="username">Username</Label>
                    <Input id="username" name="username" :default-value="user.username" required />
                    <InputError :message="errors.username" />
                </div>

                <div class="grid gap-2">
                    <Label for="account_type">Account type</Label>
                    <Select name="account_type" :default-value="user.account_type">
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
                    <Label for="password">New password (optional)</Label>
                    <PasswordInput id="password" name="password" autocomplete="new-password" placeholder="Leave blank to keep current password" />
                    <InputError :message="errors.password" />
                </div>

                <div class="grid gap-2">
                    <Label for="password_confirmation">Confirm new password</Label>
                    <PasswordInput id="password_confirmation" name="password_confirmation" autocomplete="new-password" placeholder="Confirm new password" />
                    <InputError :message="errors.password_confirmation" />
                </div>

                <div class="flex items-center gap-3">
                    <Button :disabled="processing" type="submit">Update user</Button>
                    <Button as-child variant="outline">
                        <Link :href="index()">Cancel</Link>
                    </Button>
                </div>
            </Form>
        </div>
    </div>
</template>
