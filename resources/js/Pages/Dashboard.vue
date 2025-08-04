<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import StatisticsWidget from '@/Components/StatisticsWidget.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    statistics: {
        type: Object,
        required: true
    }
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="min-h-full">
            <main class="mt-32">
                <div class="mx-auto max-w-7xl px-4 pb-12 sm:px-6 lg:px-8">
                    <div class="rounded-lg bg-white px-5 py-6 shadow-sm sm:px-6">
                        <StatisticsWidget :statistics="statistics" />
                    </div>
                </div>
            </main>
        </div>
    </AuthenticatedLayout>
</template>
