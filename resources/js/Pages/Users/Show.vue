<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    user: Object
});
</script>

<template>
    <Head title="View Event" />

    <AuthenticatedLayout>
        <div class="max-w-4xl mx-auto mt-10 bg-white shadow rounded-lg p-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">
                User Details
            </h1>

            <!-- Name -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Name</label>
                <p class="mt-1 text-gray-900">{{ user.data.name }}</p>
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <p class="mt-1 text-gray-900">{{ user.data.email }}</p>
            </div>

            <!-- Role -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Role</label>
                <span
                    class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full"
                    :class="{
                        'bg-green-100 text-green-800': user.data.role.value === 'admin',
                        'bg-yellow-100 text-yellow-800': user.data.role.value === 'user',
                    }">
                    {{ user.data.role.label }}
                </span>
            </div>

            <!-- Current Registrations Count -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Current Registrations</label>
                <p class="mt-1 text-gray-900">{{ user.data.current_registrations_count }}</p>
            </div>

            <!-- Back Button -->
            <div class="mt-6">
                <a
                    :href="route('admin.users.index')"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded hover:bg-indigo-700">
                    Back to Users
                </a>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
