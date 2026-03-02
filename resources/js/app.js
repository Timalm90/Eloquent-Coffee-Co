import Alpine from 'alpinejs'
import filterComponent from './filters'

window.Alpine = Alpine

Alpine.data('filterComponent', filterComponent)
Alpine.start()