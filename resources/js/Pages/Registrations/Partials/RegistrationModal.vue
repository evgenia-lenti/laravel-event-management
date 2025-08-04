<script setup>
import {ref} from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    users: Array,
    events: Array
});

const emit = defineEmits(['close'])

const form = ref({
    user_id: '',
    event_id: '',
    errors: {}
})

function registerUser() {
    form.value.errors = {}

    router.post(route('admin.registrations.store'), form.value, {
        onError: (errors) => form.value.errors = errors,
        onSuccess: () => {
            form.value.user_id = ''
            form.value.event_id = ''
            emit('close')
        }
    })
}
</script>

<template>
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Register User to Event</h3>

            <!-- User Select -->
            <div class="mb-4">
                <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">User</label>
                <select v-model="form.user_id" class="w-full border border-gray-300 rounded px-3 py-2">
                    <option value="">Select a user</option>
                    <option v-for="user in users" :key="user.id" :value="user.id">
                        {{ user.name }}
                    </option>
                </select>
                <p v-if="form.errors.user_id" class="text-red-600 text-sm mt-1">{{ form.errors.user_id }}</p>
            </div>

            <!-- Event Select -->
            <div class="mb-4">
                <label for="event_id" class="block text-sm font-medium text-gray-700 mb-1">Event</label>
                <select v-model="form.event_id" class="w-full border border-gray-300 rounded px-3 py-2">
                    <option value="">Select an event</option>
                    <option v-for="event in events" :key="event.id" :value="event.id">
                        {{ event.title }}
                    </option>
                </select>
                <p v-if="form.errors.event_id" class="text-red-600 text-sm mt-1">{{ form.errors.event_id }}</p>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end space-x-3">
                <button type="button" @click="$emit('close')" class="px-4 py-2 text-sm bg-gray-200 rounded hover:bg-gray-300">
                    Cancel
                </button>
                <button @click="registerUser" class="px-4 py-2 text-sm bg-indigo-600 text-white rounded hover:bg-indigo-700">
                    Register
                </button>
            </div>
        </div>
    </div>
</template>
