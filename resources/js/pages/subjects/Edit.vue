<script setup lang="ts">
import { Form, Head, Link } from '@inertiajs/vue3';
import Heading from '@/components/Heading.vue';
import InputError from '@/components/InputError.vue';
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
import { index, update } from '@/routes/subjects';

type ProgramOption = {
    program_id: number;
    title: string;
};

type Subject = {
    subject_id: number;
    code: string;
    title: string;
    unit: number;
    program: number;
};

defineProps<{
    subject: Subject;
    programs: ProgramOption[];
}>();

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Subjects',
                href: '/subjects',
            },
            {
                title: 'Edit Subject',
                href: '#',
            },
        ],
    },
});
</script>

<template>
    <Head title="Edit Subject" />

    <div class="space-y-6 p-4">
        <Heading title="Edit Subject" description="Update subject details." variant="small" />

        <div class="max-w-2xl rounded-xl border border-sidebar-border/70 p-6">
            <Form
                v-bind="update.form(subject.subject_id)"
                class="space-y-5"
                v-slot="{ errors, processing }"
            >
                <div class="grid gap-2">
                    <Label for="code">Code</Label>
                    <Input id="code" name="code" :default-value="subject.code" required />
                    <InputError :message="errors.code" />
                </div>

                <div class="grid gap-2">
                    <Label for="title">Title</Label>
                    <Input id="title" name="title" :default-value="subject.title" required />
                    <InputError :message="errors.title" />
                </div>

                <div class="grid gap-2">
                    <Label for="unit">Unit</Label>
                    <Input id="unit" type="number" min="1" step="0.5" name="unit" :default-value="subject.unit" required />
                    <InputError :message="errors.unit" />
                </div>

                <div class="grid gap-2">
                    <Label for="program">Program</Label>
                    <Select name="program" :default-value="String(subject.program)">
                        <SelectTrigger id="program">
                            <SelectValue placeholder="Select a program" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem
                                v-for="program in programs"
                                :key="program.program_id"
                                :value="String(program.program_id)"
                            >
                                {{ program.title }}
                            </SelectItem>
                        </SelectContent>
                    </Select>
                    <InputError :message="errors.program" />
                </div>

                <div class="flex items-center gap-3">
                    <Button :disabled="processing" type="submit">Update subject</Button>
                    <Button as-child variant="outline">
                        <Link :href="index()">Cancel</Link>
                    </Button>
                </div>
            </Form>
        </div>
    </div>
</template>
