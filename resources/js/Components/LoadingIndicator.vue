<script setup>
defineProps({
    message: {
        type: String,
        default: 'Loading...'
    }
})
</script>

<template>
    <div class="mt-8 flow-root">
        <div class="flex items-center justify-center py-10">
            <div class="animate-spin rounded-full h-10 w-10 border-b-2 border-indigo-500"></div>
            <span class="ml-3 text-gray-600">{{ message }}</span>
        </div>
    </div>
</template>
