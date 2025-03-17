<script setup>
import { Link } from "@inertiajs/vue3";
import { Head } from "@inertiajs/vue3";
import { ref, computed, onMounted } from "vue";
import "chart.js";

const props = defineProps({
    todayRevenue: Number,
    weeklyRevenue: Number,
    monthlyRevenue: Number,
    // orders: {
    //     type: Object,
    //     required: true,
    // },
});
const orders = ref([
    { id: 1, total_price: 100, created_at: "2023-10-15" },
    { id: 2, total_price: 10, created_at: "2023-10-16" },
    { id: 3, total_price: 150, created_at: "2023-10-17" },
    { id: 4, total_price: 0, created_at: "2023-10-18" },
    { id: 5, total_price: 250, created_at: "2023-10-19" },
    { id: 6, total_price: 400, created_at: "2023-10-20" },
    { id: 7, total_price: 350, created_at: "2023-10-21" },
    { id: 8, total_price: 550, created_at: "2023-10-22" },
    { id: 9, total_price: 450, created_at: "2023-10-23" },

    { id: 10, total_price: 0, created_at: "2023-9-18" },
    { id: 11, total_price: 250, created_at: "2023-9-19" },
    { id: 12, total_price: 400, created_at: "2023-9-20" },
    { id: 13, total_price: 350, created_at: "2023-9-21" },
    { id: 14, total_price: 550, created_at: "2023-9-22" },
    { id: 15, total_price: 450, created_at: "2023-9-23" },

    { id: 16, total_price: 350, created_at: "2023-8-21" },
    { id: 17, total_price: 550, created_at: "2023-8-22" },
    { id: 18, total_price: 450, created_at: "2023-8-23" },

    { id: 19, total_price: 350000, created_at: "2023-11-13" },
    { id: 20, total_price: 1350000, created_at: "2023-11-14" },
    { id: 21, total_price: 2450000, created_at: "2023-11-15" },
    { id: 22, total_price: 5565000, created_at: "2023-11-16" },
    { id: 23, total_price: 4000000, created_at: "2023-11-17" },
    { id: 24, total_price: 4324535, created_at: "2023-11-12" },

    { id: 25, total_price: 350000, created_at: "2023-11-1" },
    { id: 26, total_price: 1350000, created_at: "2023-11-2" },
    { id: 27, total_price: 2450000, created_at: "2023-11-3" },
    { id: 28, total_price: 5565000, created_at: "2023-11-4" },
    { id: 29, total_price: 4000000, created_at: "2023-11-5" },
    { id: 30, total_price: 4324535, created_at: "2023-11-6" },
]);
const groupOrdersByDay = () => {
    const today = new Date();
    const currentWeekStartDate = new Date(today);
    currentWeekStartDate.setDate(today.getDate() - today.getDay() + 1);
    const currentWeekEndDate = new Date(currentWeekStartDate);
    currentWeekEndDate.setDate(currentWeekStartDate.getDate() + 6);

    const weeklyOrders = orders.value.filter((order) => {
        const orderDate = new Date(order.created_at);
        return (
            orderDate >= currentWeekStartDate && orderDate <= currentWeekEndDate
        );
    });

    const dailyData = {};

    weeklyOrders.forEach((order) => {
        const date = new Date(order.created_at);
        const dayOfWeek = date.getDay();

        let mappedDayOfWeek = dayOfWeek === 0 ? 7 : dayOfWeek;

        if (mappedDayOfWeek === 1) {
            mappedDayOfWeek = 8;
        }

        if (mappedDayOfWeek >= 2 && mappedDayOfWeek <= 8) {
            if (!dailyData[mappedDayOfWeek]) {
                dailyData[mappedDayOfWeek] = 0;
            }
            dailyData[mappedDayOfWeek] += order.total_price;
        }
    });

    return Object.keys(dailyData).map((dayOfWeek) => {
        return {
            dayOfWeek: parseInt(dayOfWeek),
            revenue: dailyData[dayOfWeek],
        };
    });
};

const chartData = computed(() => {
    const dailyRevenueData = groupOrdersByDay();
    const allDaysOfWeek = [1, 2, 3, 4, 5, 6, 7]; // All days from Monday to Sunday
    const dataForAllDays = allDaysOfWeek.map((dayOfWeek) => {
        const foundData = dailyRevenueData.find(
            (item) => item.dayOfWeek === dayOfWeek
        );
        return foundData
            ? [getDayName(dayOfWeek), foundData.revenue]
            : [getDayName(dayOfWeek), 0];
    });

    return dataForAllDays;
});

const getDayName = (dayOfWeek) => {
    const days = [
        "Thứ 2",
        "Thứ 3",
        "Thứ 4",
        "Thứ 5",
        "Thứ 6",
        "Thứ 7",
        "Chủ nhật",
    ];
    return days[dayOfWeek - 1];
};

