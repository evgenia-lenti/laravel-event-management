<script setup>
import { ref } from 'vue';
import {Link, router} from '@inertiajs/vue3';

const props = defineProps({
    user: Object
});

const showDeleteModal = ref(false);

const deleteEvent = () => {
    router.delete(route('admin.users.destroy', props.user.id), {
        onFinish: () => (showDeleteModal.value = false),
    });
};
</script>

<template>
    <tr>
        <td class="py-4 pr-3 text-sm text-indigo-600 hover:text-indigo-400 whitespace-nowrap">
            <Link :href="route('admin.users.show', props.user.id)">
                {{ user.name }}
            </Link>
        </td>
        <td class="px-3 py-4 text-sm text-gray-800 whitespace-nowrap">{{ user.email }}
        </td>
        <td class="px-3 py-4 text-sm text-gray-800 whitespace-nowrap">{{ user.role.label }}</td>
        <td class="px-3 py-4 text-sm text-gray-800 text-center">{{ user.registeredEventsCount }}</td>
        <td class="px-3 py-4 text-sm text-gray-800">{{ user.createdAt }}</td>
        <td class="px-3 py-4 text-sm text-gray-800">{{ user.updatedAt }}</td>
        <td class="py-4 px-3 text-sm text-right whitespace-nowrap flex justify-end space-x-3">
            <a v-if="user.can.update" :href="route('admin.users.edit', user.id)" class="text-indigo-600 hover:text-indigo-400">Edit</a>
            <button
                v-if="user.can.delete && user.registeredEventsCount === 0"
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
                Are you sure you want to delete the <strong>{{ user.name }}</strong> user?
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
