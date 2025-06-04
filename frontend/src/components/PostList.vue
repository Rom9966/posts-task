<template>
  <div class="post-list">
    <div class="controls">
      <input
        v-model="searchQuery"
        type="text"
        placeholder="Search posts..."
        class="search-input"
        @input="handleSearch"
      />
      <button @click="syncPosts" class="sync-button">Sync Posts</button>
    </div>

    <div v-if="loading" class="loading">Loading...</div>
    <div v-else-if="error" class="error">{{ error }}</div>
    <div v-else class="posts">
      <div v-for="post in posts" :key="post.id" class="post-card">
        <h3>{{ post.title }}</h3>
        <p>{{ post.body }}</p>
        <div class="post-meta">
          <span>User ID: {{ post.user_id }}</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { useDebounceFn } from '@vueuse/core'

const API_URL = 'http://localhost:8000/api'
const posts = ref([])
const loading = ref(false)
const error = ref(null)
const searchQuery = ref('')

const fetchPosts = async () => {
  loading.value = true
  error.value = null
  try {
    const response = await axios.get(`${API_URL}/posts`)
    posts.value = response.data
  } catch (e) {
    error.value = 'Failed to fetch posts'
    console.error(e)
  } finally {
    loading.value = false
  }
}

const searchPosts = async () => {
  if (!searchQuery.value) {
    await fetchPosts()
    return
  }

  loading.value = true
  error.value = null
  try {
    const response = await axios.get(`${API_URL}/posts/search`, {
      params: { query: searchQuery.value }
    })
    posts.value = response.data
  } catch (e) {
    error.value = 'Failed to search posts'
    console.error(e)
  } finally {
    loading.value = false
  }
}

const handleSearch = useDebounceFn(searchPosts, 300)

const syncPosts = async () => {
  loading.value = true
  error.value = null
  try {
    await axios.post(`${API_URL}/posts/sync`)
    await fetchPosts()
  } catch (e) {
    error.value = 'Failed to sync posts'
    console.error(e)
  } finally {
    loading.value = false
  }
}

onMounted(fetchPosts)
</script>

<style scoped>
.post-list {
  max-width: 1200px;
  margin: 0 auto;
  padding: 20px;
}

.controls {
  margin-bottom: 20px;
  display: flex;
  gap: 10px;
}

.search-input {
  flex: 1;
  padding: 8px 12px;
  border: 1px solid #ddd;
  border-radius: 4px;
  font-size: 16px;
}

.sync-button {
  padding: 8px 16px;
  background-color: #4CAF50;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 16px;
}

.sync-button:hover {
  background-color: #45a049;
}

.loading, .error {
  text-align: center;
  padding: 20px;
  font-size: 18px;
}

.error {
  color: #f44336;
}

.posts {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 20px;
}

.post-card {
  background: white;
  border-radius: 8px;
  padding: 20px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.post-card h3 {
  margin: 0 0 10px 0;
  color: #333;
}

.post-card p {
  margin: 0 0 15px 0;
  color: #666;
  line-height: 1.5;
}

.post-meta {
  font-size: 14px;
  color: #888;
}
</style> 