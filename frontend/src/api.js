import axios from 'axios';

const api = axios.create({
  baseURL: 'http://localhost:8000', // Laravel backend endpoint ( /api )
  withCredentials: true, // Ensures cookies are sent automatically
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  },
});

api.defaults.baseURL = 'http://localhost:8000';  // Backend URL
api.defaults.withCredentials = true;  // Crucial for sending cookies

export default api;
