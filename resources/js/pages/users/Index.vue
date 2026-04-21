<script setup lang="ts">
import { Form, Head, Link } from '@inertiajs/vue3';
import Heading from '@/components/Heading.vue';
import { Button } from '@/components/ui/button';
import { Badge } from '@/components/ui/badge';
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

    <div class="space-y-6 p-4 md:p-6">
        <div
            class="relative overflow-hidden rounded-2xl border border-sidebar-border/70 bg-linear-to-r from-slate-50 via-sky-50 to-cyan-50 p-5 shadow-sm dark:from-slate-950/60 dark:via-slate-900/80 dark:to-cyan-950/30"
        >
            <div class="absolute -right-12 -top-12 h-40 w-40 rounded-full bg-sky-500/10 blur-2xl" />
            <div class="absolute -bottom-16 left-20 h-40 w-40 rounded-full bg-cyan-500/10 blur-2xl" />

            <div class="relative flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <Heading
                title="Users List"
                description="Admin-only user account management."
                variant="small"
            />

                <Button as-child class="w-full md:w-auto">
                    <Link :href="create()">New user</Link>
                </Button>
            </div>
        </div>

        <div class="overflow-hidden rounded-2xl border border-sidebar-border/70 bg-background shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full min-w-190 text-sm">
                <thead class="bg-muted/60 text-left text-xs uppercase tracking-wide text-muted-foreground">
                    <tr>
                        <th class="px-4 py-3 font-semibold">Username</th>
                        <th class="px-4 py-3 font-semibold">Account Type</th>
                        <th class="px-4 py-3 font-semibold">Created</th>
                        <th class="px-4 py-3 font-semibold">Updated</th>
                        <th class="px-4 py-3 text-right font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="user in users"
                        :key="user.id"
                        class="border-t border-sidebar-border/60 transition-colors hover:bg-muted/30"
                    >
                        <td class="px-4 py-3.5 font-medium text-foreground">{{ user.username }}</td>
                        <td class="px-4 py-3.5">
                            <Badge variant="outline" class="capitalize">{{ user.account_type }}</Badge>
                        </td>
                        <td class="px-4 py-3.5 font-mono text-xs text-muted-foreground">{{ user.created_on ?? '-' }}</td>
                        <td class="px-4 py-3.5 font-mono text-xs text-muted-foreground">{{ user.updated_on ?? '-' }}</td>
                        <td class="px-4 py-3.5">
                            <div class="flex items-center justify-end gap-4">
                                <Link
                                    :href="edit(user.id)"
                                    class="font-medium text-primary transition-colors hover:text-primary/80"
                                >
                                    Edit
                                </Link>
                                <Form v-bind="destroy.form(user.id)">
                                    <button
                                        type="submit"
                                        class="font-medium text-red-600 transition-colors hover:text-red-500"
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
    </div>
</template>
