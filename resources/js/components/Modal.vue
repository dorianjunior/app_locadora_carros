<template>
  <Teleport to="body">
    <Transition
      enter-active-class="transition ease-out duration-300"
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
      leave-active-class="transition ease-in duration-200"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div v-if="modelValue" class="fixed inset-0 z-50 overflow-y-auto">
        <div class="fixed inset-0 bg-dark-900/70 backdrop-blur-sm" @click="close"></div>

        <div class="flex min-h-screen items-center justify-center p-4">
          <Transition
            enter-active-class="transition ease-out duration-300"
            enter-from-class="opacity-0 scale-95 -translate-y-4"
            enter-to-class="opacity-100 scale-100 translate-y-0"
            leave-active-class="transition ease-in duration-200"
            leave-from-class="opacity-100 scale-100 translate-y-0"
            leave-to-class="opacity-0 scale-95 -translate-y-4"
          >
            <div
              v-if="modelValue"
              class="relative bg-white dark:bg-dark-800 rounded-3xl shadow-organic-lg max-w-lg w-full overflow-hidden"
              @click.stop
            >
              <!-- Decorative element -->
              <div class="absolute -top-20 -right-20 w-40 h-40 bg-gradient-to-br from-primary-100/40 to-transparent rounded-full blur-3xl pointer-events-none"></div>

              <div class="flex items-start justify-between p-7 border-b-2 border-sage-100 dark:border-dark-700 relative z-10">
                <h3 class="text-xl font-display font-bold text-earth-900 dark:text-white">{{ title }}</h3>
                <button
                  @click="close"
                  class="p-2 -mr-2 -mt-1 rounded-xl text-sage-500 dark:text-gray-400 hover:bg-sage-100 dark:hover:bg-dark-700 hover:text-sage-700 dark:hover:text-gray-300 transition-all duration-200 hover:rotate-90 group"
                >
                  <svg class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                  </svg>
                </button>
              </div>

              <div class="p-7 relative z-10">
                <slot />
              </div>
            </div>
          </Transition>
        </div>
      </div>
    </Transition>
  </Teleport>
</template>

<script setup>
defineProps({
  modelValue: Boolean,
  title: {
    type: String,
    default: 'Modal'
  }
})

const emit = defineEmits(['update:modelValue'])

const close = () => {
  emit('update:modelValue', false)
}
</script>
