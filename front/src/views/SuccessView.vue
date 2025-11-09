<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 text-center">
      <div class="bg-white p-8 rounded-lg shadow-md">
        <!-- Icono de éxito -->
        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
          <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
          </svg>
        </div>

        <h2 class="mt-4 text-2xl font-bold text-gray-900">
          ¡Email Generado Exitosamente!
        </h2>

        <p class="mt-2 text-sm text-gray-600">
          Tu nuevo email es:
        </p>

        <div class="mt-4 p-4 bg-blue-50 rounded-lg">
          <p class="text-lg font-mono text-blue-700">{{ generatedEmail }}</p>
        </div>

        <div class="mt-6">
          <button
            @click="goHome"
            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
          >
            Generar Otro Email
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'SuccessView',
  computed: {
    generatedEmail() {
      return this.$route.query.email || 'No se generó email'
    }
  },
  methods: {
    goHome() {
      this.$router.push('/')
    }
  }
}
</script>
