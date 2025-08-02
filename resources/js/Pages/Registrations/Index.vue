<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import {ref} from 'vue';
import RegistrationRow from "@/Pages/Registrations/Partials/RegistrationRow.vue";
import RegistrationModal from "@/Pages/Registrations/Partials/RegistrationModal.vue";

defineProps({
    registrations: Object,
    filters: Object,
    can: Object,
    users: Array,
    events: Array
});

const searchUser = ref('')
const searchEvent = ref('')
const showModal = ref(false)
const isModalLoaded = ref(false)
const users = ref([])
const events = ref([])

const openModal = () => {
    if (!isModalLoaded.value) {
        router.visit(route('admin.registrations.modal-data'), {
            only: ['users', 'events'],
            preserveState: true,
            replace: true,
            onSuccess: (page) => {
                users.value = page.props.users
                events.value = page.props.events
                isModalLoaded.value = true
                showModal.value = true
            }
        });
    } else {
        showModal.value = true
    }
}

function applyFilters() {
    router.get(route('admin.registrations.index'), {
        search_user: searchUser.value,
        search_event: searchEvent.value,
    });
}

function clearFilters() {
    searchUser.value = ''
    searchEvent.value = ''
    router.get(route('admin.registrations.index'))
}
</script>

<template>
    <Head title="Registrations" />

    <AuthenticatedLayout>
        <div class="min-h-full">
            <main class="mt-24">
                <div class="mx-auto px-4 pb-12 sm:px-6 lg:px-8">
                    <div class="rounded-lg bg-white px-5 py-6 shadow-sm sm:px-6">
                        <div class="px-4 sm:px-6 lg:px-8">
                            <!-- Header -->
                            <div class="sm:flex sm:items-center">
                                <div class="sm:flex-auto">
                                    <h1 class="text-base font-semibold text-gray-800">Registrations</h1>
                                    <p class="mt-2 text-sm text-gray-700">
                                        Manage all user-event registrations with filtering by event and user.
                                    </p>
                                </div>

                                <button
                                    @click="openModal"
                                    class="bg-indigo-500 text-white px-4 py-2 rounded hover:bg-indigo-600">
                                    Add Registration
                                </button>
                            </div>

                            <!-- Search Filters -->
                            <div class="my-4 flex flex-wrap gap-4">
                                <input
                                    type="text"
                                    name="search user"
                                    v-model="searchUser"
                                    placeholder="Search by user..."
                                    class="border border-gray-300 rounded px-3 py-2 text-sm"/>

                                <input
                                    type="text"
                                    name="search event"
                                    v-model="searchEvent"
                                    placeholder="Search by event..."
                                    class="border border-gray-300 rounded px-3 py-2 text-sm"/>

                                <button
                                    @click="applyFilters"
                                    class="rounded-md bg-indigo-400 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">
                                    Search
                                </button>

                                <button
                                    @click="clearFilters"
                                    class="rounded-md bg-gray-300 px-4 py-2 text-sm font-semibold text-gray-800 hover:bg-gray-400">
                                    Clear
                                </button>
                            </div>

                            <!-- Table -->
                            <div class="mt-6 flow-root">
                                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead>
                                            <tr>
                                                <th scope="col"
                                                    class="py-3.5 pr-3 pl-4 text-left text-sm font-semibold text-gray-800 sm:pl-0">User</th>
                                                <th scope="col"
                                                    class="pr-3 py-3.5 text-left text-sm font-semibold text-gray-800">Event</th>
                                                <th scope="col"
                                                    class="pr-3 py-3.5 text-left text-sm font-semibold text-gray-800">Registration Date</th>
                                                <th class="py-3.5 pr-4 pl-3 sm:pr-0">
                                                    <span class="sr-only">Delete</span>
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-100">

                                            <RegistrationRow
                                                v-for="registration in registrations.data"
                                                :key="registration.id"
                                                :registration="registration"
                                                :can="can"/>

                                            <tr v-if="registrations.meta.total === 0">
                                                <td colspan="4" class="text-center py-4 text-gray-500">
                                                    No registrations found.
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Pagination -->
                            <div class="mt-4 flex space-x-1 justify-end">
                                <template v-for="link in registrations.meta.links" :key="link.label">
                                    <button
                                        v-if="link.url"
                                        @click="$inertia.get(link.url)"
                                        v-html="link.label"
                                        class="px-3 py-1 border rounded text-sm"
                                        :class="{
                                            'bg-indigo-500 text-white': link.active,
                                            'bg-white text-gray-700 hover:bg-gray-100': !link.active
                                        }"/>
                                    <span
                                        v-else
                                        v-html="link.label"
                                        class="px-3 py-1 border rounded text-sm text-gray-400"/>
                                </template>
                            </div>
                        </div>

                        <RegistrationModal
                            v-if="showModal"
                            :users="users"
                            :events="events"
                            @close="showModal = false"/>
                    </div>
                </div>
            </main>
        </div>
    </AuthenticatedLayout>
</template>
