<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link, useForm} from '@inertiajs/vue3';

const props = defineProps({
    user: Object,
    roles: Array
});

const form = useForm({
    name: props.user?.data.name || '',
    email: props.user?.data.email || '',
    password: props.user?.data.password || '',
    role: props.user?.data.role?.value || props.roles[0]?.value || ''
});

const submit = () => {
    if (props.user) {
        form.put(route('admin.users.update', props.user.data.id));
    } else {
        form.post(route('admin.users.store'));
    }
};
</script>

<template>
    <Head :title="props.user ? 'Edit User' : 'Create User'" />

    <AuthenticatedLayout>
        <div class="max-w-3xl mx-auto py-8">
            <h1 class="text-2xl font-semibold text-gray-800 mb-6">
                {{ props.user ? 'Edit User' : 'Create User' }}
            </h1>

            <form @submit.prevent="submit" class="space-y-6 bg-white p-6 shadow rounded-lg">
                <!-- Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Name</label>
                    <input v-model="form.name" type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"/>
                    <div v-if="form.errors.name" class="text-red-500 text-sm">{{ form.errors.name }}</div>
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input v-model="form.email" type="email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"/>
                    <div v-if="form.errors.email" class="text-red-500 text-sm">{{ form.errors.email }}</div>
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Password</label>
                    <input v-model="form.password" type="password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                    <div v-if="form.errors.password" class="text-red-500 text-sm">{{ form.errors.password }}</div>
                </div>

                <!-- Role -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Role</label>
                    <select v-model="form.role" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option v-for="role in props.roles.data" :key="role.value" :value="role.value">
                            {{ role.label }}
                        </option>
                    </select>
                    <div v-if="form.errors.role" class="text-red-500 text-sm">{{ form.errors.role }}</div>
                </div>

                <!-- Submit -->
                <div class="flex justify-end space-x-4">
                    <!-- Cancel Button -->
                    <Link
                        :href="route('admin.users.index')"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded hover:bg-gray-300">
                        Cancel
                    </Link>

                    <!-- Submit Button -->
                    <button type="submit" class="px-4 py-2 bg-indigo-500 text-gray-50 rounded-md hover:bg-indigo-500 focus:outline-none">
                        {{ props.user ? 'Update User' : 'Create User' }}
                    </button>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
