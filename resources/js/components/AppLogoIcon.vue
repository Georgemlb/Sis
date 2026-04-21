<script setup lang="ts">
import type { HTMLAttributes } from 'vue';
import graduateLogo from '@/assets/graduate.png';

defineOptions({
    inheritAttrs: false,
});

type Props = {
    className?: HTMLAttributes['class'];
};

defineProps<Props>();
</script>

<template>
    <img
        :src="graduateLogo"
        alt="App logo"
        :class="className"
        v-bind="$attrs"
    />
</template>
