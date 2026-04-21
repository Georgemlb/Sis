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

    <div class="space-y-6 p-4">
        <div class="flex items-center justify-between">
            <Heading
                title="Program List"
                description="View all program records."
                variant="small"
            />

            <Button v-if="canEditCatalog" as-child>
                <Link :href="create()">New program</Link>
            </Button>
        </div>

        <div class="overflow-hidden rounded-xl border border-sidebar-border/70">
            <table class="w-full text-sm">
                <thead class="bg-muted/40 text-left">
                    <tr>
                        <th class="px-4 py-3 font-semibold">Code</th>
                        <th class="px-4 py-3 font-semibold">Title</th>
                        <th class="px-4 py-3 font-semibold">Years</th>
                        <th class="px-4 py-3 font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="program in programs"
                        :key="program.program_id"
                        class="border-t border-sidebar-border/60"
                    >
                        <td class="px-4 py-3">{{ program.code }}</td>
                        <td class="px-4 py-3">{{ program.title }}</td>
                        <td class="px-4 py-3">{{ program.years }}</td>
                        <td class="px-4 py-3">
                            <Link
                                v-if="canEditCatalog"
                                :href="edit(program.program_id)"
                                class="font-medium text-primary underline underline-offset-4"
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
</template>
