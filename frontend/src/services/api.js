import axios from 'axios';

const API_URL = 'http://localhost:8000/api';

const api = axios.create({
    baseURL: API_URL,
    headers: {
        'Content-Type': 'application/json',
    },
});

export const postService = {
    async getAllPosts() {
        const response = await api.get('/posts');
        return response.data.data;
    },

    async searchPosts(query) {
        const response = await api.get('/posts/search', {
            params: { query }
        });
        return response.data.data;
    },

    async syncPosts() {
        const response = await api.post('/posts/sync');
        return response.data;
    }
}; 