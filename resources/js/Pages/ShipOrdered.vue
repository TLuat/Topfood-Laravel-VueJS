<script setup>
import { Link } from "@inertiajs/vue3";
import { Head, usePage } from "@inertiajs/vue3";
import { ref } from "vue";
import { computed } from "vue";
import ProductDetail from "./ProductDetail.vue";

const props = defineProps({
    orders: {
        type: Object,
        required: true,
    },
    products: {
        type: Object,
        required: true,
    },
    comments: {
        type: Object,
        required: true,
    },
    ratings: {
        type: Object,
        required: true,
    },
});

const tab = ref(null);

const One = "One";
const Two = "Two";

const formatDate = (dateString) => {
    const date = new Date(dateString);
    return date.toLocaleString("en-GB");
};

const getImageUrl = (imageName) => {
    return `/storage/${imageName}`;
};
const uniqueProducts = computed(() => {
    const allProducts = props.orders
        .filter(order => order.status === "shipped")
        .flatMap(order => order.products);

    const uniqueProductIds = new Set();

    return allProducts.filter(product => {
        const isUnique = !uniqueProductIds.has(product.id);
        uniqueProductIds.add(product.id);
        return isUnique;
    });
});

const dialog = ref(false);
const selectedProduct = ref(null);

const handleAddButtonClick = (product) => {
    selectedProduct.value = product;
    dialog.value = true;
};
const getProductRating = (productId) => {
    const ratingsForProduct = props.ratings.filter(
        (rating) => rating.product_id === productId
    );

    if (ratingsForProduct.length === 0) {
        return 0;
    }

    const sum = ratingsForProduct.reduce(
        (acc, rating) => acc + rating.value,
        0
    );
    return sum / ratingsForProduct.length;
};

const countProductRating = (productId) => {
    const ratingsForProduct = props.ratings.filter(
        (rating) => rating.product_id === productId
    );

    if (ratingsForProduct.length === 0) {
        return 0;
    }

    return ratingsForProduct.length;
};
const { props: { auth } } = usePage();
const currentUserId = auth.user.id;
const hasUserRatedProduct = (productId) => {
    return props.ratings.some(
        (rating) => rating.product_id === productId && rating.user_id === currentUserId
    );
};

</script>

<template>
    <div>
        <div class="border-t">
        <hr class="mt-2">
            <v-toolbar class="bg-purple-900" height="10" rounded>
                <template v-slot:extension>
                    <v-tabs v-model="tab" align-tabs="title" color="#FF3D00">
                        <v-tab :value="One">Tất cả</v-tab>
                        <v-tab :value="Two">Chưa đánh giá</v-tab>
                        <v-tab :value="Three">Đã đánh giá</v-tab>
                    </v-tabs>
                </template>
            </v-toolbar>

            <v-window v-model="tab" class="h-96">
                <v-window-item value="One">
                    <v-table height="500px" fixed-header>
                        <div
                            class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-2 p-6 bg-cover bg-center lg:gap-4 cursor-pointer min-w-1/4"
                        >
                            <div
                                v-for="product in uniqueProducts"
                                :key="product.id"
                            >
                                <v-card
                                    height="160"
                                    @click="handleAddButtonClick(product)"
                                >
                                    <v-img
                                        :src="getImageUrl(product.image)"
                                        alt="product image"
                                        class="mx-auto rounded"
                                        rounded="lg"
                                        width="250"
                                        cover
                                        height="100"
                                    />
                                    <v-card-item>
                                        <v-card-title class="mx-auto">{{
                                            product.name
                                        }}</v-card-title>
                                    </v-card-item>
                                </v-card>
                            </div>
                        </div>
                    </v-table>
                </v-window-item>

                <v-window-item value="Two" class="h-96">
                    <v-table height="500px" fixed-header>
                        <div
                            class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-2 p-6 bg-cover bg-center lg:gap-4 cursor-pointer min-w-1/4"
                        >
                            <template
                                v-for="product in uniqueProducts"
                                :key="product.id"
                            >
                                <div v-if="!hasUserRatedProduct(product.id)">
                                    <v-card
                                        height="160"
                                        @click="handleAddButtonClick(product)"
                                    >
                                        <v-img
                                            :src="getImageUrl(product.image)"
                                            alt="product image"
                                            class="mx-auto rounded"
                                            rounded="lg"
                                            width="250"
                                            cover
                                            height="100"
                                        />
                                        <v-card-item>
                                            <v-card-title class="mx-auto">{{
                                                product.name
                                            }}</v-card-title>
                                        </v-card-item>
                                    </v-card>
                                </div>
                            </template>
                        </div>
                    </v-table>
                </v-window-item>
                <v-window-item value="Three" class="h-96">
                    <v-table height="500px" fixed-header>
                        <div
                            class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-2 p-6 bg-cover bg-center lg:gap-4 cursor-pointer min-w-1/4"
                        >
                        <template
                                v-for="product in uniqueProducts"
                                :key="product.id"
                            >
                                <div v-if="getProductRating(product.id)">
                                    <v-card
                                        height="160"
                                        @click="handleAddButtonClick(product)"
                                    >
                                        <v-img
                                            :src="getImageUrl(product.image)"
                                            alt="product image"
                                            class="mx-auto rounded"
                                            rounded="lg"
                                            width="250"
                                            cover
                                            height="100"
                                        />
                                        <v-card-item>
                                            <v-card-title class="mx-auto">{{
                                                product.name
                                            }}</v-card-title>
                                        </v-card-item>
                                    </v-card>
                                </div>
                            </template>
                        </div>
                    </v-table>
                </v-window-item>
            </v-window>
        </div>
        <div class="text-center">
            <v-dialog
                v-model="dialog"
                transition="scale-transition"
                width="1126"
            >
                <v-card-item class="bg-cyan-darken-1 rounded-t-lg">
                    <v-card-title>
                        <span class="text-h5 my-auto uppercase"
                            >{{ selectedProduct.name }}
                            <v-rating
                                :model-value="
                                    getProductRating(selectedProduct.id)
                                "
                                color="amber"
                                density="compact"
                                half-increments
                                readonly
                                size="small"
                            ></v-rating>
                            ({{ countProductRating(selectedProduct.id) }})
                        </span>
                    </v-card-title>

                    <template v-slot:append>
                        <v-defaults-provider
                            :defaults="{
                                VBtn: {
                                    variant: 'text',
                                    density: 'comfortable',
                                },
                            }"
                        >
                            <v-btn
                                icon="mdi mdi-close-thick"
                                @click="dialog = false"
                            ></v-btn>
                        </v-defaults-provider>
                    </template>
                </v-card-item>

                <v-card>
                    <ProductDetail
                        :product="selectedProduct"
                        :orders="orders"
                        :comments="comments"
                        :ratings="ratings"
                    />
                </v-card>
            </v-dialog>
        </div>
    </div>
</template>
