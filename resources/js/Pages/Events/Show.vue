<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    event: Object
});
</script>

<template>
    <Head title="View Event" />

    <AuthenticatedLayout>
        <div class="max-w-4xl mx-auto mt-10 bg-white shadow rounded-lg p-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">
                Event Details
            </h1>

            <!-- Title -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Title</label>
                <p class="mt-1 text-gray-900">{{ event.data.title }}</p>
            </div>

            <!-- Description -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Description</label>
                <p class="mt-1 text-gray-900">{{ event.data.description }}</p>
            </div>

            <!-- Event Date -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Event Date</label>
                <p class="mt-1 text-gray-900">{{ event.data.event_date }}</p>
            </div>

            <!-- Location -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Location</label>
                <p class="mt-1 text-gray-900">{{ event.data.location }}</p>
            </div>

            <!-- Capacity -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Capacity</label>
                <p class="mt-1 text-gray-900">{{ event.data.capacity }}</p>
            </div>

            <!-- Status -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Status</label>
                <span
                    class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full"
                    :class="{
                        'bg-green-100 text-green-800': event.data.status.value === 'published',
                        'bg-yellow-100 text-yellow-800': event.data.status.value === 'draft',
                        'bg-red-100 text-red-800': event.data.status.value === 'cancelled'
                    }">
                    {{ event.data.status.label }}
                </span>
            </div>

            <!-- Current Registrations Count -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Current Registrations</label>
                <p class="mt-1 text-gray-900">{{ event.data.current_registrations_count }}</p>
            </div>

            <!-- Back Button -->
            <div class="mt-6">
                <a
                    :href="route('admin.events.index')"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded hover:bg-indigo-700">
                    Back to Events
                </a>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
