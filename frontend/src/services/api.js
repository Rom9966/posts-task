import axios from 'axios';

const API_URL = import.meta.env.VITE_API_URL;

const api = axios.create({
    baseURL: API_URL,
    headers: {
        'Content-Type': 'application/json',
    },
});

export const postService = {
    async getAllPosts(page = 1, perPage = 10) {
        const response = await api.get('/posts', {
            params: { page, per_page: perPage }
        });
        return {
            data: response.data.data.data,
            meta: response.data.data.meta
        };
    },

    async searchPosts(query, page = 1, perPage = 10) {
        const response = await api.get('/posts/search', {
            params: { query, page, per_page: perPage }
        });
        return {
            data: response.data.data.data,
            meta: response.data.data.meta
        };
    },

    async syncPosts() {
        const response = await api.post('/posts/sync');
        return response.data;
    }
}; 