<script setup>
import { Link } from "@inertiajs/vue3";
import { Head } from "@inertiajs/vue3";
import { ref, onMounted } from "vue";
import { router, useForm, usePage } from "@inertiajs/vue3";
import { computed } from "vue";
import { VStepper } from "vuetify/labs/VStepper";

const props = defineProps({
    tables: {
        type: Object,
        required: true,
    },
    menus: {
        type: Object,
        required: true,
    },
    reservation: {
        type: Object,
        required: true,
    },
});

const selectedGuests = ref(null);
const selectedDate = ref(null);
const selectedTime = ref(null);
const groups = ref([2, 3, 4, 5, 6, 7, 8]);
const Time = ref(["8:00:00", "9:00:00", "11:00:00", "14:00:00", "17:00:00", "18:00:00", "20:00:00"]);

const filteredTables = computed(() => {
    if (selectedGuests.value) {
        return props.tables.filter(
            (table) => table.guest_number === selectedGuests.value
        );
    }
    return props.tables;
});
const selectedTable = ref(null);
const selectedTableName = ref(null);
const selectedTableId = ref(null);
const selectTable = (table) => {
    selectedTable.value = table;
    selectedTableName.value = table.name;
    selectedTableId.value = table.id;
};
const getImageUrl = (imageName) => {
    return `/storage/${imageName}`;
};
const activeStep = ref(0);
const goToNextStep = () => {
    if (activeStep.value < 2) {
        activeStep.value++;
    }
};
const goToPreviousStep = () => {
    if (activeStep.value > 0) {
        activeStep.value--;
    }
};
const selectedMenuItems = ref([]);
const isMenuItemSelected = (menu) => {
    return selectedMenuItems.value.includes(menu);
};
const menuQuantities = ref({});
const menuQuantitiesData = computed(() => {
    const data = {};
    selectedMenuItems.value.forEach((menu) => {
        const quantity = menuQuantities.value[menu.id] || 1;
        data[menu.id] = quantity;
    });
    return data;
});
const selectMenuItem = (menu) => {
    const index = selectedMenuItems.value.indexOf(menu);
    if (index === -1) {
        selectedMenuItems.value.push(menu);
        menuQuantities.value[menu.id] = 1;
    } else {
        selectedMenuItems.value.splice(index, 1);
        delete menuQuantities.value[menu.id];
    }
};

const totalPrice = computed(() => {
    let total = 0;
    for (const menuItem of selectedMenuItems.value) {
        const quantity = menuQuantities.value[menuItem.id] || 1;
        total += Number(menuItem.price) * quantity;
    }
    return total;
});
const isTableBooked = computed(() => {
    return (table) => {
        return props.reservation.some((res) => {
            return (
                res.table_id === table.id &&
                res.res_date === selectedDate.value &&
                res.time === selectedTime.value
            );
        });
    };
});
const isTableSelected = computed(() => {
    return (table) => {
        return selectedTableId.value === table.id;
    };
});

const snackbar = ref(false);
const snackbarText = ref("");
const snackbarColor = ref("");
const placeOrder = () => {
    snackbar.value = true;
    snackbarText.value = "Đặt Bàn thành công!";
    snackbarColor.value = "success";
};

const dateValidationRule = (v) => {
  const currentDate = new Date();
  const selected = new Date(v);

  if (selected < currentDate) {
    return "Ngày phải lớn hơn hoặc bằng ngày hiện tại.";
  }

  return true;
};

const timeFrames = ref({
  "8:00:00": "SÁNG",
  "9:00:00": "SÁNG",
  "11:00:00": "TRƯA",
  "14:00:00": "TRƯA",
  "18:00:00": "TỐI",
  "20:00:00": "TỐI"
});

const selectedTimeFrame = computed(() => {
  return timeFrames.value[selectedTime.value] || "";
});

