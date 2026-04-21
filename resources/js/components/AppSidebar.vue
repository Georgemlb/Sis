<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { BriefcaseBusiness, GraduationCap, LayoutGrid, LibraryBig, Shield, Users } from 'lucide-vue-next';
import type { Component } from 'vue';
import { computed } from 'vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { dashboard } from '@/routes';
import { index as programs } from '@/routes/programs';
import { index as subjects } from '@/routes/subjects';
import { index as users } from '@/routes/users';
import type { NavItem } from '@/types';

const page = usePage();
const user = computed(() => page.props.auth.user);

const mainNavItems = computed<NavItem[]>(() => {
    const items: NavItem[] = [
        {
            title: 'Home',
            href: dashboard(),
            icon: LayoutGrid,
        },
        {
            title: 'Subjects',
            href: subjects(),
            icon: LibraryBig,
        },
        {
            title: 'Programs',
            href: programs(),
            icon: GraduationCap,
        },
    ];

    if (user.value?.account_type === 'admin') {
        items.push({
            title: 'Users',
            href: users(),
            icon: Users,
        });
    }

    return items;
});

const roleHeader = computed<{ title: string; icon: Component }>(() => {
    switch (user.value?.account_type) {
        case 'admin':
            return { title: 'Admin', icon: Shield };
        case 'staff':
            return { title: 'Staff', icon: BriefcaseBusiness };
        case 'teacher':
            return { title: 'Teacher', icon: GraduationCap };
        default:
            return { title: 'Student', icon: LibraryBig };
    }
});
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="dashboard()">
                            <div
                                class="flex aspect-square size-8 items-center justify-center rounded-md bg-sidebar-primary text-sidebar-primary-foreground"
                            >
                                <component :is="roleHeader.icon" class="size-5" />
                            </div>
                            <div class="ml-1 grid flex-1 text-left text-sm">
                                <span class="mb-0.5 truncate leading-tight font-semibold">{{ roleHeader.title }}</span>
                            </div>
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
