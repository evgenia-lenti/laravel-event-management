<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link, useForm} from '@inertiajs/vue3';

const props = defineProps({
    event: Object,
    statuses: Array,
});

const form = useForm({
    title: props.event?.data.title || '',
    description: props.event?.data.description || '',
    event_date: props.event?.data.eventDate || '',
    location: props.event?.data.location || '',
    capacity: props.event?.data.capacity || '',
    status: props.event?.data.status?.value || props.statuses[0]?.value || ''
});

const submit = () => {
    if (props.event) {
        form.put(route('admin.events.update', props.event.data.id));
    } else {
        form.post(route('admin.events.store'));
    }
};
</script>

<template>
    <Head :title="props.event ? 'Edit Event' : 'Create Event'" />

    <AuthenticatedLayout>
        <div class="max-w-3xl mx-auto py-8">
            <h1 class="text-2xl font-semibold text-gray-800 mb-6">
                {{ props.event ? 'Edit Event' : 'Create Event' }}
            </h1>

            <form @submit.prevent="submit" class="space-y-6 bg-white p-6 shadow rounded-lg">
                <!-- Title -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Title</label>
                    <input v-model="form.title" type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                    <div v-if="form.errors.title" class="text-red-500 text-sm">{{ form.errors.title }}</div>
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea v-model="form.description" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                    <div v-if="form.errors.description" class="text-red-500 text-sm">{{ form.errors.description }}</div>
                </div>

                <!-- Event Date -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Event Date</label>
                    <input v-model="form.event_date" type="datetime-local" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                    <div v-if="form.errors.event_date" class="text-red-500 text-sm">{{ form.errors.event_date }}</div>
                </div>

                <!-- Location -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Location</label>
                    <input v-model="form.location" type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                    <div v-if="form.errors.location" class="text-red-500 text-sm">{{ form.errors.location }}</div>
                </div>

                <!-- Capacity -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Capacity</label>
                    <input v-model="form.capacity" type="number" min="1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                    <div v-if="form.errors.capacity" class="text-red-500 text-sm">{{ form.errors.capacity }}</div>
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Status</label>
                    <select v-model="form.status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option v-for="status in props.statuses.data" :key="status.value" :value="status.value">
                            {{ status.label }}
                        </option>
                    </select>
                    <div v-if="form.errors.status" class="text-red-500 text-sm">{{ form.errors.status }}</div>
                </div>

                <!-- Submit -->
                <div class="flex justify-end space-x-4">
                    <!-- Cancel Button -->
                    <Link
                        :href="route('admin.events.index')"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded hover:bg-gray-300">
                        Cancel
                    </Link>

                    <!-- Submit Button -->
                    <button type="submit" class="px-4 py-2 bg-indigo-500 text-gray-50 rounded-md hover:bg-indigo-500 focus:outline-none">
                        {{ props.event ? 'Update Event' : 'Create Event' }}
                    </button>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