const filteredMenus = computed(() => {
  return props.menus.filter(menu => {
    return menu.meal_time === timeFrames.value[selectedTime.value] || menu.meal_time === null;
  });
});
</script>

<template>
    <Head title="Đặt bàn" />
    <div>
        <p class="bg-slate-100 text-xl uppercase px-2 mb-2 py-2">
            Đặt bàn tại nhà hàng
        </p>

        <v-snackbar
                v-model="snackbar"
                :timeout="2500"
                height="12px"
                location="top"
                :color="snackbarColor"
            >
                <p class="text-lg font-bold">
                    <span class="mdi mdi-check"></span> {{ snackbarText }}
                </p>
            </v-snackbar>

        <v-stepper
            :items="['Bước 1', 'Bước 2']"
            hide-actions
            v-model="activeStep"
            next-text
        >
            <template v-slot:item.1>
                <v-card flat>
                    <div>
                        <h3 class="ml-4 mb-4 bg-slate-100 text-xl">ĐẶT BÀN</h3>
                        <v-row>
                            <v-col>
                                <v-select
                                    :items="groups"
                                    density="compact"
                                    label="-- Số người --"
                                    prepend-icon="mdi-account"
                                    v-model="selectedGuests"
                                ></v-select>
                            </v-col>
                            <v-col>
                                <v-text-field
                                    type="date"
                                    prepend-icon="mdi-calendar-range"
                                    density="compact"
                                    label="-- Chọn ngày --"
                                    v-model="selectedDate"
                                    :rules="[dateValidationRule]"
                                ></v-text-field>
                            </v-col>
                            <v-col>
                                <v-select
                                    :items="Time"
                                    density="compact"
                                    label="-- Chon giờ --"
                                    prepend-icon="mdi-clock"
                                    v-model="selectedTime"
                                ></v-select>
                            </v-col>
                        </v-row>

                        <v-row class="mx-auto border bg-slate-200">
                            <v-col
                                cols="2"
                                v-for="table in filteredTables"
                                :key="table.id"
                            >
                                <v-card
                                    :color="
                                        isTableSelected(table)
                                            ? 'green'
                                            : isTableBooked(table)
                                            ? 'red'
                                            : ''
                                    "
                                    class="cursor-pointer"
                                    @click="isTableSelected(table) || isTableBooked(table) ? null : selectTable(table)"
                                >
                                    <v-row>
                                        <v-col>
                                            <v-card-title class="">{{
                                                table.name
                                            }}</v-card-title>
                                            <v-card-subtitle
                                                v-if="
                                                    table.status === 'Còn Trống'
                                                "
                                                >Trống</v-card-subtitle
                                            >
                                            <v-card-subtitle v-else
                                                >Đầy</v-card-subtitle
                                            >
                                            <v-card-subtitle
                                                >{{
                                                    table.guest_number
                                                }}
                                                người</v-card-subtitle
                                            >
                                        </v-col>
                                        <v-col class="m-auto">
                                            <v-icon size="x-large"
                                                >mdi-table-furniture</v-icon
                                            ></v-col
                                        >
                                    </v-row>
                                </v-card>
                            </v-col>
                        </v-row>

                        <hr />

                        <div class="mt-5 ml-8">
                            <p class="mb-5">Danh sách Thực đơn cho <span class="text-red-500">{{ selectedTime }}</span> giờ <span class="text-red-500">{{ selectedTimeFrame }}</span> </p>
                            <v-row
                                v-for="menu in filteredMenus"
                                :key="menu.id"
                                class="border-t"
                            >
                                <v-col cols="" class="flex my-auto">
                                    <v-img
                                        width="300px"
                                        height="200px"
                                        :src="getImageUrl(menu.img)"
                                    ></v-img>
                                    <div class="ml-4">
                                        <p
                                            class="text-xl text-yellow-700 font-bold mt-4"
                                        >
                                            {{ menu.name }}
                                        </p>

                                        <p class="mt-2">{{ menu.desc }}</p>
                                    </div>
                                </v-col>

                                <v-col
                                    cols=""
                                    class="text-center my-auto mx-auto"
                                >
                                    <p
                                        class="mb-2 font-bold text-red-500 text-xl"
                                    >
                                        {{
                                            parseFloat(
                                                menu.price
                                            ).toLocaleString("vi-VN", {
                                                style: "currency",
                                                currency: "VND",
                                            })
                                        }}
                                    </p>
                                    <template v-if="menu.type !== 'REQ'">
                                        <v-btn
                                            @click="selectMenuItem(menu)"
                                            :color="
                                                isMenuItemSelected(menu)
                                                    ? 'success'
                                                    : 'white'
                                            "
                                            >Chọn</v-btn
                                        >
                                        <v-select
                                            v-if="menu.type !== 'REQ'"
                                            label="-- Số lượng --"
                                            :items="[1, 2, 3, 4, 5, 6]"
                                            class="w-40 text-right m-auto mt-1"
                                            single-line
                                            v-model="menuQuantities[menu.id]"
                                            rounded="lg"
                                            density="compact"
                                        ></v-select>
                                    </template>

                                    <v-btn
                                        v-else
                                        @click="selectMenuItem(menu)"
                                        :color="
                                            isMenuItemSelected(menu)
                                                ? 'success'
                                                : 'white'
                                        "
                                        >Chọn</v-btn
                                    >
                                </v-col>
                            </v-row>
                        </div>

                        <div v-if="selectedTable" class="mt-5 ml-6">
                            <div>
                                <h3 class="mb-4 bg-slate-100 text-xl">
                                    Chi tiết khách
                                </h3>
                                <v-row class="w-96 mx-auto">
                                    <v-text-field
                                        density="compact"
                                        label="Email"
                                        prepend-icon="mdi-email-box"
                                        variant="outlined"
                                        type="email"
                                        readonly
                                        v-model="$page.props.auth.user.email"
                                    ></v-text-field>
                                </v-row>
                                <v-row class="w-96 mx-auto">
                                    <v-text-field
                                        density="compact"
                                        label="Họ tên"
                                        prepend-icon="mdi-account-outline"
                                        variant="outlined"
                                        v-model="$page.props.auth.user.name"
                                    ></v-text-field>
                                </v-row>
                                <v-row class="w-96 mx-auto">
                                    <v-text-field
                                        density="compact"
                                        label="Điện thoại di động"
                                        prepend-icon="mdi-phone"
                                        variant="outlined"
                                        type="number"
                                        v-model="$page.props.auth.user.phone"
                                    ></v-text-field>
                                </v-row>
                                <v-row class="w-96 mx-auto justify">
                                    <v-textarea
                                        name="input-7-1"
                                        label="Lời nhắn cho nhà hàng"
                                        auto-grow
                                        variant="outlined"
                                        prepend-icon="mdi-message-settings-outline"
                                    ></v-textarea>
                                </v-row>
                                <v-row class="w-96 mx-auto">
                                    <v-checkbox
                                        label="Tôi đã đọc lời nhắn từ Nhà hàng phía trên"
                                        color="primary"
                                        hide-details
                                    ></v-checkbox>
                                </v-row>
                                <v-row class="w-96 mx-auto justify">
                                    <v-checkbox
                                        label="Tôi đồng ý với Điều khoản dịch vụ & Chính sách riêng tư"
                                        color="primary"
                                    ></v-checkbox>
                                </v-row>

                                <v-row class="w-96 mx-auto justify-end">
                                    <v-btn color="primary" @click="goToNextStep"
                                        >Bước Tiếp Theo</v-btn
                                    >
                                </v-row>
                            </div>
                            <hr class="m-6" />
                        </div>
                    </div>
                </v-card>
            </template>

            <!-- Bước 2 -->
            <template v-slot:item.2>
                <v-card flat>
                    <v-row>
                        <v-col cols="4" class="border-r">
                            <p>
                                <v-icon>mdi-storefront</v-icon
                                ><span class="ml-2">Top Food</span>
                            </p>
                            <p>
                                <v-icon>mdi-map-marker-outline</v-icon>
                                <span class="ml-2">
                                    Mizuno Bldg. 3F, Minato-ku, Tokyo
                                    106-0031</span
                                >
                            </p>
                            <p>
                                <v-icon>mdi-table-furniture</v-icon
                                ><span class="ml-2">
                                    {{ selectedTableName }}</span
                                >
                            </p>
                            <p>
                                <v-icon>mdi-account-group</v-icon
                                ><span class="ml-2"> {{ selectedGuests }}</span>
                                Người
                            </p>
                            <p>
                                <v-icon>mdi-calendar-range</v-icon
                                ><span class="ml-2"> {{ selectedDate }}</span>
                            </p>
                            <p>
                                <v-icon>mdi-clock-time-eight-outline</v-icon
                                ><span class="ml-2"> {{ selectedTime }}</span>
                            </p>
                            <p>
                                <v-icon>mdi-cash-multiple</v-icon
                                ><span class="ml-2"> {{ totalPrice }} VND</span>
                            </p>
                        </v-col>
                        <v-col cols="8">
                            <p class="font-bold">Chi tiết khách</p>
                            <hr class="font-bold bg-slate-500 h-1" />
                            <p>
                                <span class="font-bold">Tên:</span>
                                {{ $page.props.auth.user.name }}
                            </p>
                            <p>
                                <span class="font-bold">Điện thoại:</span>
                                {{ $page.props.auth.user.phone }}
                            </p>
                            <p>
                                <span class="font-bold">Email:</span>
                                {{ $page.props.auth.user.email }}
                            </p>
                            <p class="font-bold mt-2">Đặt món</p>
                            <hr class="font-bold bg-slate-500 h-1" />
                            <v-row
                                v-for="menu in selectedMenuItems"
                                class="border-b"
                            >
                                <v-col
                                    ><span class="font-bold">{{
                                        menu.name
                                    }}</span></v-col
                                >
                                <v-col
                                    >{{ menuQuantities[menu.id] || 1 }} x
                                    {{
                                        parseFloat(menu.price).toLocaleString(
                                            "vi-VN",
                                            {
                                                style: "currency",
                                                currency: "VND",
                                            }
                                        )
                                    }}</v-col
                                >
                            </v-row>
                            <v-row class="text-center">
                                <v-col>
                                    <p>
                                        <span class="font-bold">Tổng giá:</span>
                                        {{
                                            parseFloat(
                                                totalPrice
                                            ).toLocaleString("vi-VN", {
                                                style: "currency",
                                                currency: "VND",
                                            })
                                        }}
                                    </p>
                                </v-col>
                            </v-row>
                        </v-col>
                    </v-row>
                    <v-row class="w-96 mx-auto justify-end">
                        <v-col>
                            <v-btn color="primary" @click="goToPreviousStep"
                                >Quay Lại/Chỉnh sửa</v-btn
                            ></v-col
                        >
                        <v-col>
                            <Link
                                :href="route('reservation.store')"
                                method="post"
                                as="button"
                                :data="{
                                    userName: $page.props.auth.user.name,
                                    email: $page.props.auth.user.email,
                                    phone: $page.props.auth.user.phone,
                                    res_date: selectedDate,
                                    time: selectedTime,
                                    table_id: selectedTableId,
                                    guest_number: selectedGuests,
                                    selectedMenuItems: selectedMenuItems,
                                    menuQuantitiesData: menuQuantitiesData,
                                    total_price: totalPrice,
                                }"
                                ><v-btn color="primary" @click="placeOrder"
                                    >Xác nhận</v-btn
                                ></Link
                            >
                        </v-col>
                    </v-row>
                </v-card>
            </template>
        </v-stepper>
    </div>
</template>
