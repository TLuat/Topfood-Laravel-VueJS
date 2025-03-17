<script setup>
import { Head, Link } from "@inertiajs/vue3";
import { ref, computed, shallowRef } from "vue";

const props = defineProps({
    menus: {
        type: Array,
        required: true,
    },
});
const getImageUrl = (imageName) => {
    return `/storage/${imageName}`;
};
const tab = ref(null);

const itemsPerPage = ref(10); // Số lượng mục hiển thị trên mỗi trang
const currentPage = ref(1); // Trang hiện tại
// Tính toán trang hiện tại của dữ liệu
const paginatedMenus = computed(() => {
  const startIndex = (currentPage.value - 1) * itemsPerPage.value;
  const endIndex = startIndex + itemsPerPage.value;
  return props.menus.slice(startIndex, endIndex);
});

// Tính toán tổng số trang
const totalPages = computed(() => {
  return Math.ceil(props.menus.length / itemsPerPage.value);
});

// Xử lý sự kiện khi thay đổi trang
const changePage = (page) => {
  currentPage.value = page;
};
</script>

<template>
    <div class="max-w-7xl mx-auto p-6 lg:p-8 mt-26 backdrop-blur-lg">
        <v-card color="basil">
            <v-card-title class="text-center justify-center py-6">
                <h1 class="font-weight-bold text-h2 text-basil">Thực Đơn</h1>
            </v-card-title>

            <v-tabs v-model="tab" bg-color="transparent" color="basil" grow>
                <v-tab :value="t1"> Sáng </v-tab>
                <v-tab :value="t2"> Trưa </v-tab>
                <v-tab :value="t3"> Chiều </v-tab>
                <v-tab :value="t4"> Tối </v-tab>
            </v-tabs>

            <v-window v-model="tab">
                <v-window-item :value="t1">
                    <v-card color="basil" flat>
                        <div
                            class=""
                        >
                            <template v-for="menu in paginatedMenus" :key="menu.id">
                                <div
                                    class=""
                                    v-if="menu.meal_time === 'SÁNG'"
                                >
                                    <div>
                                        <v-card
                                            elevation="1"
                                            class="mx-auto rounded-lg flex"
                                            max-width=""
                                            height="300"
                                        >
                                            <v-img
                                                cover
                                                class="p-20 rounded-t-lg"
                                                height="20"
                                                :src="getImageUrl(menu.img)"
                                                alt="menu image"
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
                                            </v-img>

                                            <v-card-item>
                                                <v-card-title class="text-sm"
                                                    ><span class="text-md">{{
                                                        menu.name
                                                    }}</span></v-card-title
                                                >
                                                <v-card-subtitle>
                                                    <span class="me-1">{{
                                                        menu.desc
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
                                                    >{{ menu.taste }}</span
                                                >
                                            </p>
                                            <v-card-text>
                                                <div
                                                    class="mt-2 text-right text-subtitle-1 text-red-500"
                                                >
                                                    {{
                                                        parseFloat(
                                                            menu.price
                                                        ).toLocaleString(
                                                            "vi-VN",
                                                            {
                                                                style: "currency",
                                                                currency: "VND",
                                                            }
                                                        )
                                                    }}
                                                </div>
                                            </v-card-text>
                                        </v-card>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </v-card>
                    <!-- Phân trang -->
                    <v-pagination
                    v-model="currentPage"
                    :length="totalPages"
                    @input="changePage"
                    ></v-pagination>
                </v-window-item>
                <v-window-item :value="t2">
                    <v-card color="basil" flat>
                        <v-card-text>
                            <div
                                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 p-6 bg-cover bg-center lg:gap-6 cursor-pointer min-w-1/4"
                            >
                                <template v-for="menu in menus" :key="menu.id">
                                    <div
                                        class="from-gray-700 via-transparent motion-safe:hover:scale-[1.05] border-2 hover:border-blue-500 hover:border-2 transition-all duration-300 focus:outline focus:outline-4 focus:outline-red-500 ease-in-out rounded-lg"
                                        v-if="menu.meal_time === 'TRƯA'"
                                    >
                                        <div>
                                            <v-card
                                                elevation="1"
                                                class="mx-auto rounded-lg flex"
                                                max-width=""
                                                height="300"
                                            >
                                                <v-img
                                                    cover
                                                    class="p-20 rounded-t-lg"
                                                    height="20"
                                                    :src="getImageUrl(menu.img)"
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
                                                                menu.name
                                                            }}</span
                                                        ></v-card-title
                                                    >
                                                    <v-card-subtitle>
                                                        <span class="me-1">{{
                                                            menu.desc
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
                                                        >{{ menu.taste }}</span
                                                    >
                                                </p>
                                                <v-card-text>
                                                    <div
                                                        class="mt-2 text-right text-subtitle-1 text-red-500"
                                                    >
                                                        {{
                                                            parseFloat(
                                                                menu.price
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
                            </div>
                        </v-card-text>
                    </v-card>
                </v-window-item>
                <v-window-item :value="t3">
                    <v-card color="basil" flat>
                        <v-card-text>
                            <div
                                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 p-6 bg-cover bg-center lg:gap-6 cursor-pointer min-w-1/4"
                            >
                                <template v-for="menu in menus" :key="menu.id">
                                    <div
                                        class="from-gray-700 via-transparent motion-safe:hover:scale-[1.05] border-2 hover:border-blue-500 hover:border-2 transition-all duration-300 focus:outline focus:outline-4 focus:outline-red-500 ease-in-out rounded-lg"
                                        v-if="menu.meal_time === 'CHIỀU'"
                                    >
                                        <div>
                                            <v-card
                                                elevation="1"
                                                class="mx-auto rounded-lg flex"
                                                max-width=""
                                                height="300"
                                            >
                                                <v-img
                                                    cover
                                                    class="p-20 rounded-t-lg"
                                                    height="20"
                                                    :src="getImageUrl(menu.img)"
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
                                                                menu.name
                                                            }}</span
                                                        ></v-card-title
                                                    >
                                                    <v-card-subtitle>
                                                        <span class="me-1">{{
                                                            menu.desc
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
                                                        >{{ menu.taste }}</span
                                                    >
                                                </p>
                                                <v-card-text>
                                                    <div
                                                        class="mt-2 text-right text-subtitle-1 text-red-500"
                                                    >
                                                        {{
                                                            parseFloat(
                                                                menu.price
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
                            </div>
                        </v-card-text>
                    </v-card>
                </v-window-item>
                <v-window-item :value="t4">
                    <v-card color="basil" flat>
                        <v-card-text>
                            <div
                                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 p-6 bg-cover bg-center lg:gap-6 cursor-pointer min-w-1/4"
                            >
                                <template v-for="menu in menus" :key="menu.id">
                                    <div
                                        class="from-gray-700 via-transparent motion-safe:hover:scale-[1.05] border-2 hover:border-blue-500 hover:border-2 transition-all duration-300 focus:outline focus:outline-4 focus:outline-red-500 ease-in-out rounded-lg"
                                        v-if="menu.meal_time === 'TỐI'"
                                    >
                                        <div>
                                            <v-card
                                                elevation="1"
                                                class="mx-auto rounded-lg flex"
                                                max-width=""
                                                height="300"
                                            >
                                                <v-img
                                                    cover
                                                    class="p-20 rounded-t-lg"
                                                    height="20"
                                                    :src="getImageUrl(menu.img)"
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
                                                                menu.name
                                                            }}</span
                                                        ></v-card-title
                                                    >
                                                    <v-card-subtitle>
                                                        <span class="me-1">{{
                                                            menu.desc
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
                                                        >{{ menu.taste }}</span
                                                    >
                                                </p>
                                                <v-card-text>
                                                    <div
                                                        class="mt-2 text-right text-subtitle-1 text-red-500"
                                                    >
                                                        {{
                                                            parseFloat(
                                                                menu.price
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
                            </div>
                        </v-card-text>
                    </v-card>
                </v-window-item>
            </v-window>
        </v-card>
    </div>
</template>
