<script setup>
import { ref } from "vue";
import {Link, router} from "@inertiajs/vue3";

const props = defineProps({
    registration: Object
});

const showDeleteModal = ref(false);

function removeRegistration() {
    router.delete(route('admin.registrations.destroy', props.registration.id), {
        onFinish: () => (showDeleteModal.value = false),
    });
}
</script>

<template>
    <tr>
        <td class="py-4 pr-3 text-sm text-indigo-600 hover:text-indigo-400 whitespace-nowrap">
            <Link :href="route('admin.users.show', registration.user.id)">
                {{ registration.user.name }}
            </Link>
        </td>
        <td class="py-4 pr-3 text-sm text-indigo-600 hover:text-indigo-400 whitespace-nowrap">
            <Link :href="route('admin.events.show', registration.event.id)">
                {{ registration.event.title }}
            </Link>
        </td>
        <td class="pr-3 py-4 text-sm text-gray-800 whitespace-nowrap">{{ registration.createdAt }}</td>
        <td class="py-4 pr-4 pl-3 text-right text-sm font-medium whitespace-nowrap sm:pr-0">
            <button v-if="registration.can.delete" @click="showDeleteModal = true" class="text-red-600 hover:text-red-400">Remove</button>
        </td>
    </tr>

    <!-- Delete Modal -->
    <div v-if="showDeleteModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Confirm Removal</h3>
            <p class="text-sm text-gray-600 mb-6">
                Are you sure you want to remove
                <strong>{{ registration.user.name }}</strong> from
                <strong>{{ registration.event.title }}</strong> event?
            </p>
            <div class="flex justify-end space-x-3">
                <button @click="showDeleteModal = false"
                        class="px-4 py-2 text-sm bg-gray-200 rounded hover:bg-gray-300">
                    Cancel
                </button>
                <button @click="removeRegistration"
                        class="px-4 py-2 text-sm bg-red-600 text-white rounded hover:bg-red-700">
                    Remove
                </button>
            </div>
        </div>
    </div>
</template>
