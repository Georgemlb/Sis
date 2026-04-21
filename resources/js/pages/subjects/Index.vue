<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import Heading from '@/components/Heading.vue';
import { Button } from '@/components/ui/button';
import { create, edit } from '@/routes/subjects';

type Subject = {
    subject_id: number;
    code: string;
    title: string;
    unit: number;
    programDetails?: {
        program_id: number;
        title: string;
    };
};

defineProps<{
    subjects: Subject[];
    canEditCatalog: boolean;
}>();

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Subjects',
                href: '/subjects',
            },
        ],
    },
});
</script>

<template>
    <Head title="Subjects" />

    <div class="space-y-6 p-4">
        <div class="flex items-center justify-between">
            <Heading
                title="Subject List"
                description="View all subject records."
                variant="small"
            />

            <Button v-if="canEditCatalog" as-child>
                <Link :href="create()">New subject</Link>
            </Button>
        </div>

        <div class="overflow-hidden rounded-xl border border-sidebar-border/70">
            <table class="w-full text-sm">
                <thead class="bg-muted/40 text-left">
                    <tr>
                        <th class="px-4 py-3 font-semibold">Code</th>
                        <th class="px-4 py-3 font-semibold">Title</th>
                        <th class="px-4 py-3 font-semibold">Unit</th>
                        <th class="px-4 py-3 font-semibold">Program</th>
                        <th class="px-4 py-3 font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="subject in subjects"
                        :key="subject.subject_id"
                        class="border-t border-sidebar-border/60"
                    >
                        <td class="px-4 py-3">{{ subject.code }}</td>
                        <td class="px-4 py-3">{{ subject.title }}</td>
                        <td class="px-4 py-3">{{ subject.unit }}</td>
                        <td class="px-4 py-3">{{ subject.programDetails?.title ?? '-' }}</td>
                        <td class="px-4 py-3">
                            <Link
                                v-if="canEditCatalog"
                                :href="edit(subject.subject_id)"
                                class="font-medium text-primary underline underline-offset-4"
                            >
                                Edit
                            </Link>
                            <span v-else class="text-muted-foreground">View only</span>
                        </td>
                    </tr>
                    <tr v-if="subjects.length === 0" class="border-t border-sidebar-border/60">
                        <td class="px-4 py-6 text-center text-muted-foreground" colspan="5">
                            No subjects found.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
