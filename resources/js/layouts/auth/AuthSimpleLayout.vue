<script setup lang="ts">
import AppLogoIcon from '@/components/AppLogoIcon.vue';

defineProps<{
    title?: string;
    description?: string;
}>();
</script>

<template>
    <div class="flex min-h-svh bg-background">
        <!-- Left branding panel -->
        <div
            class="hidden lg:flex lg:w-[45%] xl:w-2/5 flex-col justify-between bg-foreground p-10 text-background dark:bg-card dark:text-card-foreground"
        >
            <div class="flex items-center gap-3">
                <AppLogoIcon class="size-8 opacity-90" />
                <span class="text-sm font-semibold tracking-wide uppercase opacity-80">
                    Academic Registry
                </span>
            </div>

            <div class="space-y-4">
                <blockquote class="text-2xl font-light leading-relaxed opacity-90">
                    "Manage academic programs, subjects, and user accounts in one place."
                </blockquote>
                <p class="text-sm opacity-50">Student Information System</p>
            </div>

            <p class="text-xs opacity-40">
                &copy; {{ new Date().getFullYear() }} All rights reserved.
            </p>
        </div>

        <!-- Right form panel -->
        <div class="flex flex-1 flex-col items-center justify-center px-6 py-12 lg:px-12">
            <!-- Mobile logo -->
            <div class="mb-8 flex flex-col items-center gap-3 lg:hidden">
                <AppLogoIcon class="size-10" />
                <span class="text-xs font-semibold tracking-widest uppercase text-muted-foreground">
                    Academic Registry
                </span>
            </div>

            <div class="w-full max-w-sm">
                <div class="mb-8 space-y-1">
                    <h1 class="text-2xl font-semibold tracking-tight text-foreground">
                        {{ title }}
                    </h1>
                    <p class="text-sm text-muted-foreground">
                        {{ description }}
                    </p>
                </div>

                <slot />
            </div>
        </div>
    </div>
</template>
