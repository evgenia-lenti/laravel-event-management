<script setup>
import {computed, onMounted, ref, watch} from 'vue'
import { usePage } from '@inertiajs/vue3'

const page = usePage()
const show = ref(false)
const message = ref('')
const type = ref('success')

// Watch for flash messages
const flash = computed(() => page.props.flash)

// Show toast when flash message is available
onMounted(() => {
    checkFlashMessages()
})

// Add a watcher to detect changes to the flash property
watch(flash, () => {
    checkFlashMessages()
})

// Function to check for flash messages
function checkFlashMessages() {
    if (flash.value?.success) {
        message.value = flash.value.success
        type.value = 'success'
        showToast()
    } else if (flash.value?.error) {
        message.value = flash.value.error
        type.value = 'error'
        showToast()
    }
}

// Function to show toast
function showToast() {
    show.value = true
    setTimeout(() => {
        show.value = false
    }, 5000) // Hide after 5 seconds
}
</script>

<template>
    <div
        v-if="show"
        :class="[
      'fixed top-4 right-4 z-50 p-4 rounded-md shadow-lg transition-all duration-500 transform',
      type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white',
      show ? 'translate-x-0 opacity-100' : 'translate-x-full opacity-0'
    ]"
    >
        <div class="flex items-center">
            <!-- Success Icon -->
            <svg v-if="type === 'success'" class="w-6 h-6 mr-2" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>

            <!-- Error Icon -->
            <svg v-else class="w-6 h-6 mr-2" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>

            <span>{{ message }}</span>

            <!-- Close Button -->
            <button
                @click="show = false"
                class="ml-4 text-white hover:text-gray-200 focus:outline-none"
            >
                <svg class="w-4 h-4" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>
</template>
