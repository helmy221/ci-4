import { defineConfig } from "vite";
import { resolve } from "path";

export default defineConfig({
  root: "resources",
  base: "/",
  build: {
    outDir: "../public/build",
    emptyOutDir: true,
    rollupOptions: {
      input: {
        css: resolve(__dirname, "resources/css/app.css"),
        js: resolve(__dirname, "resources/js/app.js")
      }
    }
  }
});
