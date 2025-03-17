<script >
export default {
    props: {
        products: {
            type: Array,
            required: true
        }
    }
};
</script>
<template>
    <div>
        <ul>asdadasd
            <li v-for="product in products" :key="product.id">
                <p>{{ product.title }}</p>
                <p>{{ product.description }}</p>
                <hr>
            </li>
        </ul>
    </div>
</template>
