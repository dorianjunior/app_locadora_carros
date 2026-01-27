import { createApp } from 'vue'
import { createPinia } from 'pinia'
import router from './router'
import App from './App.vue'
import { useThemeStore } from './stores/theme'
import { useAuthStore } from './stores/auth'
import '../css/app.css'

const app = createApp(App)
const pinia = createPinia()

app.use(pinia)

// Inicializar tema
const themeStore = useThemeStore()
themeStore.initTheme()

// Não inicializar auth aqui - deixar o router guard fazer isso
// para evitar múltiplas chamadas

app.use(router)
app.mount('#app')
