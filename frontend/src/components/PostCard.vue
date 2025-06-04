<template>
  <div class="post-card">
    <h3>{{ post.title }}</h3>
    <p>{{ post.body }}</p>
    <div class="post-meta">
      <span>User ID: {{ post.user_id }}</span>
    </div>
  </div>
</template>

<script setup>
defineProps({
  post: {
    type: Object,
    required: true
  }
});
</script>

<style scoped>
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