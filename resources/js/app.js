import "../css/app.css";
// Alpine.js
import Alpine from "alpinejs";
import persist from "@alpinejs/persist";

Alpine.plugin(persist);
window.Alpine = Alpine;
Alpine.start();

// Charts
import ApexCharts from "apexcharts";
import Chart from "chart.js/auto";

window.ApexCharts = ApexCharts;
window.Chart = Chart;

// Datepicker
import flatpickr from "flatpickr";
window.flatpickr = flatpickr;

// Dropzone
import Dropzone from "dropzone";
window.Dropzone = Dropzone;

// Swiper
import Swiper from "swiper";
import "swiper/swiper-bundle.css";
window.Swiper = Swiper;

// FullCalendar
import { Calendar } from "@fullcalendar/core";
import dayGridPlugin from "@fullcalendar/daygrid";
import interactionPlugin from "@fullcalendar/interaction";

window.FullCalendar = { Calendar, dayGridPlugin, interactionPlugin };

// Vector Map
import "jsvectormap/dist/jsvectormap.css";
import "jsvectormap";

//User UI

import '../js/components/users';


console.log("TailAdmin + CI4 running with Vite!");
