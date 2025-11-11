import "../css/app.css";
// Alpine.js
import Alpine from "alpinejs";
import persist from "@alpinejs/persist";

// import './authStore.js';
Alpine.magic("rupiah", () => (value) => {
  if (value === null || value === undefined || value === "") return "-";

  // pastikan string
  let str = String(value).trim();

  // ubah koma ke titik agar bisa di-parseFloat (contoh: 1189998412,00 → 1189998412.00)
  str = str.replace(",", ".");

  const number = parseFloat(str);

  if (isNaN(number)) return value;

  // format ke gaya Indonesia (titik ribuan, koma desimal)
  let formatted = number.toLocaleString("id-ID", {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2,
  });

  // hilangkan semua spasi (kadang locale menambah non-breaking space)
  formatted = formatted.replace(/\s/g, "");

  // tambahkan prefix Rp tanpa spasi
  return "Rp " + formatted;
});




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
import '../js/components/paketPengadaan';
import '../js/components/masterUnitOrganisasi';

import '../js/components/transaksiFilter';
import '../js/components/transaksiPemenang';

console.log("TailAdmin + CI4 running with Vite!");
