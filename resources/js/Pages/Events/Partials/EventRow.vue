<script setup>
import { ref } from 'vue';
import {Link, router} from '@inertiajs/vue3';

const props = defineProps({
    event: Object
});

const showDeleteModal = ref(false);

const deleteEvent = () => {
    router.delete(route('admin.events.destroy', props.event.id), {
        onFinish: () => (showDeleteModal.value = false),
    });
};
</script>

<template>
    <tr>
        <td class="py-4 pr-3 text-sm text-indigo-600 hover:text-indigo-400 whitespace-nowrap">
            <Link :href="route('admin.events.show', props.event.id)">
                {{ event.title }}
            </Link>
        </td>
        <td class="pr-3 py-4 text-sm text-gray-800 truncate max-w-[200px]" :title="event.description">{{ event.description }}
        </td>
        <td class="pr-3 py-4 text-sm text-gray-800 whitespace-nowrap">{{ event.eventDate }}</td>
        <td class="pr-3 py-4 text-sm text-gray-800 whitespace-nowrap">{{ event.location }}</td>
        <td class="pr-3 py-4 text-sm text-gray-800 text-center">{{ event.capacity }}</td>
        <td class="pr-3 py-4 text-sm text-gray-800 text-center">{{ event.status.label }}</td>
        <td class="pr-3 py-4 text-sm text-gray-800 text-center">{{ event.currentRegistrationsCount }}</td>
        <td class="py-4 pr-3 text-sm text-right whitespace-nowrap flex justify-end space-x-3">
            <a v-if="event.can.update" :href="route('admin.events.edit', event.id)" class="text-indigo-600 hover:text-indigo-400">Edit</a>
            <button
                v-if="event.can.delete"
                @click="showDeleteModal = true"
                class="text-red-600 hover:text-red-400">

                Delete
            </button>
        </td>
    </tr>

    <!-- Delete Confirmation Modal -->
    <div v-if="showDeleteModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Confirm Delete</h3>
            <p class="text-sm text-gray-600 mb-6">
                Are you sure you want to delete the <strong>{{ event.title }}</strong> event?
                This action cannot be undone.
            </p>
            <div class="flex justify-end space-x-3">
                <button
                    @click="showDeleteModal = false"
                    class="px-4 py-2 text-sm bg-gray-200 rounded hover:bg-gray-300">
                    Cancel
                </button>
                <button
                    @click="deleteEvent"
                    class="px-4 py-2 text-sm bg-red-600 text-white rounded hover:bg-red-700">
                    Delete
                </button>
            </div>
        </div>
    </div>
</template>
