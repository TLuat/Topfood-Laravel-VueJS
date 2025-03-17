<script setup>
import { Link } from "@inertiajs/vue3";
import { Head } from "@inertiajs/vue3";
import Header from "../Layouts/Header.vue";
import Footer from "../Layouts/Footer.vue";
import { initFlowbite } from "flowbite";
import { ref, onMounted, onBeforeUnmount, shallowRef } from "vue";
import { reactive } from "vue";
import ProductDetail from "./ProductDetail.vue";
import Suggestion from "./Suggestion.vue";
import SideBar from "../Layouts/SideBar.vue";
import RightSideBar from "../Layouts/RightSideBar.vue";
import { computed } from "vue";

// initialize components based on data attribute selectors
onMounted(() => {
    initFlowbite();
    //     window.onload = () => {
    //         loading.value = false;
    //   };
});

const props = defineProps({
    products: {
        type: Array,
        required: true,
    },
    categories: {
        type: Array,
        required: true,
    },
    carts: {
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
    toppings: {
        type: Object,
        required: true,
    },
    weather: {
        type: Object,
        required: true,
    },
});

const dialog = ref(false);
const selectedProduct = ref(null);

const handleAddButtonClick = (product) => {
    selectedProduct.value = product;
    dialog.value = true;
};

const getImageUrl = (imageName) => {
    return `/storage/${imageName}`;
};

//tìm kiếm
const search = ref(null);
const priceRange = ref(null);
const selectedCategoryCard = ref(null);
const filteredProducts = computed(() => {
    let filtered = props.products;

    // Lọc theo từ khóa tìm kiếm
    if (search.value) {
        const searchTerm = search.value.toLowerCase();
        filtered = filtered.filter((product) => {
            return product.name.toLowerCase().includes(searchTerm);
        });
    }
    // Lọc theo danh mục
    if (selectedCategoryCard.value) {
        const categoryName = selectedCategoryCard.value;
        filtered = filtered.filter((product) => {
            return (
                product.categories.name.toLowerCase() ===
                categoryName.toLowerCase()
            );
        });
    }
    // Lọc theo khoảng giá
    if (priceRange.value) {
        if (priceRange.value === "Dưới 100k") {
            filtered = filtered.filter((product) => {
                return product.price < 100000;
            });
        } else if (priceRange.value === "100k - 200k") {
            filtered = filtered.filter((product) => {
                return product.price >= 100000 && product.price <= 200000;
            });
        } else if (priceRange.value === "Trên 200k") {
            filtered = filtered.filter((product) => {
                return product.price > 200000;
            });
        }
    }

    return filtered;
});

const handleCategoryCardClick = (categoryName) => {
    if (selectedCategoryCard.value === categoryName) {
        selectedCategoryCard.value = null;
    } else {
        selectedCategoryCard.value = categoryName;
    }
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

const drawer = shallowRef(true);
const rail = shallowRef(true);
const overlay = ref(false);
//phân trang
const itemsPerPage = ref(15); // Số lượng mục hiển thị trên mỗi trang
const currentPage = ref(1); // Trang hiện tại

// Tính toán trang hiện tại của dữ liệu đã lọc
const paginatedProducts = computed(() => {
  const startIndex = (currentPage.value - 1) * itemsPerPage.value;
  const endIndex = startIndex + itemsPerPage.value;
  return filteredProducts.value.slice(startIndex, endIndex);
});

// Tính toán tổng số trang
const totalPages = computed(() => {
  return Math.ceil(filteredProducts.value.length / itemsPerPage.value);
});

// Xử lý sự kiện khi thay đổi trang
const changePage = (page) => {
  currentPage.value = page;
};

</script>

<template>
    <Head title="Trang chủ" />

    <div class="">
        <v-layout class="">
            <v-navigation-drawer
                location="right"
                temporary
                v-model="drawer"
                :rail="rail"
                @click.stop="rail = false"
                permanent
            >
                <div class="flex-col justify-self-center">
                    <v-list-item
                        prepend-avatar="https://img.freepik.com/premium-vector/cute-orange-robot-cat-avatar_79416-86.jpg?w=2000"
                        :title="$page.props.auth.user.name"
                        nav
                    >
                        <template v-slot:append>
                            <v-btn
                                variant="text"
                                icon="mdi-chevron-right"
                                @click.stop="rail = !rail"
                            ></v-btn>
                        </template>
                    </v-list-item>
                    <hr />
                    <v-divider color="black" class="bg-black"></v-divider>
                    <RightSideBar
                        :orders="orders"
                        :carts="carts"
                        :products="products"
                        :comments="comments"
                        :ratings="ratings"
                        :toppings="toppings"
                    />
                    <v-divider></v-divider>
                    <hr />
                    <Link :href="route('logout')" method="post" as="button">
                        <v-list-item
                            title="Đăng xuất"
                            value="logout"
                            color="#FF3D00"
                            class=""
                            prepend-icon="mdi-logout"
                        >
                        </v-list-item>
                    </Link>
                </div>
            </v-navigation-drawer>
        </v-layout>
        <Header></Header>
        <div class="backdrop-blur-sm">
            <div>
                <div
                    class="max-w-6xl p-4 lg:p-2 mx-auto mt-28 bg-cover bg-center rounded-lg shadow-lg shadow-purple-950"
                    style="background-image: url('/images/bg4.jpg')"
                >
                    <v-row justify="space-around border-2 rounded">
                        <v-col
                            cols="3"
                            class="border-r-2 border-slate-300 rounded"
                        >
                            <v-card class="h-96 bg-white">
                                <v-list>
                                    <v-list-subheader
                                        >THỰC ĐƠN</v-list-subheader
                                    >
                                    <hr />
                                    <v-list-item value="eat" href="#allfood">
                                        <template v-slot:prepend>
                                            <v-icon
                                                class="text-red-700"
                                                icon="mdi-noodles"
                                            ></v-icon>
                                        </template>
                                        <v-list-item-title>
                                            Món ăn</v-list-item-title
                                        >
                                    </v-list-item>

                                    <hr class="w-52 mx-auto" />
                                    <v-list-item value="drink" href="#drink">
                                        <template v-slot:prepend>
                                            <v-icon
                                                icon="mdi-beer-outline"
                                                class="text-cyan-700"
                                            ></v-icon>
                                        </template>
                                        <v-list-item-title
                                            >Đồ uống</v-list-item-title
                                        >
                                    </v-list-item>
                                </v-list>
                            </v-card>
                        </v-col>
                        <v-col
                            cols="6"
                            class="shadow-lg shadow-blue-500 hover:shadow-blue-700"
                        >
                            <v-carousel
                                cycle
                                :interval="3500"
                                show-arrows="hover"
                                class="rounded-lg shadow-2xl bg-black border-2"
                                delimiter-icon="mdi-fire-circle"
                                color="white"
                                progress="blue"
                                height="375"
                            >
                                <template
                                    v-for="product in products
                                        .slice(-3)
                                        .reverse()"
                                    :key="product.id"
                                >
                                    <v-carousel-item
                                        :src="getImageUrl(product.image)"
                                        class=""
                                        cover
                                    >
                                        <template v-slot:placeholder>
                                            <v-row
                                                class="fill-height ma-0"
                                                align="center"
                                                justify="center"
                                            >
                                                <v-progress-circular
                                                    indeterminate
                                                    color="grey lighten-5"
                                                ></v-progress-circular>
                                            </v-row>
                                        </template>
                                    </v-carousel-item>
                                </template>
                            </v-carousel>
                        </v-col>
                        <v-col cols="3">
                            <div
                                v-for="product in products.slice(-3).reverse()"
                                :key="product.id"
                                class=""
                            >
                                <v-card class="mb-2" rounded="lg">
                                    <v-img
                                        cover
                                        class="p-2 rounded-lg border-2 hover:border-blue-500 cursor-pointer"
                                        width="300"
                                        height="120"
                                        :src="getImageUrl(product.image)"
                                        alt="product image"
                                    ></v-img>
                                </v-card>
                            </div>
                        </v-col>
                    </v-row>
                </div>

                <div
                    class="max-w-7xl mx-auto p-6 lg:p-8 mt-26 backdrop-blur-lg"
                >
                    <div class="">
                        <div class="">
                            <div
                                class="border rounded-lg px-6 mb-10 bg-cyan-500 shadow-lg shadow-blue-100 hover:shadow-blue-300"
                            >
                                <div class="flex justify-between">
                                    <span
                                        class="font-bold text-xl uppercase text-white"
                                        >Đề xuất món ăn cho bạn</span
                                    >
                                    <!-- <span
                                        class="font-bold text-xl inline-block text-white ml-auto underline"
                                        >Xem Tất Cả >></span
                                    > -->
                                </div>

                                <!-- Đề xuất món ăn -->
                                <Suggestion
                                    :orders="orders"
                                    :products="products"
                                    :weather="weather"
                                />
                            </div>
                            <div
                                class="px-8 border rounded-lg backdrop-opacity-10"
                            >
                                <div
                                    class="mb-2 mt-6 border-4 shadow-lg rounded-lg p-2"
                                >
                                    <v-row class="mx-auto my-auto">
                                        <!-- Giá cả -->
                                        <v-col cols="4" md="2">
                                            <v-select
                                                label="Khoảng giá"
                                                :items="[
                                                    'Dưới 100k',
                                                    '100k - 200k',
                                                    'Trên 200k',
                                                ]"
                                                v-model="priceRange"
                                                clearable
                                                density="compact"
                                                variant="solo"
                                            ></v-select>
                                        </v-col>

                                        <v-col cols="4" md="5" class="ml-auto">
                                            <v-combobox
                                                label="Tìm món"
                                                placeholder="Nhập tên món ăn"
                                                :items="
                                                    props.products.map(
                                                        (product) =>
                                                            product.name
                                                    )
                                                "
                                                v-model="search"
                                                prepend-inner-icon="mdi-magnify"
                                                clearable
                                                menu-icon=""
                                                density="compact"
                                                variant="solo"
                                                rounded="xl"
                                                class="shadow-t-2xl"
                                            ></v-combobox>
                                        </v-col>
                                    </v-row>

                                    <!-- Danh mục sản phẩm -->
                                    <v-row class="m-auto">
                                        <v-col
                                            v-for="category in categories"
                                            :key="category.id"
                                        >
                                            <v-card
                                                class="p-16 w-20"
                                                @click="
                                                    handleCategoryCardClick(
                                                        category.name
                                                    )
                                                "
                                                :color="
                                                    selectedCategoryCard ===
                                                    category.name
                                                        ? 'green'
                                                        : ''
                                                "
                                            >
                                                <div class="p-5">
                                                    <v-img
                                                        cover
                                                        class=""
                                                        height="50"
                                                        width="50"
                                                        :src="
                                                            getImageUrl(
                                                                category.image
                                                            )
                                                        "
                                                    >
                                                    </v-img>
                                                </div>
                                                <p class="text-center">
                                                    {{ category.name }}
                                                </p>
                                            </v-card>
                                        </v-col>
                                    </v-row>
                                </div>
                                <p
                                    v-if="filteredProducts == ''"
                                    class="text-h4 font-weight-black text-red"
                                >
                                    Không có sản phẩm này
                                </p>
                                <!-- <div
                                    class="font-bold text-xl uppercase text-white bg-cyan-500 p-2 bg-cover rounded-lg border-2 border-red-700"
                                    style="
                                        background-image: url('/images/header.png');
                                    "
                                    id="allfood"
                                >
                                    <span class="text-red-500"
                                        ><v-icon icon="mdi-noodles"></v-icon
                                    ></span>
                                    Tất cả món ăn
                                </div> -->
                                <div
                                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 p-2 lg:gap-6 cursor-pointer min-w-1/4"
                                >
                                    <template
                                        v-for="product in paginatedProducts"
                                        :key="product.id"
                                    >
                                        <div
                                            class="motion-safe:hover:scale-[1.1] border-1 hover:border-blue-500 hover:border-1 transition-all ease-in-out rounded-lg"
                                        >
                                            <div
                                                @click="
                                                    handleAddButtonClick(
                                                        product
                                                    )
                                                "
                                            >
                                                <v-card
                                                    elevation="18"
                                                    class="mx-auto rounded-lg flex"
                                                    max-width=""
                                                    height="300"
                                                >
                                                    <template
                                                        v-slot:loader="{
                                                            isActive,
                                                        }"
                                                    >
                                                        <v-progress-linear
                                                            :active="isActive"
                                                            color="deep-purple"
                                                            height="4"
                                                            indeterminate
                                                        ></v-progress-linear>
                                                    </template>

                                                    <v-img
                                                        cover
                                                        class="p-20 rounded-t-lg"
                                                        height="20"
                                                        :src="
                                                            getImageUrl(
                                                                product.image
                                                            )
                                                        "
                                                        alt="product image"
                                                    >
                                                        <template
                                                            v-slot:placeholder
                                                        >
                                                            <v-row
                                                                class="fill-height ma-0"
                                                                align="center"
                                                                justify="center"
                                                            >
                                                                <v-progress-circular
                                                                    indeterminate
                                                                    color="grey lighten-5"
                                                                ></v-progress-circular>
                                                            </v-row>
                                                        </template>
                                                    </v-img>

                                                    <v-card-item>
                                                        <v-card-title>{{
                                                            product.name
                                                        }}</v-card-title>

                                                        <v-card-subtitle>
                                                            <span class="me-1"
                                                                >Món ăn được yêu
                                                                thích</span
                                                            >

                                                            <v-icon
                                                                color="error"
                                                                icon="mdi-fire-circle"
                                                                size="small"
                                                            ></v-icon>
                                                        </v-card-subtitle>
                                                    </v-card-item>

                                                    <p
                                                        class="absolute bg-green-500 ml-2 top-0 rounded"
                                                    >
                                                        <span
                                                            class="p-1 text-white font-bold"
                                                            >{{
                                                                product
                                                                    .categories
                                                                    .name
                                                            }}</span
                                                        >
                                                    </p>

                                                    <v-card-text>
                                                        <v-row
                                                            align="center"
                                                            class="text-center mx-auto"
                                                        >
                                                            <v-rating
                                                                :model-value="
                                                                    getProductRating(
                                                                        product.id
                                                                    )
                                                                "
                                                                color="amber"
                                                                density="compact"
                                                                half-increments
                                                                readonly
                                                                size="small"
                                                            ></v-rating>

                                                            <div
                                                                class="text-grey ms-2"
                                                            >
                                                                ({{
                                                                    countProductRating(
                                                                        product.id
                                                                    )
                                                                }})
                                                            </div>
                                                        </v-row>

                                                        <div
                                                            class="mt-6 my-4 text-subtitle-1 text-red-500 text-right"
                                                        >
                                                            {{
                                                                parseFloat(
                                                                    product.price
                                                                ).toLocaleString(
                                                                    "vi-VN",
                                                                    {
                                                                        style: "currency",
                                                                        currency:
                                                                            "VND",
                                                                    }
                                                                )
                                                            }}
                                                        </div>
                                                    </v-card-text>
                                                </v-card>
                                            </div>
                                        </div>
                                    </template>
                                    <!-- Phân trang -->

                                </div>
                                <div class="mt-10">
                                    <v-pagination
                                    v-model="currentPage"
                                    :length="totalPages"
                                    @input="changePage"
                                    ></v-pagination>
                                </div>
                                
                            </div>
                        </div>
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
                                                getProductRating(
                                                    selectedProduct.id
                                                )
                                            "
                                            color="amber"
                                            density="compact"
                                            half-increments
                                            readonly
                                            size="small"
                                        ></v-rating>
                                        ({{
                                            countProductRating(
                                                selectedProduct.id
                                            )
                                        }})
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
                    <Footer></Footer>
                </div>
            </div>
        </div>
    </div>
</template>
