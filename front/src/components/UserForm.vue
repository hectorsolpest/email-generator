<template>
  <form @submit.prevent="submitForm" class="mt-8 space-y-6">
    <div>
      <label for="name" class="block text-sm font-medium text-gray-700">
        Nombre Completo
      </label>
      <input
        id="name"
        v-model="form.name"
        type="text"
        required
        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
        placeholder="Ej: Juan Perez Gonzalez"
      >
    </div>

    <div>
      <label for="password" class="block text-sm font-medium text-gray-700">
        Contraseña
      </label>
      <input
        id="password"
        v-model="form.password"
        type="password"
        required
        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
        placeholder="Ingresa tu contraseña"
      >
    </div>

    <div>
      <button
        type="submit"
        :disabled="loading"
        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed"
      >
        {{ loading ? 'Generando...' : 'Generar Email' }}
      </button>
    </div>

    <!-- Mensaje de error -->
    <div v-if="error" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
      {{ error }}
    </div>
  </form>
</template>

<script>
export default {
  name: 'UserForm',
  data() {
    return {
      form: {
        name: '',
        password: ''
      },
      loading: false,
      error: ''
    }
  },
  methods: {
    async submitForm() {
      this.loading = true
      this.error = ''

      try {
        // Llamar a la API de Laravel
        const response = await fetch('http://localhost:8000/api/formulario_registro', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
          },
          body: JSON.stringify(this.form)
        })

        const data = await response.json()

        if (response.ok) {
          // Emitir evento con el email generado
          this.$emit('email-generated', data.email)
        } else {
          this.error = data.message || 'Error al generar el email'
        }
      } catch (error) {
        this.error = 'Error de conexión. Intenta nuevamente.'
        console.error('Error:', error)
      } finally {
        this.loading = false
      }
    }
  }
}
</script>
