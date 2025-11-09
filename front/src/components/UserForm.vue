<template>
  <form @submit.prevent="submitForm" class="mt-8 space-y-6">
    <!-- Contenedor del formulario -->
    <div class="bg-gray-800 p-8 rounded-2xl shadow-2xl border border-gray-700">

      <div class="space-y-6">
        <div>
          <label for="name" class="block text-sm font-medium text-gray-300">
            Nombre Completo
          </label>
          <input
            id="name"
            v-model="form.name"
            type="text"
            required
            class="mt-2 block w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
            placeholder="Ej: Juan Perez Gonzalez"
          >
        </div>

        <div>
          <label for="password" class="block text-sm font-medium text-gray-300">
            Contraseña
          </label>
          <input
            id="password"
            v-model="form.password"
            type="password"
            required
            class="mt-2 block w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
            placeholder="Ingresa tu contraseña"
          >
        </div>

        <div class="pt-4">
          <button
            type="submit"
            :disabled="loading"
            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200 transform hover:scale-[1.02]"
          >
            <span v-if="loading" class="flex items-center">
              <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              Generando...
            </span>
            <span v-else>
              Generar Email
            </span>
          </button>
        </div>
      </div>

      <div v-if="error" class="mt-6 bg-red-900 border border-red-700 text-red-200 px-4 py-3 rounded-lg">
        <div class="flex items-center">
          <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
          </svg>
          {{ error }}
        </div>
      </div>
    </div>
  </form>
</template>

<script setup>
import { ref, reactive } from 'vue'

const emit = defineEmits(['email-generated'])

const form = reactive({
  name: '',
  password: ''
})
const loading = ref(false)
const error = ref('')

const submitForm = async () => {
  loading.value = true
  error.value = ''

  try {
    const API_URL = 'http://localhost:8000/api/formulario_registro'

    const response = await fetch(API_URL, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      },
      body: JSON.stringify(form)
    })

    const data = await response.json()

    if (response.ok) {
      emit('email-generated', data.email)
    } else {
      error.value = data.message || `Error ${response.status}: ${response.statusText}`
    }
  } catch (err) {
    error.value = 'Error de conexión. Intenta nuevamente.'
    console.error('Error de conexión:', err)
  } finally {
    loading.value = false
  }
}
</script>
