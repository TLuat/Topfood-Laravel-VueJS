<script setup>
defineProps({
    categories: {
        type: Array,
        required: true,
    },
});
</script>
<template>
    <div
        class="w-1/4 p-4 bg-gradient-to-br from-white via-white to-transparent bg-blur backdrop-blur-none bg-opacity-0 rounded-md shadow-lg border"
    >
        <div class="mt-8">
            <h2 class="text-xl font-bold mb-4">Loại sản phẩm</h2>
            <!-- danh sách các Loại sản phẩm -->
            <button
                type="button"
                class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-l-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white"
                v-for="category in categories"
                :key="category.id"
            >
                {{ category.name }}
            </button>
        </div>
    </div>
</template>
