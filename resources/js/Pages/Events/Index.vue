<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link, router} from '@inertiajs/vue3';
import {ref} from "vue";
import EventRow from "@/Pages/Events/Partials/EventRow.vue";

defineProps({
    events: Object,
    filters: Object,
    can: Object,
});

const search = ref('');

function clearSearch() {
    search.value = '';
    router.get(route('admin.events.index'));
}
</script>

<template>
    <Head title="Dashboard"/>

    <AuthenticatedLayout>
        <div class="min-h-full">
            <main class="mt-24">
                <div class="mx-auto px-4 pb-12 sm:px-6 lg:px-8">
                    <div class="rounded-lg bg-white px-5 py-6 shadow-sm sm:px-6">
                        <div class="px-4 sm:px-6 lg:px-8">
                            <div class="sm:flex sm:items-center">
                                <div class="sm:flex-auto">
                                    <h1 class="text-base font-semibold text-gray-800">Events</h1>
                                    <p class="mt-2 text-sm text-gray-700">A list of all the events including their
                                        title, description, event date, location, capacity, status and current registrations count.</p>
                                </div>
                                <Link
                                    v-if="can.create"
                                    :href="route('admin.events.create')"
                                    class="block rounded-md bg-indigo-400 px-3 py-2 text-center text-sm font-semibold text-gray-50 shadow-xs hover:bg-indigo-200 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
                                    Add event
                                </Link>
                            </div>

                            <!-- Search -->
                            <form method="GET" class="my-4 flex space-x-5">
                                <input
                                    type="text"
                                    name="search"
                                    placeholder="Search events..."
                                    v-model="filters.search"
                                    class="border border-gray-300 rounded px-3 py-2"/>
                                <div v-if="filters.search" class="flex items-center justify-between space-x-2">
                                    <button type="submit"
                                            class="block rounded-md bg-indigo-400 px-3 py-2 text-center text-sm font-semibold text-gray-50 shadow-xs hover:bg-indigo-200 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
                                        Search
                                    </button>

                                    <button
                                        type="button"
                                        @click="clearSearch"
                                        class="block rounded-md bg-gray-300 px-3 py-2 text-center text-sm font-semibold text-gray-800 shadow-xs hover:bg-gray-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-500">
                                        Clear
                                    </button>
                                </div>
                            </form>

                            <div class="mt-8 flow-root">
                                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                        <table class="relative min-w-full divide-y divide-white/15">
                                            <thead>
                                            <tr>
                                                <th scope="col"
                                                    class="py-3.5 pr-3 pl-4 text-left text-sm font-semibold text-gray-800 sm:pl-0">
                                                    Title
                                                </th>
                                                <th scope="col"
                                                    class="pr-3 py-3.5 text-left text-sm font-semibold text-gray-800">
                                                    Description
                                                </th>
                                                <th scope="col"
                                                    class="pr-3 py-3.5 text-left text-sm font-semibold text-gray-800">
                                                    Event Date
                                                </th>
                                                <th scope="col"
                                                    class="pr-3 py-3.5 text-left text-sm font-semibold text-gray-800">
                                                    Location
                                                </th>
                                                <th scope="col"
                                                    class="pr-3 py-3.5 text-left text-sm font-semibold text-gray-800">
                                                    Capacity
                                                </th>
                                                <th scope="col"
                                                    class="pr-3 py-3.5 text-left text-sm font-semibold text-gray-800">
                                                    Status
                                                </th>
                                                <th scope="col"
                                                    class="pr-3 py-3.5 text-left text-sm font-semibold text-gray-800">
                                                    Current Registrations Count
                                                </th>
                                                <th scope="col" class="py-3.5 pr-4 pl-3 sm:pr-0">
                                                    <span class="sr-only">Edit/Delete</span>
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody class="divide-y divide-white/10">
                                            <EventRow
                                                v-for="event in events.data"
                                                :key="event.id"
                                                :event="event"
                                                :can="can"/>

                                            <tr v-if="events.meta.total === 0">
                                                <td colspan="8" class="text-center py-4 text-gray-500">
                                                    No events found.
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 flex space-x-1 justify-end">
                            <template v-for="link in events.meta.links" :key="link.label">
                                <button
                                    v-if="link.url"
                                    @click="$inertia.get(link.url)"
                                    v-html="link.label"
                                    class="px-3 py-1 border rounded text-sm"
                                    :class="{
                                        'bg-indigo-500 text-white': link.active,
                                        'bg-white text-gray-700 hover:bg-gray-100': !link.active
                                    }"
                                />
                                <span
                                    v-else
                                    v-html="link.label"
                                    class="px-3 py-1 border rounded text-sm text-gray-400"
                                />
                            </template>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </AuthenticatedLayout>
</template>
