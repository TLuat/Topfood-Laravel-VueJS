<script setup>
import { Head, Link } from "@inertiajs/vue3";
import { ref, computed, shallowRef } from "vue";
import Header from "../Layouts/Header.vue";
import RightSideBar from "../Layouts/RightSideBar.vue";
import MenuList from "./MenuList.vue";

const props = defineProps({
    menus: {
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
});
const getImageUrl = (imageName) => {
    return `/storage/${imageName}`;
};

const drawer = shallowRef(true);
const rail = shallowRef(true);

const selectedCriteria = ref({
    taste: "",
    nutrition: "",
    preferences: [],
    occasion: "",
    diners: ""
});

const recommendedMenus = ref(props.menus);

const generateRecommendations = () => {
    recommendedMenus.value = props.menus.filter((menu) => {
        const selectedTaste = selectedCriteria.value.taste;
        const selectedNutrition = selectedCriteria.value.nutrition;
        const selectedPreferences = selectedCriteria.value.preferences;
        const selectedOccasion = selectedCriteria.value.occasion;
        const selectedDiners = selectedCriteria.value.diners;

        const menuPreferences = menu.preferences
            .split(",")
            .map((preference) => preference.trim());

        return (
            (selectedTaste === "" || menu.taste === selectedTaste) &&
            (selectedNutrition === "" ||
                menu.nutritionNeeds === selectedNutrition) &&
            (selectedPreferences.length === 0 ||
                selectedPreferences.every((preference) =>
                    menuPreferences.includes(preference)
                )) &&
            (selectedOccasion === "" || menu.occasion === selectedOccasion)&&
            (selectedDiners === "" || menu.diners === selectedDiners)
        );
    });
};

const resetOptions = () => {
    selectedCriteria.value.taste = "";
    selectedCriteria.value.nutrition = "";
    selectedCriteria.value.preferences = [];
    selectedCriteria.value.occasion = "";
    selectedCriteria.value.diners = "";
    generateRecommendations();
};
const itemsPerPage = ref(4);
const search = ref("");
const onClickSeeAll = () => {
    itemsPerPage.value = itemsPerPage.value === 4 ? props.menus.length : 4;
};
const isFavorite = ref(false);

const toggleFavorite = () => {
    isFavorite.value = !isFavorite.value;
};
</script>

<template>
    <Head title="Thực Đơn" />
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
                <RightSideBar :orders="orders" :carts="carts" />
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
    <div class="container mx-auto py-8 mt-13">
        <header class="bg-blue-500 p-4 text-white">
            <h1 class="text-3xl">Đề Xuất Thực Đơn</h1>
        </header>
        <div class="bg-white p-4 rounded shadow-md text-center">
            <h2 class="text-2xl mb-4">
                Chọn các yếu tố sau để nhận đề xuất thực đơn:
            </h2>
            <div id="menu-form" class="space-y-4">
                <table class="mx-auto">
                    <tr>
                        <td>
                            <label
                                for="taste"
                                class="block text-sm font-medium text-gray-700 my-auto mr-2"
                                >Khẩu Vị:</label
                            >
                        </td>
                        <td>
                            <select
                                class="mt-1 p-2 w-72 border rounded"
                                v-model="selectedCriteria.taste"
                            >
                                <option value="" selected>
                                    -- Chọn Khẩu Vị --
                                </option>
                                <option value="Ngọt">Ngọt</option>
                                <option value="Cay">Cay</option>
                                <option value="Mặn">Mặn</option>
                                <option value="Đắng">Đắng</option>
                                <option value="Chua">Chua</option>
                                <option value="Cân đối">Cân đối</option>
                            </select>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            <label
                                for="nutrition"
                                class="block text-sm font-medium text-gray-700 my-auto mr-2"
                                >Nhu Cầu Dinh Dưỡng:</label
                            >
                        </td>
                        <td>
                            <select
                                class="mt-1 p-2 w-72 border rounded"
                                v-model="selectedCriteria.nutrition"
                            >
                                <option value="" selected>
                                    -- Chọn Nhu Cầu Dinh Dưỡng --
                                </option>
                                <option value="Giảm cân">Giảm cân</option>
                                <option value="Nhiều protein">
                                    Nhiều protein
                                </option>
                                <option value="Nhiều đạm">Nhiều đạm</option>
                                <option value="Chất xơ">Chất xơ</option>
                                <option value="Chất béo">Chất béo</option>
                                <option value="Cân đối">Cân đối</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label
                                for="nutrition"
                                class="block text-sm font-medium text-gray-700 my-auto mr-2"
                                >Số Người Ăn:</label
                            >
                        </td>
                        <td>
                            <select
                                class="mt-1 p-2 w-72 border rounded"
                                v-model="selectedCriteria.diners"
                            >
                                <option value="" selected>
                                    -- Số người Ăn --
                                </option>
                                <option value="2">2 người</option>
                                <option value="3">
                                   3 người
                                </option>
                                <option value="4">4 người</option>
                                <option value="5">5 người</option>
                                <option value="6">6 người</option>
                            </select>
                        </td>
                    </tr>
                </table>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700"
                        >Sở Thích:</label
                    >
                    <div class="mt-1 space-x-4">
                        <label class="inline-flex items-center">
                            <input
                                type="checkbox"
                                value="Hải sản"
                                class="form-checkbox"
                                v-model="selectedCriteria.preferences"
                            />
                            <span class="ml-2">Hải sản</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input
                                type="checkbox"
                                value="Chay"
                                class="form-checkbox"
                                v-model="selectedCriteria.preferences"
                            />
                            <span class="ml-2">Chay</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input
                                type="checkbox"
                                value="Có cồn"
                                class="form-checkbox"
                                v-model="selectedCriteria.preferences"
                            />
                            <span class="ml-2">Có cồn</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input
                                type="checkbox"
                                value="Nướng"
                                class="form-checkbox"
                                v-model="selectedCriteria.preferences"
                            />
                            <span class="ml-2">Nướng</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input
                                type="checkbox"
                                value="Kho"
                                class="form-checkbox"
                                v-model="selectedCriteria.preferences"
                            />
                            <span class="ml-2">Kho</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input
                                type="checkbox"
                                value="Chiên"
                                class="form-checkbox"
                                v-model="selectedCriteria.preferences"
                            />
                            <span class="ml-2">Chiên</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input
                                type="checkbox"
                                value="Canh"
                                class="form-checkbox"
                                v-model="selectedCriteria.preferences"
                            />
                            <span class="ml-2">Món Canh</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input
                                type="checkbox"
                                value="Cay"
                                class="form-checkbox"
                                v-model="selectedCriteria.preferences"
                            />
                            <span class="ml-2">Cay</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input
                                type="checkbox"
                                value="Món Ý"
                                class="form-checkbox"
                                v-model="selectedCriteria.preferences"
                            />
                            <span class="ml-2">Món Ý</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input
                                type="checkbox"
                                value="Món Trung"
                                class="form-checkbox"
                                v-model="selectedCriteria.preferences"
                            />
                            <span class="ml-2">Món Trung</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input
                                type="checkbox"
                                value="Món Nhật"
                                class="form-checkbox"
                                v-model="selectedCriteria.preferences"
                            />
                            <span class="ml-2">Món Nhật</span>
                        </label>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700"
                        >Dịp Ăn Uống:</label
                    >
                    <div class="mt-1 space-x-4">
                        <label class="inline-flex items-center">
                            <input
                                type="radio"
                                name="occasion"
                                value="Sinh nhật"
                                class="form-radio"
                                v-model="selectedCriteria.occasion"
                            />
                            <span class="ml-2">Sinh nhật</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input
                                type="radio"
                                name="occasion"
                                value="Kỷ niệm"
                                class="form-radio"
                                v-model="selectedCriteria.occasion"
                            />
                            <span class="ml-2">Kỷ niệm</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input
                                type="radio"
                                name="occasion"
                                value="Thường ngày"
                                class="form-radio"
                                v-model="selectedCriteria.occasion"
                            />
                            <span class="ml-2">Thường ngày</span>
                        </label>
                    </div>
                </div>
                <div class="space-x-10 mx-auto mt-6">
                    <button
                        class="bg-blue-500 text-white p-2 rounded hover:bg-blue-600"
                        @click="resetOptions"
                    >
                        Làm Mới
                    </button>
                    <button
                        class="bg-blue-500 text-white p-2 rounded hover:bg-blue-600"
                        @click="generateRecommendations"
                    >
                        Nhận Đề Xuất Thực Đơn
                    </button>
                </div>
            </div>
        </div>

        <div class="mt-8">
            <h2 class="text-3xl text-blue-900 font-semibold">
                Đề Xuất Thực Đơn Cho Bạn
            </h2>
            <div class="backdrop-blur-sm">
                <div
                    class="max-w-7xl mx-auto p-6 lg:p-8 mt-26 backdrop-blur-lg"
                >
                    <div
                        class="px-8 border rounded-lg backdrop-opacity-10 bg-repeat"
                    >
                        <v-layout>
                            <v-data-iterator
                                :items="recommendedMenus"
                                item-value="name"
                                :items-per-page="itemsPerPage"
                                :search="search"
                            >
                                <template v-slot:header="{}">
                                    <div
                                        class="text-h4 font-weight-bold flex justify-between bg-gray-100 p-2 mb-4 align-center"
                                    >
                                        <v-text-field
                                            v-model="search"
                                            clearable
                                            density="comfortable"
                                            hide-details
                                            placeholder="Tìm kiếm thực đơn"
                                            prepend-inner-icon="mdi-magnify"
                                            style="max-width: 300px"
                                            variant="solo"
                                        ></v-text-field>

                                        <div class="">
                                            <v-btn
                                                class="me-8"
                                                variant="text"
                                                @click="onClickSeeAll"
                                            >
                                                <span
                                                    class="text-decoration-underline text-none"
                                                    >Xem tất cả</span
                                                >
                                            </v-btn>
                                        </div>
                                    </div>
                                </template>
                                <template
                                    v-slot:default="{
                                        items,
                                        isExpanded,
                                        toggleExpand,
                                    }"
                                >
                                    <div
                                        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 p-2 bg-cover bg-center lg:gap-6 min-w-1/4"
                                    >
                                        <div
                                            v-for="item in items"
                                            :key="item.raw.id"
                                        >
                                            <v-card
                                                elevation="1"
                                                class="mx-auto rounded-lg flex"
                                                max-width="300"
                                                min-width="280"
                                            >
                                                <v-img
                                                    cover
                                                    class="p-20 rounded-t-lg"
                                                    height="20"
                                                    :src="
                                                        getImageUrl(
                                                            item.raw.img
                                                        )
                                                    "
                                                    alt="menu image"
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
                                                    <v-card-title
                                                        class="text-sm"
                                                        ><span
                                                            class="text-md"
                                                            >{{
                                                                item.raw.name
                                                            }}</span
                                                        ></v-card-title
                                                    >
                                                    <v-card-subtitle>
                                                        <span class="me-1">{{
                                                            item.raw.desc
                                                        }}</span>
                                                        <v-icon
                                                            color="error"
                                                            icon="mdi-fire-circle"
                                                            size="small"
                                                        ></v-icon>
                                                    </v-card-subtitle>
                                                </v-card-item>
                                                <p
                                                    class="absolute bg-blue-700 top-0"
                                                >
                                                    <span
                                                        class="p-1 text-white font-bold"
                                                        >{{
                                                            item.raw.taste
                                                        }}</span
                                                    >
                                                </p>
                                                <p
                                                    class="absolute bottom-6 right-2 rounded-lg text-2xl border-2"
                                                >
                                                    <v-icon
                                                        @click="toggleFavorite"
                                                        :color="
                                                            isFavorite
                                                                ? 'red'
                                                                : 'yellow'
                                                        "
                                                        >mdi-heart</v-icon
                                                    >
                                                </p>
                                                <v-card-text>
                                                    <div
                                                        class="mt-2 text-right text-subtitle-1 "
                                                    >
                                                        Giá: <span class="text-red-500">{{
                                                            parseFloat(
                                                                item.raw.price
                                                            ).toLocaleString(
                                                                "vi-VN",
                                                                {
                                                                    style: "currency",
                                                                    currency:
                                                                        "VND",
                                                                }
                                                            )
                                                        }}</span>
                                                    </div>
                                                </v-card-text>
                                                <div class="px-4">
                                                    <v-switch
                                                        @click="
                                                            () =>
                                                                toggleExpand(
                                                                    item
                                                                )
                                                        "
                                                        :model-value="
                                                            isExpanded(item)
                                                        "
                                                        :label="`${
                                                            isExpanded(item)
                                                                ? 'Ẩn'
                                                                : 'Hiện'
                                                        } Món`"
                                                        density="compact"
                                                        inset
                                                        color="success"
                                                    ></v-switch>
                                                </div>

                                                <v-divider></v-divider>

                                                <v-expand-transition>
                                                    <div
                                                        v-if="isExpanded(item)"
                                                    >
                                                        <v-list
                                                            density="compact"
                                                            :lines="false"
                                                        >
                                                            <template
                                                                v-for="food in item
                                                                    .raw
                                                                    .products"
                                                                :key="food.id"
                                                            >
                                                                <v-list-item
                                                                    :title="`🍔 ${food.name}`"
                                                                ></v-list-item>
                                                            </template>
                                                        </v-list>
                                                    </div>
                                                </v-expand-transition>
                                                <p
                                                    class="absolute bottom-6 right-2 rounded-lg text-2xl border-2"
                                                >
                                                    <v-icon
                                                        @click="toggleFavorite"
                                                        :color="
                                                            isFavorite
                                                                ? 'red'
                                                                : 'yellow'
                                                        "
                                                        >mdi-heart</v-icon
                                                    >
                                                </p>
                                            </v-card>
                                        </div>
                                    </div>
                                </template>
                                <template
                                    v-slot:footer="{
                                        page,
                                        pageCount,
                                        prevPage,
                                        nextPage,
                                    }"
                                >
                                    <div
                                        class="d-flex align-center justify-center pa-4"
                                    >
                                        <v-btn
                                            :disabled="page === 1"
                                            icon="mdi-arrow-left"
                                            density="comfortable"
                                            variant="tonal"
                                            rounded
                                            @click="prevPage"
                                        ></v-btn>

                                        <div class="mx-2 text-caption">
                                            Trang {{ page }} trên
                                            {{ pageCount }}
                                        </div>

                                        <v-btn
                                            :disabled="page >= pageCount"
                                            icon="mdi-arrow-right"
                                            density="comfortable"
                                            variant="tonal"
                                            rounded
                                            @click="nextPage"
                                        ></v-btn>
                                    </div>
                                </template>
                            </v-data-iterator>
                        </v-layout>
                    </div>
                </div>
            </div>

            <div class="backdrop-blur-sm">
                <MenuList :menus="menus" />
            </div>
        </div>
    </div>
</template>
