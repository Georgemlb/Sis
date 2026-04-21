<script setup lang="ts">
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed, onBeforeUnmount, onMounted } from 'vue';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { dashboard } from '@/routes';
import { index as programs } from '@/routes/programs';
import { edit as editSecurity } from '@/routes/security';
import { index as subjects } from '@/routes/subjects';
import { index as users } from '@/routes/users';

type Props = {
    canManageUsers: boolean;
    canEditCatalog: boolean;
};

const props = defineProps<Props>();

const page = usePage();
const user = computed(() => page.props.auth.user);

const preventBackNavigation = (): void => {
    if (typeof window === 'undefined') {
        return;
    }

    window.history.pushState(null, '', window.location.href);

    const handlePopState = (): void => {
        window.history.pushState(null, '', window.location.href);
    };

    window.addEventListener('popstate', handlePopState);

    onBeforeUnmount(() => {
        window.removeEventListener('popstate', handlePopState);
    });
};

onMounted(() => {
    preventBackNavigation();
});

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Dashboard',
                href: dashboard(),
            },
        ],
    },
});
</script>

<template>
    <Head title="Home" />

    <div class="space-y-6 p-4 md:p-6">
        <Card class="border-sidebar-border/70 shadow-sm">
            <CardHeader>
                <CardTitle>Welcome back</CardTitle>
                <CardDescription>
                    You are logged in as <strong>{{ user.username }}</strong> ({{ user.account_type }}).
                </CardDescription>
            </CardHeader>
        </Card>

        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            <Card class="border-sidebar-border/70 shadow-sm transition-colors hover:bg-muted/20">
                <CardHeader>
                    <CardTitle>Subject Management</CardTitle>
                    <CardDescription>View the subject list and manage records based on your role.</CardDescription>
                </CardHeader>
                <CardContent>
                    <Link :href="subjects()" class="text-sm font-medium text-primary transition-colors hover:text-primary/80">Open subject list</Link>
                </CardContent>
            </Card>

            <Card class="border-sidebar-border/70 shadow-sm transition-colors hover:bg-muted/20">
                <CardHeader>
                    <CardTitle>Program Management</CardTitle>
                    <CardDescription>View the program list and update records if you are authorized.</CardDescription>
                </CardHeader>
                <CardContent>
                    <Link :href="programs()" class="text-sm font-medium text-primary transition-colors hover:text-primary/80">Open program list</Link>
                </CardContent>
            </Card>

            <Card v-if="props.canManageUsers" class="border-sidebar-border/70 shadow-sm transition-colors hover:bg-muted/20">
                <CardHeader>
                    <CardTitle>User Management</CardTitle>
                    <CardDescription>Admin-only user account management.</CardDescription>
                </CardHeader>
                <CardContent>
                    <Link :href="users()" class="text-sm font-medium text-primary transition-colors hover:text-primary/80">Open users list</Link>
                </CardContent>
            </Card>

            <Card class="border-sidebar-border/70 shadow-sm transition-colors hover:bg-muted/20">
                <CardHeader>
                    <CardTitle>Change Password</CardTitle>
                    <CardDescription>Update your own account password securely.</CardDescription>
                </CardHeader>
                <CardContent>
                    <Link :href="editSecurity()" class="text-sm font-medium text-primary transition-colors hover:text-primary/80">Go to security settings</Link>
                </CardContent>
            </Card>
        </div>
    </div>
</template>
