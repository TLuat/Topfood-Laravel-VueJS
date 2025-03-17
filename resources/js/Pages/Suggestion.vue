<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import { format, parseISO } from "date-fns";
import vi from "date-fns/locale/vi";
import { ref, computed } from "vue";
const props = defineProps({
    products: {
        type: Object,
        required: true,
    },
    weather: {
        type: Array,
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
const uniqueProducts = computed(() => {
    const uniqueProductMap = props.orders
        .filter((order) => order.status === "shipped")
        .reduce((map, order) => {
            order.products.forEach((product) => {
                const productName = product.name;
                if (!map.has(productName)) {
                    map.set(productName, product);
                }
            });
            return map;
        }, new Map());

    return [...uniqueProductMap.values()];
});
const currentTime = ref(new Date());

setInterval(() => {
    currentTime.value = new Date();
}, 1000);
const formatTimeInVietnam = (date) => {
    const options = {
        hour: "2-digit",
        minute: "2-digit",
        second: "2-digit",
        hour12: false,
        timeZone: "Asia/Ho_Chi_Minh",
    };
    return date.toLocaleString("en-US", options);
};

const timeOfDay = computed(() => {
    const hours = currentTime.value.getHours();
    if (hours >= 1 && hours < 10) return "SÁNG";
    if (hours >= 10 && hours < 13) return "TRƯA";
    if (hours >= 13 && hours < 17) return "CHIỀU";
    if (hours >= 17 && hours < 24) return "TỐI";
    return "TỐI";
});
const displayTime = computed(() => {
    const hours = currentTime.value.getHours();
    if (hours >= 1 && hours < 10) return "BUỔI SÁNG";
    if (hours >= 10 && hours < 13) return "BUỔI TRƯA";
    if (hours >= 13 && hours < 17) return "BUỔI CHIỀU";
    return "BUỔI TỐI";
});

const findClosestWeatherForecast = computed(() => {
    if (props.weather.length === 0) return null;

    const currentTimeMs = currentTime.value.getTime();

    const closestForecast = props.weather.reduce(
        (closest, forecast) => {
            const forecastTimeMs = new Date(forecast.dt_txt).getTime();
            const timeDifference = Math.abs(forecastTimeMs - currentTimeMs);

            if (timeDifference < closest.timeDifference) {
                return { forecast, timeDifference };
            }

            return closest;
        },
        { forecast: props.weather[0], timeDifference: Infinity }
    );

    return [closestForecast.forecast];
});

const getWeatherIconUrl = (iconCode) => {
    return `https://openweathermap.org/img/w/${iconCode}.png`;
};
const formatTemperature = (temp) => {
    return `${(temp - 273.15).toFixed(1)}°C`;
};
const formatDayOfWeek = (date) => {
    return format(parseISO(date), "EEEE", { locale: vi });
};
</script>

<!--           @click="
    handleAddButtonClick(
        uniqueProduct
    )
" -->

<template>
    <div>
        <v-sheet class="mx-auto text-left mb-20" elevation="8" rounded="">
            <div class="mt-3">
                <div class="">
                    <div
                        v-for="(forecast, index) in findClosestWeatherForecast"
                        :key="index"
                        class="text-center flex justify-around"
                    >
                        <div>
                            <img
                                src="../../../public/images/calendar_747479.png"
                                class="w-8 mt-4 mx-auto"
                            />
                            <p class="text-orange-500 text-xl my-auto">
                                {{ formatDayOfWeek(forecast.dt_txt) }}
                            </p>
                        </div>
                        <div>
                            <img
                                src="../../../public/images/temperature_2387835.png"
                                class="w-8 px-0 mt-4 mx-auto h-8"
                            />
                            <span class="text-orange-500 text-xl my-auto">{{
                                formatTemperature(forecast.main.temp)
                            }}</span>
                        </div>
                        <div class="flex">
                            <img
                                :src="
                                    getWeatherIconUrl(forecast.weather[0].icon)
                                "
                                alt="Weather Icon"
                                class="w-16 mt-4 mx-auto"
                            />
                            <span
                                class="my-auto text-center capitalize text-orange-500"
                            >
                                {{ forecast.weather[0].description }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <p class="text-center text-lg uppercase mt-8">
                Đề xuất món ăn cho
                <span class="text-orange-500">{{ displayTime }} HÔM NAY</span> 
                LÚC
                <span class="text-orange-500">{{
                    currentTime.toLocaleString("en-US", {
                        hour: "2-digit",
                        minute: "2-digit",
                        second: "2-digit",
                        timeZone: "Asia/Ho_Chi_Minh",
                    })
                }}</span>
            </p>
            <v-slide-group
                v-model="model"
                class="rounded-xl"
                selected-class="bg-success"
                show-arrows
            >
                <v-slide-group-item
                    v-for="product in products"
                    :key="product.id"
                >
                    <div v-if="product.meal_time === timeOfDay">
                        <v-card>
                            <v-img
                                :src="getImageUrl(product.image)"
                                class="align-end ma-4"
                                gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)"
                                height="130"
                                width="200"
                                cover
                            >
                                <v-card-title class="text-white">{{
                                    product.name
                                }}</v-card-title>
                            </v-img>
                        </v-card>
                    </div>
                </v-slide-group-item>
            </v-slide-group>
            <p class="text-center">MUA LẠI</p>
            <v-slide-group
                v-model="model"
                class="rounded-xl"
                selected-class="bg-success"
                show-arrows
            >
                <v-slide-group-item
                    v-for="uniqueProduct in uniqueProducts"
                    :key="uniqueProduct.id"
                >
                    <div>
                        <v-card>
                            <v-img
                                :src="getImageUrl(uniqueProduct.image)"
                                class="align-end ma-4"
                                gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)"
                                height="130"
                                width="200"
                                cover
                            >
                                <v-card-title class="text-white">{{
                                    uniqueProduct.name
                                }}</v-card-title>
                            </v-img>
                        </v-card>
                    </div>
                </v-slide-group-item>
            </v-slide-group>
        </v-sheet>
    </div>
</template>
