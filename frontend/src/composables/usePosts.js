import { ref } from 'vue'
import { postService } from '../services/api'

export function usePosts() {
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

  return {
    posts,
    loading,
    error,
    searchQuery,
    meta,
    perPage,
    currentPage,
    fetchPosts,
    searchPosts,
    changePage,
    syncPosts
  }
} 