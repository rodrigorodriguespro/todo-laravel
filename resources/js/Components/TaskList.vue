<template>
  <ul class="list-group">
    <li
      v-for="task in tasks.data"
      :key="task.id"
      class="list-group-item task-item"
    >
      <div class="task-content">
        <input
          type="checkbox"
          :checked="task.status === 'done'"
          class="rounded-checkbox"
          @change="toggleStatus(task)"
        />
        <div class="task-main">
          <div>
            <strong>{{ task.title }}</strong>
            <small v-if="task.description" class="task-desc"> - {{ task.description }}</small>
          </div>
          <div class="task-info">
            <span
              class="status-tag"
              :class="task.status === 'pending' ? 'tag-pending' : 'tag-done'"
            >
              {{ task.status === 'pending' ? 'Pendente' : '✅ Concluído' }}
            </span>
            <span class="task-date">
              {{ formatDate(task.deadline) }}
            </span>
          </div>
        </div>
        <button class="delete-btn" @click="deleteTask(task.id)">
          🗑️
        </button>
      </div>
    </li>
  </ul>
  <div v-if="tasks.links && tasks.links.length > 1" class="pagination">
    <button
      v-for="link in tasks.links"
      :key="link.label"
      :disabled="!link.url"
      :class="{ active: link.active }"
      v-html="link.label"
      @click="goToPage(link.url)"
      class="page-link"
    />
  </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import axios from 'axios'

const props = defineProps({ tasks: Object })
const emit = defineEmits(['update:tasks'])

const tasks = ref(props.tasks)

watch(
  () => props.tasks,
  (newVal) => {
    tasks.value = newVal
  }
)

function formatDate(date) {
  if (!date) return ''
  return new Date(date).toLocaleDateString('pt-BR')
}

async function deleteTask(id) {
  try {
    await axios.delete(`/tasks/${id}`)
    tasks.value.data = tasks.value.data.filter(task => task.id !== id)
  } catch (e) {
    console.error('Erro ao excluir a tarefa:', e)
  }
}

async function toggleStatus(task) {
  const newStatus = task.status === 'done' ? 'pending' : 'done'
  try {
    await axios.put(`/tasks/${task.id}`, {
      ...task,
      status: newStatus
    })
    task.status = newStatus
  } catch (e) {
    
  }
}

async function goToPage(url) {
  if (!url) return
  try {
    const response = await axios.get(url)
    tasks.value = response.data
    emit('update:tasks', response.data)
  } catch (e) {
    
  }
}
</script>

<style scoped>
.task-item {
  padding: 0;
  border: none;
  background: transparent;
}
.task-content {
  display: flex;
  align-items: center;
  padding: 12px 8px;
  border-bottom: 1px solid #eee;
  background: #fff;
  gap: 8px;
}
.rounded-checkbox {
  width: 20px;
  height: 20px;
  border-radius: 50%;
  accent-color: #4caf50;
  margin-right: 14px;
  flex-shrink: 0;
}
.task-main {
  flex: 1;
  display: flex;
  flex-direction: column;
  min-width: 0;
}
.task-info {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-top: 2px;
}
.status-tag {
  display: inline-block;
  padding: 2px 10px;
  border-radius: 12px;
  font-size: 0.85rem;
  font-weight: 600;
}
.tag-pending {
  background: #f5f5f5;
  color: #444;
  border: 1px solid #ddd;
}
.tag-done {
  background: #000;
  color: #fff;
  border: 1px solid #000;
}
.task-date {
  font-size: 0.9rem;
  color: #888;
}
.delete-btn {
  background: transparent;
  border: none;
  color: #c00;
  font-size: 1.2rem;
  cursor: pointer;
  transition: color 0.2s;
  flex-shrink: 0;
  padding: 4px 8px;
  margin-left: 8px;
  align-self: flex-start;
}
.delete-btn:hover {
  color: #a33c3c;
}
.task-desc {
  color: #888;
  font-size: 0.92em;
}
.pagination {
  display: flex;
  gap: 4px;
  margin-top: 16px;
  justify-content: center;
}
.page-link {
  display: inline-block;
  padding: 8px 16px;
  border-radius: 12px;
  font-size: 0.95rem;
  font-weight: 600;
  border: 1px solid #ddd;
  background: #f5f5f5;
  color: #444;
  cursor: pointer;
  min-width: 32px;
  transition: background 0.2s, color 0.2s, border-color 0.2s;
}
.page-link.active,
.page-link:disabled {
  background: #000;
  color: #fff;
  border-color: #000;
  cursor: default;
}
</style>
