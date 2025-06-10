<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue'
import axios from 'axios'
import TaskForm from '@/Components/TaskForm.vue';
import TaskList from '@/Components/TaskList.vue';


const tasks = ref([])

const fetchTasks = async () => {
  const res = await axios.get('/tasks')
  tasks.value = res.data
}

onMounted(fetchTasks)

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    <div class="container mt-4">
                        <TaskForm @taskSaved="fetchTasks" />
                    </div>
                </div>
            </div>
        </div>
        
        <div class="py-1 mb-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    <div class="container mt-4">
                        <h4 class="task-title-list">Minhas Tarefas</h4>
                        <TaskList :tasks="tasks" />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style>
.task-title-list {
  width: 100%;
  background: transparent;
  border: none;
  color: #232324;
  font-size: 1.5rem;
  font-weight: 600;
  margin-bottom: 8px;
  outline: none;
  margin-left: 20px;;
}
</style>
