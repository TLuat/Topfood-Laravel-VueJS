<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import Topping from "./Topping.vue";
import { ref } from "vue";
import { computed } from "vue";

const props = defineProps({
    product: {
        type: Object,
        required: true,
    },
    orders: {
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
const getImageUrl = (imageName) => {
    return `/storage/${imageName}`;
};

const quantity = ref("1");
const productId = ref(null);
const cmt_content = ref(null);
const rating = ref(0);

const isProductPurchased = computed(() => {
    return props.orders.some(
        (order) =>
            order.status === "shipped" &&
            order.products.some(
                (orderProduct) => orderProduct.id === props.product.id
            )
    );
});

const productComments = computed(() => {
    return props.comments.filter(
        (comment) => comment.product_id === props.product.id
    );
});

const productRating = computed(() => {
    return props.ratings.filter(
        (rating) => rating.product_id === props.product.id
    );
});

const totalRating = computed(() => {
    const ratings = props.ratings.filter(
        (rating) => rating.product_id === props.product.id
    );

    if (ratings.length === 0) {
        return 0;
    }

    const sum = ratings.reduce((acc, rating) => acc + rating.value, 0);
    return sum / ratings.length;
});

const getRatingProgress = (starRating) => {
    const ratings = productRating.value.filter(
        (rating) => rating.value === starRating
    );
    if (ratings.length === 0) {
        return 0;
    }
    const sum = ratings.reduce((acc, rating) => acc + rating.value, 0);
    return (sum / (ratings.length * 5)) * 100;
};

const getRatingCount = (starRating) => {
    return productRating.value.filter((rating) => rating.value === starRating)
        .length;
};

const formatDate = (dateString) => {
    const date = new Date(dateString);
    return date.toLocaleString("en-GB");
};
const dialog = ref(false);
</script>
<template>
    <div>
        <Head title="Chi tiết" />
        <div class="max-w-6xl mx-auto p-2 lg:p-4">
            <v-divider inset></v-divider>
            <div class="">
                <div class="">
                    <div class="col-span-3 row-span-3">
                        <div>
                            <v-row>
                                <v-col md="5">
                                    <v-card elevation="4" class="rounded-lg">
                                        <v-img
                                            cover
                                            class="p-20 rounded-lg"
                                            :src="getImageUrl(product.image)"
                                            alt="product image"
                                            width="500"
                                            height="320"
                                        ></v-img>
                                    </v-card>
                                </v-col>
                                <v-col md="4">
                                    <v-card
                                        class="d-flex flex-column justify-center"
                                        elevation="2"
                                    >
                                        <div
                                            class="flex justify-center mt-auto text-md"
                                        >
                                            Tổng quan đánh giá
                                        </div>

                                        <div
                                            class="d-flex align-center flex-column my-auto"
                                        >
                                            <div class="text-md mt-3">
                                                {{ totalRating.toFixed(1) }}
                                                <span class="text-xs">/5</span>
                                            </div>

                                            <v-rating
                                                :model-value="
                                                    totalRating.toFixed(1)
                                                "
                                                bg-color="orange-lighten-1"
                                                color="blue"
                                                half-increments
                                                readonly
                                            ></v-rating>
                                            <div class="px-3 text-sm">
                                                từ
                                                <span class="font-bold">{{
                                                    productRating.length
                                                }}</span>
                                                đánh giá
                                            </div>
                                        </div>

                                        <v-list
                                            bg-color="transparent"
                                            class="d-flex flex-column-reverse"
                                            density="compact"
                                            width="300"
                                        >
                                            <v-list-item
                                                class=""
                                                v-for="starRating in 5"
                                                :key="starRating"
                                            >
                                                <v-progress-linear
                                                    :model-value="
                                                        getRatingProgress(
                                                            starRating
                                                        )
                                                    "
                                                    class="mx-n5"
                                                    color="blue"
                                                    height="10"
                                                    rounded
                                                ></v-progress-linear>

                                                <template v-slot:prepend>
                                                    <span>{{
                                                        starRating
                                                    }}</span>
                                                    <v-icon
                                                        icon="mdi-star"
                                                        class="mx-3"
                                                    ></v-icon>
                                                </template>

                                                <template v-slot:append>
                                                    <div class="rating-values">
                                                        <span
                                                            class="d-flex justify-end"
                                                        >
                                                            {{
                                                                getRatingCount(
                                                                    starRating
                                                                )
                                                            }}
                                                        </span>
                                                    </div>
                                                </template>
                                            </v-list-item>
                                        </v-list>
                                    </v-card>
                                </v-col>
                                <v-col md="2">
                                    <div v-if="isProductPurchased">
                                        <p class="mx-auto text-sm text-center">
                                            Đánh giá của bạn:
                                            <span class="font-bold">{{
                                                rating
                                            }}</span>
                                            sao
                                        </p>
                                        <div class="mx-auto">
                                            <div class="my-auto mx-auto">
                                                <v-rating
                                                    v-model="rating"
                                                    color="yellow-darken-3"
                                                    half-increments
                                                ></v-rating>
                                            </div>
                                            <div class="my-auto mx-auto">
                                                <Link
                                                    :href="
                                                        route('rating.store')
                                                    "
                                                    :key="product.id"
                                                    method="post"
                                                    :data="{
                                                        productId: product.id,
                                                        rating: rating,
                                                    }"
                                                    as="button"
                                                    class="bg-blue-700 hover:bg-blue-600 text-white font-semibold px-4 rounded-lg shadow ml-2 h-10"
                                                    >Đánh giá</Link
                                                >
                                            </div>
                                        </div>
                                    </div>
                                </v-col>
                            </v-row>
                            <!-- <v-row>
                                <v-col cols="6" md="2">
                                    <v-img
                                        class="rounded-lg cursor-grabbing"
                                        :src="getImageUrl(product.image)"
                                        width="150"
                                    ></v-img>
                                </v-col>
                                <v-col cols="3" md="2">
                                    <v-img
                                        class="rounded-lg cursor-grabbing"
                                        :src="getImageUrl(product.image)"
                                        width="150"
                                    ></v-img>
                                </v-col>
                                <v-col md="2">
                                    <v-img
                                        class="rounded-lg cursor-grabbing"
                                        :src="getImageUrl(product.image)"
                                        width="150"
                                    ></v-img>
                                </v-col>
                                <v-col md="2">
                                    <v-img
                                        class="rounded-lg cursor-grabbing"
                                        :src="getImageUrl(product.image)"
                                        width="150"
                                    ></v-img>
                                </v-col>
                            </v-row> -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-5">
                <div>
                    <v-card elevation="3">
                        <v-card-item>
                            <v-card-title>{{ product.name }}</v-card-title>

                            <v-card-subtitle>
                                <span class="me-1">Món ăn được yêu thích</span>

                                <v-icon
                                    color="error"
                                    icon="mdi-fire-circle"
                                    size="small"
                                ></v-icon>
                            </v-card-subtitle>
                        </v-card-item>

                        <v-card-text>
                            <v-row align="center" class="mx-0">
                                <v-rating
                                    :model-value="5"
                                    color="amber"
                                    density="compact"
                                    half-increments
                                    readonly
                                    size="small"
                                ></v-rating>

                                <div class="text-grey ms-4">4.5 (413)</div>
                            </v-row>

                            <div class="my-4 text-subtitle-1">
                                {{ product.price }} VND
                            </div>

                            <div>{{ product.desc }}</div>
                        </v-card-text>
                    </v-card>
                </div>
            </div>
            <hr class="mt-2 mb-2" />
            <div class="mt-5">
                <div class="font-bold">
                    Bình Luận ({{ productComments.length }})
                </div>

                <v-table>
                    <tbody>
                        <tr
                            v-for="comment in productComments"
                            :key="comment.id"
                        >
                            <td>
                                <span>{{ comment.users.name }}: </span>
                                <span>{{ comment.content }} </span>
                                <span
                                    >--------------{{
                                        formatDate(comment.created_at)
                                    }}</span
                                >
                            </td>
                        </tr>
                    </tbody>
                </v-table>
                <div class="mb-5">
                    <div v-if="isProductPurchased">
                        <div class="flex mb-16">
                            <v-textarea
                                class=""
                                label="bình luận"
                                rows="1"
                                v-model="cmt_content"
                                prepend-icon="mdi-comment"
                            ></v-textarea>
                            <input type="hidden" v-model="productId" />
                            <Link
                                :href="route('comment.store')"
                                :key="product.id"
                                method="post"
                                :data="{
                                    productId: product.id,
                                    cmt_content: cmt_content, // Số lượng sản phẩm mặc định có thể thay đổi tùy ý
                                }"
                                as="button"
                                class="bg-blue-700 hover:bg-blue-600 text-white font-semibold px-4 rounded-lg shadow ml-2 mr-36 h-14"
                                >Gửi</Link
                            >
                        </div>
                    </div>
                </div>
            </div>

            <div class="fixed bottom-4 right-4">
                <!-- <label for="">Số lượng: </label>
                <input
                    type="number"
                    v-model="quantity"
                    class="bg-gray-50 border border-gray-300 rounded-lg w-20 h-9"
                /> -->
                <!-- <input type="hidden" v-model="productId" />
                <Link
                    :href="route('cart.store')"
                    :key="product.id"
                    method="post"
                    :data="{
                        productId: product.id,
                        quantity: quantity,
                    }"
                    as="button"
                    @click="placeOrder"
                    class="bg-cyan-darken-1 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg shadow"
                    >CHỌN MUA</Link
                > -->
                <button
                    @click="dialog = true"
                    class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded-lg shadow"
                >
                    CHỌN MUA
                </button>
            </div>
        </div>
        <v-dialog
            v-model="dialog"
            :scrim="false"
            transition="dialog-bottom-transition"
        >
            <v-row class="absolute right-9 bg-green-500 rounded-t-lg w-20">
                <v-btn
                        color="white"
                        variant="text"
                        @click="dialog = false"
                        icon="mdi mdi-close-thick"
                        density="comfortable"
                        class="mx-auto"
                    >
                    </v-btn>
            </v-row>
            <Topping :toppings="product.toppings" :product="product">
                
            </Topping>
        </v-dialog>
    </div>
</template>
