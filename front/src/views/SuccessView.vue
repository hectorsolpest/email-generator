<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-900 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full">
      <div class="bg-gray-800 p-8 rounded-2xl shadow-2xl border border-gray-700 text-center">

        <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-900 border border-green-700">
          <svg class="h-8 w-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
          </svg>
        </div>

        <h2 class="mt-6 text-2xl font-bold text-white">
          ¡Email Generado Exitosamente!
        </h2>

        <p class="mt-3 text-gray-400">
          Tu nuevo email personalizado es:
        </p>

        <div class="mt-6 p-4 bg-gray-700 border border-gray-600 rounded-lg">
          <p class="text-lg font-mono text-blue-400 font-semibold">{{ generatedEmail }}</p>
        </div>

        <div class="mt-4 p-3 bg-gray-700 rounded-lg">
          <p class="text-sm text-gray-500">
            Este email ha sido generado automáticamente basado en tu nombre
          </p>
        </div>

        <div class="mt-8">
          <button
            @click="goHome"
            class="w-full py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 transform hover:scale-[1.02]"
          >
            Generar Otro Email
          </button>
        </div>

        <div class="mt-4">
          <button
            @click="copyEmail"
            class="text-sm text-gray-500 hover:text-gray-300 transition-colors duration-200"
          >
            <span class="flex items-center justify-center">
              <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
              </svg>
              Copiar email al portapapeles
            </span>
          </button>
        </div>

        <div v-if="copyMessage" class="mt-3 bg-green-900 border border-green-700 text-green-300 px-3 py-2 rounded-lg text-sm">
          ¡Email copiado al portapapeles!
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'SuccessView',
  data() {
    return {
      copyMessage: false
    }
  },
  computed: {
    generatedEmail() {
      return this.$route.query.email || 'No se generó email'
    }
  },
  methods: {
    goHome() {
      this.$router.push('/')
    },
    async copyEmail() {
      try {
        await navigator.clipboard.writeText(this.generatedEmail)
        this.copyMessage = true
        setTimeout(() => {
          this.copyMessage = false
        }, 2000)
      } catch (err) {
        console.error('Error al copiar: ', err)
      }
    }
  }
}
</script>