// tháng
const groupOrdersByMonth = () => {
    const today = new Date();
    const currentMonthStartDate = new Date(
        today.getFullYear(),
        today.getMonth(),
        1
    );
    const currentMonthEndDate = new Date(
        today.getFullYear(),
        today.getMonth() + 1,
        0
    );

    const monthlyOrders = orders.value.filter((order) => {
        const orderDate = new Date(order.created_at);
        return (
            orderDate >= currentMonthStartDate &&
            orderDate <= currentMonthEndDate
        );
    });

    const monthlyData = {};

    monthlyOrders.forEach((order) => {
        const date = new Date(order.created_at);
        const dayOfMonth = date.getDate();

        if (!monthlyData[dayOfMonth]) {
            monthlyData[dayOfMonth] = 0;
        }
        monthlyData[dayOfMonth] += order.total_price;
    });

    return Object.keys(monthlyData).map((dayOfMonth) => {
        return {
            dayOfMonth: parseInt(dayOfMonth),
            revenue: monthlyData[dayOfMonth],
        };
    });
};
const monthlyChartData = computed(() => {
    const monthlyRevenueData = groupOrdersByMonth();
    const totalDaysInMonth = new Date(
        new Date().getFullYear(),
        new Date().getMonth() + 1,
        0
    ).getDate();

    const dataForAllDays = Array.from(
        { length: totalDaysInMonth },
        (_, index) => {
            const foundData = monthlyRevenueData.find(
                (item) => item.dayOfMonth === index + 1
            );
            return foundData
                ? [`${index + 1}`, foundData.revenue]
                : [`${index + 1}`, 0];
        }
    );

    return dataForAllDays;
});
const getMonthName = (monthNumber) => {
    const months = [
        "Tháng 1",
        "Tháng 2",
        "Tháng 3",
        "Tháng 4",
        "Tháng 5",
        "Tháng 6",
        "Tháng 7",
        "Tháng 8",
        "Tháng 9",
        "Tháng 10",
        "Tháng 11",
        "Tháng 12",
    ];
    return months[monthNumber - 1];
};
//năm
const groupOrdersByYear = () => {
    const today = new Date();
    const currentYear = today.getFullYear();

    const yearlyOrders = orders.value.filter((order) => {
        const orderDate = new Date(order.created_at);
        return orderDate.getFullYear() === currentYear;
    });

    const yearlyData = {};

    yearlyOrders.forEach((order) => {
        const date = new Date(order.created_at);
        const month = date.getMonth();

        if (!yearlyData[month]) {
            yearlyData[month] = 0;
        }
        yearlyData[month] += order.total_price;
    });

    return Object.keys(yearlyData).map((month) => {
        return {
            month: parseInt(month),
            revenue: yearlyData[month],
        };
    });
};
const yearlyChartData = computed(() => {
    const yearlyRevenueData = groupOrdersByYear();
    const dataForAllMonths = Array.from({ length: 12 }, (_, index) => {
        const foundData = yearlyRevenueData.find(
            (item) => item.month === index
        );
        return foundData
            ? [getMonthName(index + 1), foundData.revenue]
            : [getMonthName(index + 1), 0];
    });

    return dataForAllMonths;
});

</script>

<template>
    <Head title="Tổng quan" />
    <div>
        <div>
            <v-container class="bg-slate-100 mb-6">
                <v-row align="center" no-gutters style="height: 150px">
                    <v-col>
                        <!-- <v-sheet class="pa-2 ma-2"
                            >Doanh thu của ngày hôm nay:
                            {{ todayRevenue }} VND</v-sheet
                        > -->
                         <v-sheet class="pa-2 ma-2"
                            >Doanh thu ngày hôm nay:
                            1.256.000 VND</v-sheet
                        >
                    </v-col>
                    <v-col>
                        <!-- <v-sheet class="pa-2 ma-2"
                            >Doanh thu tuần này:
                            {{ weeklyRevenue }} VND</v-sheet
                        > -->
                        <v-sheet class="pa-2 ma-2"
                            >Doanh thu của tuần này:
                            11.656.400 VND</v-sheet
                        >
                    </v-col>
                    <v-col>
                        <!-- <v-sheet class="pa-2 ma-2"
                            >Doanh thu tháng này:
                            {{ monthlyRevenue }} VND</v-sheet
                        > -->
                        <v-sheet class="pa-2 ma-2"
                            >Doanh thu của tháng này:
                            65.056.765 VND</v-sheet
                        >
                    </v-col>
                </v-row>
                <v-row>
                    Biểu đồ doanh thu trong tuần này (từ Thứ 2 đến Chủ Nhật):
                    <column-chart
                        :data="chartData"
                        :xtitle="'Ngày'"
                        :ytitle="'Doanh Thu (VND)'"
                        :colors="[['#63b598', '#ce7d78', '#ea9e70', '#a48a9e', '#c6e1e8']]"
                    />
                </v-row>

                <v-row>
                    Biểu đồ doanh thu trong tháng này ({{
                        getMonthName(new Date().getMonth() + 1)
                    }}):
                    <line-chart
                        :data="monthlyChartData"
                        :xtitle="getMonthName(new Date().getMonth() + 1)"
                        :ytitle="'Doanh Thu (VND)'"
                    />
                </v-row>
                <v-row>
    Biểu đồ doanh thu trong năm {{ new Date().getFullYear() }}:
    <pie-chart
        :data="yearlyChartData"
        :xtitle="getMonthName(new Date().getMonth() + 1)"
        :ytitle="'Doanh Thu (VND)'"
    />
