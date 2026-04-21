<script setup lang="ts">
import { Form, Head, Link } from '@inertiajs/vue3';
import Heading from '@/components/Heading.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { index, store } from '@/routes/programs';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Programs',
                href: '/programs',
            },
            {
                title: 'New Program',
                href: '/programs/create',
            },
        ],
    },
});
</script>

<template>
    <Head title="New Program" />

    <div class="space-y-6 p-4 md:p-6">
        <div
            class="relative overflow-hidden rounded-2xl border border-sidebar-border/70 bg-linear-to-r from-slate-50 via-sky-50 to-cyan-50 p-5 shadow-sm dark:from-slate-950/60 dark:via-slate-900/80 dark:to-cyan-950/30"
        >
            <div class="absolute -right-12 -top-12 h-40 w-40 rounded-full bg-sky-500/10 blur-2xl" />
            <div class="absolute -bottom-16 left-20 h-40 w-40 rounded-full bg-cyan-500/10 blur-2xl" />

            <div class="relative">
                <Heading title="New Program" description="Create a new program record." variant="small" />
            </div>
        </div>

        <div class="max-w-2xl rounded-2xl border border-sidebar-border/70 bg-background p-6 shadow-sm">
            <Form v-bind="store.form()" class="space-y-5" v-slot="{ errors, processing }">
                <div class="grid gap-2">
                    <Label for="code">Code</Label>
                    <Input id="code" name="code" placeholder="e.g. BSIT" required />
                    <InputError :message="errors.code" />
                </div>

                <div class="grid gap-2">
                    <Label for="title">Title</Label>
                    <Input id="title" name="title" placeholder="Program title" required />
                    <InputError :message="errors.title" />
                </div>

                <div class="grid gap-2">
                    <Label for="years">Years</Label>
                    <Input id="years" type="number" min="1" name="years" placeholder="4" required />
                    <InputError :message="errors.years" />
                </div>

                <div class="flex items-center justify-end gap-3">
                    <Button :disabled="processing" type="submit">Save program</Button>
                    <Button as-child variant="outline">
                        <Link :href="index()">Cancel</Link>
                    </Button>
                </div>
            </Form>
        </div>
    </div>
</template>
