<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-900 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
      <div class="text-center">
        <h2 class="mt-6 text-3xl font-extrabold text-white">
          Generar Email
        </h2>
        <p class="mt-2 text-sm text-gray-400">
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
      this.$router.push({
        name: 'success',
        query: {email: email}
      })
    }
  }
}
</script>
