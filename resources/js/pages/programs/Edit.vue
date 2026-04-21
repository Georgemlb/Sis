<script setup lang="ts">
import { Form, Head, Link } from '@inertiajs/vue3';
import Heading from '@/components/Heading.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { index, update } from '@/routes/programs';

type Program = {
    program_id: number;
    code: string;
    title: string;
    years: number;
};

defineProps<{
    program: Program;
}>();

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Programs',
                href: '/programs',
            },
            {
                title: 'Edit Program',
                href: '#',
            },
        ],
    },
});
</script>

<template>
    <Head title="Edit Program" />

    <div class="space-y-6 p-4">
        <Heading title="Edit Program" description="Update program details." variant="small" />

        <div class="max-w-2xl rounded-xl border border-sidebar-border/70 p-6">
            <Form
                v-bind="update.form(program.program_id)"
                class="space-y-5"
                v-slot="{ errors, processing }"
            >
                <div class="grid gap-2">
                    <Label for="code">Code</Label>
                    <Input id="code" name="code" :default-value="program.code" required />
                    <InputError :message="errors.code" />
                </div>

                <div class="grid gap-2">
                    <Label for="title">Title</Label>
                    <Input id="title" name="title" :default-value="program.title" required />
                    <InputError :message="errors.title" />
                </div>

                <div class="grid gap-2">
                    <Label for="years">Years</Label>
                    <Input id="years" type="number" min="1" name="years" :default-value="program.years" required />
                    <InputError :message="errors.years" />
                </div>

                <div class="flex items-center gap-3">
                    <Button :disabled="processing" type="submit">Update program</Button>
                    <Button as-child variant="outline">
                        <Link :href="index()">Cancel</Link>
                    </Button>
                </div>
            </Form>
        </div>
    </div>
</template>
