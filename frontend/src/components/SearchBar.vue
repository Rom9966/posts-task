<template>
  <div class="search-bar">
    <input
      :value="modelValue"
      type="text"
      placeholder="Search posts..."
      class="search-input"
      @input="$emit('update:modelValue', $event.target.value)"
      @change="$emit('search')"
    />
    <button @click="$emit('sync')" class="sync-button">Sync Posts</button>
  </div>
</template>

<script setup>
defineProps({
  modelValue: {
    type: String,
    required: true
  }
});

defineEmits(['update:modelValue', 'sync']);
</script>

<style scoped>
.search-bar {
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
</style> 