</v-row>


            </v-container>

            <v-container class="bg-slate-100 mb-6">
                <div
                    class="grid grid-cols-1 gap-4 md:grid-cols-2 md:gap-6 xl:grid-cols-4 2xl:gap-7.5"
                >
                    <!-- Card Item Start -->
                    <div
                        class="rounded-sm border border-stroke bg-white py-6 px-7.5 shadow-default dark:border-strokedark dark:bg-boxdark"
                    >
                        <div
                            class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-meta-2 dark:bg-meta-4"
                        >
                            <img
                                src="https://img.freepik.com/premium-vector/set-food-icons-european-lunch_178650-966.jpg?w=2000"
                                alt=""
                            />
                        </div>

                        <div class="mt-4 flex items-end justify-around">
                            <div>
                                <h4
                                    class="text-title-md font-bold text-black dark:text-white"
                                ></h4>
                                <span class="text-sm font-medium"
                                    >Tổng sản phẩm:
                                </span>
                            </div>

                            <span
                                class="flex items-center gap-1 text-green-700 text-lg font-medium text-meta-3"
                            >
                                11
                            </span>
                        </div>
                    </div>
                    <!-- Card Item End -->

                    <!-- Card Item Start -->
                    <div
                        class="rounded-sm border border-stroke bg-white py-6 px-7.5 shadow-default dark:border-strokedark dark:bg-boxdark"
                    >
                        <div
                            class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-meta-2 dark:bg-meta-4"
                        >
                            <img
                                width=""
                                src="https://img.freepik.com/premium-vector/set-food-icons-european-lunch_178650-966.jpg?w=2000"
                                alt=""
                            />
                        </div>

                        <div class="mt-4 flex items-end justify-around">
                            <div>
                                <h4
                                    class="text-title-md font-bold text-black dark:text-white"
                                ></h4>
                                <span class="text-sm font-medium"
                                    >Tổng sản phẩm:
                                </span>
                            </div>

                            <span
                                class="flex items-center gap-1 text-green-700 text-lg font-medium text-meta-3"
                            >
                                11
                            </span>
                        </div>
                    </div>
                    <!-- Card Item End -->

                    <!-- Card Item Start -->
                    <div
                        class="rounded-sm border border-stroke bg-white py-6 px-7.5 shadow-default dark:border-strokedark dark:bg-boxdark"
                    >
                        <div
                            class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-meta-2 dark:bg-meta-4"
                        >
                            <img
                                width=""
                                src="https://img.freepik.com/premium-vector/set-food-icons-european-lunch_178650-966.jpg?w=2000"
                                alt=""
                            />
                        </div>

                        <div class="mt-4 flex items-end justify-around">
                            <div>
                                <h4
                                    class="text-title-md font-bold text-black dark:text-white"
                                ></h4>
                                <span class="text-sm font-medium"
                                    >Tổng sản phẩm:
                                </span>
                            </div>

                            <span
                                class="flex items-center gap-1 text-green-700 text-lg font-medium text-meta-3"
                            >
                                11
                            </span>
                        </div>
                    </div>
                    <!-- Card Item End -->

                    <!-- Card Item Start -->
                    <div
                        class="rounded-sm border border-stroke bg-white py-6 px-7.5 shadow-default dark:border-strokedark dark:bg-boxdark"
                    >
                        <div
                            class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-meta-2 dark:bg-meta-4"
                        >
                            <img
                                width=""
                                src="https://img.freepik.com/free-vector/people-carrying-shopping-bags-collection_52683-15820.jpg?w=740&t=st=1695275672~exp=1695276272~hmac=5ae6f87838315181311398097ba35e76087043c0034a5de14731717d9fc947be"
                                alt=""
                            />
                        </div>

                        <div class="mt-4 flex items-end justify-around">
                            <div>
                                <div>
                                    <h4
                                        class="text-title-md font-bold text-black dark:text-white"
                                    ></h4>
                                    <span class="text-sm font-medium"
                                        >Tổng khách hàng:
                                    </span>
                                </div>
                            </div>
                            <span
                                class="flex items-center gap-1 text-green-700 text-lg font-medium text-meta-3"
                            >
                                2
                            </span>
                        </div>
                    </div>
                    <!-- Card Item End -->
                </div>
            </v-container>

            <v-container class="bg-surface-variant mb-6"> </v-container>
        </div>
    </div>
</template>
