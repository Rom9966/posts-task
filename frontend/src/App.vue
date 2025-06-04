<script setup>
import PostList from './components/PostList.vue'
</script>

<template>
  <header>
    <h1>Post Management</h1>
  </header>

  <main>
    <PostList />
  </main>
</template>

<style>
body {
  margin: 0;
  background-color: #f5f5f5;
  font-family: Arial, sans-serif;
}

header {
  background-color: #2c3e50;
  color: white;
  padding: 1rem;
  text-align: center;
}

header h1 {
  margin: 0;
  font-size: 2rem;
}

main {
  padding: 2rem 0;
}
</style>
