<template>
  <div class="post-list">
    <SearchBar
      v-model="searchQuery"
      @sync="syncPosts"
    />

    <div v-if="loading" class="loading">Loading...</div>
    <div v-else-if="error" class="error">{{ error }}</div>
    <div v-else class="posts">
      <PostCard
        v-for="post in posts"
        :key="post.id"
        :post="post"
      />
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

const fetchPosts = async () => {
  loading.value = true
  error.value = null
  try {
    posts.value = await postService.getAllPosts()
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
    posts.value = await postService.searchPosts(searchQuery.value)
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
    await postService.syncPosts()
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
</style> 