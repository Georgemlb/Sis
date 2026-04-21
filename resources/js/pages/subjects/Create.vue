<script setup lang="ts">
import { Form, Head, Link } from '@inertiajs/vue3';
import Heading from '@/components/Heading.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { index, store } from '@/routes/subjects';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Subjects',
                href: '/subjects',
            },
            {
                title: 'New Subject',
                href: '/subjects/create',
            },
        ],
    },
});
</script>

<template>
    <Head title="New Subject" />

    <div class="space-y-6 p-4">
        <Heading title="New Subject" description="Create a new subject record." variant="small" />

        <div class="max-w-2xl rounded-xl border border-sidebar-border/70 p-6">
            <Form v-bind="store.form()" class="space-y-5" v-slot="{ errors, processing }">
                <div class="grid gap-2">
                    <Label for="code">Code</Label>
                    <Input id="code" name="code" placeholder="e.g. IT101" required />
                    <InputError :message="errors.code" />
                </div>

                <div class="grid gap-2">
                    <Label for="title">Title</Label>
                    <Input id="title" name="title" placeholder="Subject title" required />
                    <InputError :message="errors.title" />
                </div>

                <div class="grid gap-2">
                    <Label for="unit">Unit</Label>
                    <Input id="unit" type="number" min="1" step="0.5" name="unit" placeholder="3" required />
                    <InputError :message="errors.unit" />
                </div>

                <div class="flex items-center gap-3">
                    <Button :disabled="processing" type="submit">Save subject</Button>
                    <Button as-child variant="outline">
                        <Link :href="index()">Cancel</Link>
                    </Button>
                </div>
            </Form>
        </div>
    </div>
</template>
