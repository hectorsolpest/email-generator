<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
      <div>
        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
          Generar Email
        </h2>
        <p class="mt-2 text-center text-sm text-gray-600">
          Ingresa tu nombre completo para generar tu email
        </p>
      </div>

      <UserForm @email-generated="handleEmailGenerated" />
    </div>
  </div>
</template>

<script>
import UserForm from '../components/UserForm.vue'

export default {
  name: 'HomeView',
  components: {
    UserForm
  },
  methods: {
    handleEmailGenerated(email) {
      // Navegar a la página de éxito con el email como parámetro
      this.$router.push({
        name: 'success',
        query: { email: email }
      })
    }
  }
}
</script>
