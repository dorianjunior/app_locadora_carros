import Swal from 'sweetalert2'

const Toast = Swal.mixin({
  toast: true,
  position: 'bottom-start',
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
  }
})

export const showAlert = {
  success: (message, title = 'Sucesso!') => {
    return Swal.fire({
      icon: 'success',
      title: title,
      text: message,
      confirmButtonColor: '#0284c7',
    })
  },

  error: (message, title = 'Erro!') => {
    return Swal.fire({
      icon: 'error',
      title: title,
      text: message,
      confirmButtonColor: '#0284c7',
    })
  },

  warning: (message, title = 'Atenção!') => {
    return Swal.fire({
      icon: 'warning',
      title: title,
      text: message,
      confirmButtonColor: '#0284c7',
    })
  },

  confirm: (message, title = 'Tem certeza?') => {
    return Swal.fire({
      icon: 'question',
      title: title,
      text: message,
      showCancelButton: true,
      confirmButtonColor: '#0284c7',
      cancelButtonColor: '#dc2626',
      confirmButtonText: 'Sim',
      cancelButtonText: 'Não'
    })
  },

  toast: {
    success: (message) => {
      Toast.fire({
        icon: 'success',
        title: message
      })
    },
    error: (message) => {
      Toast.fire({
        icon: 'error',
        title: message
      })
    },
    info: (message) => {
      Toast.fire({
        icon: 'info',
        title: message
      })
    }
  }
}

export default showAlert
