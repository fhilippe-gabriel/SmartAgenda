import axios from "axios";

const api = axios.create({
  baseURL: "http://127.0.0.1:8000/", // Altere se sua API estiver em outro endereço/porta
  headers: {
    "Content-Type": "application/json",
    Accept: "application/json",
  },
});

export default api;
