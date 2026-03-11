import Alpine from "alpinejs";
import focus from '@alpinejs/focus'
import filterComponentCustomer from "./filterComponentCustomer.js";
import filterComponentDashboard from "./filterComponentDashboard.js";

window.filterComponentCustomer = filterComponentCustomer;
window.filterComponentDashboard = filterComponentDashboard;

window.Alpine = Alpine;
Alpine.plugin(focus)

Alpine.start();
