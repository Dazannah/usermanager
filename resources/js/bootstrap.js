import {
    Livewire,
    Alpine,
} from "../../vendor/livewire/livewire/dist/livewire.esm";
import sort from "@alpinejs/sort";
import axios from "axios";
window.axios = axios;

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

Alpine.plugin(sort);

window.Alpine = Alpine;

Livewire.start();
