
<template>
  <div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Contact Us</h1>
    
    <form @submit.prevent="submit" class="max-w-lg">
      <div class="mb-4">
        <label class="block text-gray-700 mb-2" for="name">Name</label>
        <input
          type="text"
          id="name"
          v-model="form.name"
          class="w-full px-3 py-2 border rounded-lg"
          required
        >
      </div>

      <div class="mb-4">
        <label class="block text-gray-700 mb-2" for="email">Email</label>
        <input
          type="email"
          id="email"
          v-model="form.email"
          class="w-full px-3 py-2 border rounded-lg"
          required
        >
      </div>

      <div class="mb-4">
        <label class="block text-gray-700 mb-2" for="message">Message</label>
        <textarea
          id="message"
          v-model="form.message"
          rows="4"
          class="w-full px-3 py-2 border rounded-lg"
          required
        ></textarea>
      </div>

      <button
        type="submit"
        class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600"
      >
        Send Message
      </button>
    </form>
  </div>
</template>

<script setup>
import { reactive } from 'vue'

const form = reactive({
  name: '',
  email: '',
  message: ''
})

const submit = () => {
  // Handle form submission
  console.log('Form submitted:', form)
}
</script>
