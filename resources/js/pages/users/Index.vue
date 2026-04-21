<script setup lang="ts">
import { Form, Head, Link } from '@inertiajs/vue3';
import Heading from '@/components/Heading.vue';
import { Button } from '@/components/ui/button';
import { create, destroy, edit } from '@/routes/users';

type UserRow = {
    id: number;
    username: string;
    account_type: string;
    created_on?: string | null;
    updated_on?: string | null;
};

defineProps<{
    users: UserRow[];
}>();

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Users',
                href: '/users',
            },
        ],
    },
});
</script>

<template>
    <Head title="Users" />

    <div class="space-y-6 p-4">
        <div class="flex items-center justify-between">
            <Heading
                title="Users List"
                description="Admin-only user account management."
                variant="small"
            />

            <Button as-child>
                <Link :href="create()">New user</Link>
            </Button>
        </div>

        <div class="overflow-hidden rounded-xl border border-sidebar-border/70">
            <table class="w-full text-sm">
                <thead class="bg-muted/40 text-left">
                    <tr>
                        <th class="px-4 py-3 font-semibold">Username</th>
                        <th class="px-4 py-3 font-semibold">Account Type</th>
                        <th class="px-4 py-3 font-semibold">Created</th>
                        <th class="px-4 py-3 font-semibold">Updated</th>
                        <th class="px-4 py-3 font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="user in users"
                        :key="user.id"
                        class="border-t border-sidebar-border/60"
                    >
                        <td class="px-4 py-3">{{ user.username }}</td>
                        <td class="px-4 py-3 capitalize">{{ user.account_type }}</td>
                        <td class="px-4 py-3">{{ user.created_on ?? '-' }}</td>
                        <td class="px-4 py-3">{{ user.updated_on ?? '-' }}</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <Link
                                    :href="edit(user.id)"
                                    class="font-medium text-primary underline underline-offset-4"
                                >
                                    Edit
                                </Link>
                                <Form v-bind="destroy.form(user.id)">
                                    <button
                                        type="submit"
                                        class="font-medium text-red-600 underline underline-offset-4"
                                        onclick="return confirm('Delete this user account?')"
                                    >
                                        Delete
                                    </button>
                                </Form>
                            </div>
                        </td>
                    </tr>
                    <tr v-if="users.length === 0" class="border-t border-sidebar-border/60">
                        <td class="px-4 py-6 text-center text-muted-foreground" colspan="5">
                            No users found.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
