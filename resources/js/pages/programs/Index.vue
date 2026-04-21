<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import Heading from '@/components/Heading.vue';
import { Button } from '@/components/ui/button';
import { create, edit } from '@/routes/programs';

type Program = {
    program_id: number;
    code: string;
    title: string;
    years: number;
};

defineProps<{
    programs: Program[];
    canEditCatalog: boolean;
}>();

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Programs',
                href: '/programs',
            },
        ],
    },
});
</script>

<template>
    <Head title="Programs" />

    <div class="space-y-6 p-4 md:p-6">
        <div
            class="relative overflow-hidden rounded-2xl border border-sidebar-border/70 bg-linear-to-r from-slate-50 via-sky-50 to-cyan-50 p-5 shadow-sm dark:from-slate-950/60 dark:via-slate-900/80 dark:to-cyan-950/30"
        >
            <div class="absolute -right-12 -top-12 h-40 w-40 rounded-full bg-sky-500/10 blur-2xl" />
            <div class="absolute -bottom-16 left-20 h-40 w-40 rounded-full bg-cyan-500/10 blur-2xl" />

            <div class="relative flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <Heading
                    title="Program List"
                    description="View all program records."
                    variant="small"
                />

                <Button v-if="canEditCatalog" as-child class="w-full md:w-auto">
                    <Link :href="create()">New program</Link>
                </Button>
            </div>
        </div>

        <div class="overflow-hidden rounded-2xl border border-sidebar-border/70 bg-background shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-muted/60 text-left text-xs uppercase tracking-wide text-muted-foreground">
                        <tr>
                            <th class="px-4 py-3 font-semibold">Code</th>
                            <th class="px-4 py-3 font-semibold">Title</th>
                            <th class="px-4 py-3 font-semibold">Years</th>
                            <th class="px-4 py-3 text-right font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="program in programs"
                            :key="program.program_id"
                            class="border-t border-sidebar-border/60 transition-colors hover:bg-muted/30"
                        >
                            <td class="px-4 py-3.5 font-medium text-foreground">{{ program.code }}</td>
                            <td class="px-4 py-3.5">{{ program.title }}</td>
                            <td class="px-4 py-3.5 font-mono text-xs text-muted-foreground">{{ program.years }}</td>
                            <td class="px-4 py-3.5 text-right">
                                <Link
                                    v-if="canEditCatalog"
                                    :href="edit(program.program_id)"
                                    class="font-medium text-primary transition-colors hover:text-primary/80"
                                >
                                    Edit
                                </Link>
                                <span v-else class="text-muted-foreground">View only</span>
                            </td>
                        </tr>
                        <tr v-if="programs.length === 0" class="border-t border-sidebar-border/60">
                            <td class="px-4 py-6 text-center text-muted-foreground" colspan="4">
                                No programs found.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
