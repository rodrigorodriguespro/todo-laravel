<template>
  <div class="task-form-container">
    <form @submit.prevent="submit" class="task-form">
      <div class="task-form-header">
        <input v-model="form.title" placeholder="Nome da tarefa" class="task-title" />
        <textarea v-model="form.description" placeholder="Descrição" class="task-desc"></textarea>
      </div>
      <div class="task-form-options">
        <label class="option-btn" :class="{active: form.status === 'pending'}">
          <input type="radio" v-model="form.status" value="pending" class="status-radio" />
          Pendente
        </label>
        <label class="option-btn" :class="{active: form.status === 'done'}">
          <input type="radio" v-model="form.status" value="done" class="status-radio" />
          Concluída
        </label>
        <label class="option-btn">
          <i class="fa fa-calendar"></i>
          <input type="date" v-model="form.deadline" class="calendar-input" />
        </label>
      </div>
      <div class="task-form-footer">
        <div></div>
        <div class="task-form-actions">
          <button type="submit" class="add-btn">Adicionar tarefa</button>
        </div>
      </div>
    </form>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'

const emit = defineEmits(['taskSaved'])

const form = ref({
  title: '',
  description: '',
  status: 'pending',
  deadline: ''
})

const submit = async () => {
  try {
    await axios.post('/tasks', form.value)
    form.value.title = ''
    form.value.description = ''
    form.value.status = 'pending'
    form.value.deadline = ''
    emit('taskSaved')
  } catch (error) {
    console.error('Erro ao salvar a tarefa:', error)
  }
}
</script>

<style scoped>
.task-form-container {
  background: #fff;
  border-radius: 16px;
  padding: 24px;
  color: #232324;
  max-width: 100%;
  margin: 0 auto;
  box-shadow: 0 2px 8px rgba(0,0,0,0.04);
}
.task-form-header {
  margin-bottom: 16px;
}
.task-title {
  width: 100%;
  background: transparent;
  border: none;
  border-bottom: 1px solid #ccc;
  color: #232324;
  font-size: 1.5rem;
  font-weight: 600;
  margin-bottom: 8px;
  outline: none;
}
.task-desc {
  width: 100%;
  background: transparent;
  border: none;
  border-bottom: 1px solid #ccc;
  color: #555;
  font-size: 1rem;
  margin-bottom: 8px;
  outline: none;
  resize: none;
}
.task-form-options {
  display: flex;
  gap: 8px;
  margin-bottom: 16px;
  flex-wrap: wrap;
}
.option-btn {
  background: #f5f5f5;
  border: 1px solid #ddd;
  color: #444;
  border-radius: 8px;
  padding: 6px 14px;
  font-size: 0.95rem;
  display: flex;
  align-items: center;
  gap: 6px;
  cursor: pointer;
  transition: background 0.2s;
  position: relative;
  font-weight: 500;
}
.option-btn.active,
.option-btn input[type="radio"]:checked + span {
  background: #eaeaea;
  border-color: #000000;
  color: #000000;
}
.status-radio {
  display: none;
}
.calendar-input {
  background: transparent;
  border: none;
  color: #444;
  font-size: 1rem;
  margin-left: 6px;
  padding: 0;
  outline: none;
  width: 120px;
}
.calendar-input::-webkit-calendar-picker-indicator {
  filter: invert(0.5);
}
.task-form-footer {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-top: 16px;
}
.task-form-actions {
  display: flex;
  gap: 12px;
}
.add-btn {
  background: #000000;
  color: #fff;
  border: none;
  border-radius: 8px;
  padding: 8px 18px;
  font-size: 1rem;
  cursor: pointer;
  transition: background 0.2s;
}
.add-btn:disabled {
  background: #e0e0e0;
  color: #aaa;
  cursor: not-allowed;
}
.add-btn:hover:not(:disabled) {
  background: #a33c3c;
}
</style>
