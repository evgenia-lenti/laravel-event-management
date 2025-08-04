<script setup>
defineProps({
    statistics: {
        type: Object,
        required: true
    }
})
</script>

<template>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Dashboard Statistics</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Events Statistics -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-lg font-medium text-gray-700 mb-2">Events</h3>
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Published:</span>
                        <span class="font-medium">{{ statistics.events.published }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Draft:</span>
                        <span class="font-medium">{{ statistics.events.draft }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Cancelled:</span>
                        <span class="font-medium">{{ statistics.events.cancelled }}</span>
                    </div>
                    <div class="flex justify-between pt-2 border-t border-gray-200">
                        <span class="text-gray-700 font-medium">Total:</span>
                        <span class="font-semibold">{{
                            statistics.events.total
                        }}</span>
                    </div>
                </div>
            </div>

            <!-- Users Statistics -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-lg font-medium text-gray-700 mb-2">Users</h3>
                <div class="flex items-center justify-center h-24">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-gray-800">{{ statistics.totalUsers }}</div>
                        <div class="text-sm text-gray-500">Total Users</div>
                    </div>
                </div>
            </div>

            <!-- Registrations Statistics -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-lg font-medium text-gray-700 mb-2">Registrations</h3>
                <div class="flex items-center justify-center h-24">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-gray-800">{{ statistics.totalRegistrations }}</div>
                        <div class="text-sm text-gray-500">Total Registrations</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
