<template>
  <div class="post-list">
    <SearchBar
      v-model="searchQuery"
      @sync="syncPosts"
      @search="searchPosts"
    />

    <div v-if="loading" class="loading">Loading...</div>
    <div v-else-if="error" class="error">{{ error }}</div>
    <div v-else>
      <div class="posts-wrapper">
        <div v-if="loading" class="posts-loader">
          <span class="spinner"></span>
        </div>
        <div class="posts" :class="{ 'blurred': loading }">
          <PostCard
            v-for="post in posts"
            :key="post.id"
            :post="post"
          />
        </div>
      </div>
      <div v-if="meta && meta.last_page > 1" class="pagination">
        <button :disabled="meta.current_page === 1" @click="changePage(meta.current_page - 1)">Prev</button>
        <button
          v-for="page in meta.last_page"
          :key="page"
          :class="{ active: meta.current_page === page }"
          @click="changePage(page)"
        >
          {{ page }}
        </button>
        <button :disabled="meta.current_page === meta.last_page" @click="changePage(meta.current_page + 1)">Next</button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useDebounceFn } from '@vueuse/core'
import { postService } from '../services/api'
import PostCard from './PostCard.vue'
import SearchBar from './SearchBar.vue'

const posts = ref([])
const loading = ref(false)
const error = ref(null)
const searchQuery = ref('')
const meta = ref(null)
const perPage = ref(10)
const currentPage = ref(1)

const fetchPosts = async (page = 1) => {
  loading.value = true
  error.value = null
  try {
    const res = await postService.getAllPosts(page, perPage.value)
    posts.value = res.data
    meta.value = res.meta
    currentPage.value = res.meta.current_page
  } catch (e) {
    error.value = 'Failed to fetch posts'
    console.error(e)
  } finally {
    loading.value = false
  }
}

const searchPosts = async (page = 1) => {
  if (!searchQuery.value) {
    await fetchPosts(page)
    return
  }
  loading.value = true
  error.value = null
  try {
    const res = await postService.searchPosts(searchQuery.value, page, perPage.value)
    posts.value = res.data
    meta.value = res.meta
    currentPage.value = res.meta.current_page
  } catch (e) {
    error.value = 'Failed to search posts'
    console.error(e)
  } finally {
    loading.value = false
  }
}

const changePage = (page) => {
  if (searchQuery.value) {
    searchPosts(page)
  } else {
    fetchPosts(page)
  }
}

const handleSearch = useDebounceFn(searchPosts, 300)

const syncPosts = async () => {
  loading.value = true
  error.value = null
  try {
    await postService.syncPosts()
    await fetchPosts(1)
  } catch (e) {
    error.value = 'Failed to sync posts'
    console.error(e)
  } finally {
    loading.value = false
  }
}

onMounted(() => fetchPosts(1))
</script>

<style scoped>
.post-list {
  max-width: 1200px;
  margin: 0 auto;
  padding: 20px;
}

.loading, .error {
  text-align: center;
  padding: 20px;
  font-size: 18px;
}

.error {
  color: #f44336;
}

.posts-wrapper {
  position: relative;
}
.posts-loader {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  background: rgba(255,255,255,0.7);
  z-index: 2;
}
.spinner {
  width: 40px;
  height: 40px;
  border: 4px solid #2c3e50;
  border-top: 4px solid #4CAF50;
  border-radius: 50%;
  animation: spin 1s linear infinite;
}
@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
.blurred {
  filter: blur(2px);
  pointer-events: none;
}

.posts {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 20px;
}

.pagination {
  display: flex;
  justify-content: center;
  gap: 4px;
  margin: 24px 0 0 0;
}
.pagination button {
  padding: 6px 12px;
  border: 1px solid #ddd;
  background: #fff;
  cursor: pointer;
  border-radius: 4px;
}
.pagination button.active {
  background: #2c3e50;
  color: #fff;
  font-weight: bold;
}
.pagination button:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}
</style> 