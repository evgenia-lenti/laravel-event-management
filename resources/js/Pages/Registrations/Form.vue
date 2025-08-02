<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    events: Array,
    users: Array,
});

const form = ref({
    event_id: '',
    user_id: '',
    errors: {},
});

function submit() {
    form.value.errors = {};

    router.post(route('admin.registrations.store'), form.value, {
        onError: (errors) => {
            form.value.errors = errors;
        },
    });
}

function cancel() {
    router.get(route('admin.registrations.index'));
}
</script>

<template>
    <Head title="Add Registration" />

    <AuthenticatedLayout>
        <div class="min-h-full">
            <main class="mt-24">
                <div class="mx-auto max-w-3xl px-4 pb-12 sm:px-6 lg:px-8">
                    <div class="rounded-lg bg-white px-5 py-6 shadow-sm sm:px-6">
                        <h1 class="text-base font-semibold text-gray-800 mb-6">
                            Add Registration
                        </h1>

                        <form @submit.prevent="submit" class="space-y-6">
                            <!-- Event Select -->
                            <div>
                                <label for="event_id" class="block text-sm font-medium text-gray-700">Event</label>
                                <select
                                    id="event_id"
                                    v-model="form.event_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                >
                                    <option value="">Select an event</option>
                                    <option v-for="event in events" :key="event.id" :value="event.id">
                                        {{ event.title }}
                                    </option>
                                </select>
                                <p v-if="form.errors.event_id" class="text-sm text-red-600 mt-1">
                                    {{ form.errors.event_id }}
                                </p>
                            </div>

                            <!-- User Select -->
                            <div>
                                <label for="user_id" class="block text-sm font-medium text-gray-700">User</label>
                                <select
                                    id="user_id"
                                    v-model="form.user_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                >
                                    <option value="">Select a user</option>
                                    <option v-for="user in users" :key="user.id" :value="user.id">
                                        {{ user.name }} ({{ user.email }})
                                    </option>
                                </select>
                                <p v-if="form.errors.user_id" class="text-sm text-red-600 mt-1">
                                    {{ form.errors.user_id }}
                                </p>
                            </div>

                            <!-- Buttons -->
                            <div class="flex justify-end space-x-3">
                                <button
                                    type="button"
                                    @click="cancel"
                                    class="px-4 py-2 text-sm bg-gray-200 rounded hover:bg-gray-300">
                                    Cancel
                                </button>
                                <button
                                    type="submit"
                                    class="px-4 py-2 text-sm bg-indigo-600 text-white rounded hover:bg-indigo-700">
                                    Register
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </AuthenticatedLayout>
</template>
