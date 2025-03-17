<script setup>
import { ref, onMounted } from "vue";
import { format, parseISO } from "date-fns";
import vi from "date-fns/locale/vi";
import ChatBox from "./ChatBox.vue";
import axios from 'axios';
const props = defineProps({
    weather: {
        type: Object,
        required: true,
    },
});
const getWeatherIconUrl = (iconCode) => {
    return `https://openweathermap.org/img/w/${iconCode}.png`;
};
const formatTemperature = (temp) => {
    return `${(temp - 273.15).toFixed(1)}°C`;
};

// const apiUrl = 'https://jsonplaceholder.typicode.com/posts';

// const testAxios = async () => {
//   try {
//     const response = await axios.post(apiUrl, { message: 'userMessage' });
//     console.log('Axios response:', response.data);
//   } catch (error) {
//     console.error('Error:', error);
//   }
// };

// onMounted(() => {
//   testAxios();
// });
</script>

<template>
    <div>
        <h1>Dự báo thời tiết</h1>
        <div>
            <div>
                <ChatBox />
            </div>
            <h1>Weather for Today</h1>
            <ul>
                <div
                    v-for="(forecast, index) in weather"
                    :key="index"
                    class="flex"
                >
                    <p>Date and Time: {{ forecast.dt_txt }}</p>
                    <p>
                        Temperature: {{ formatTemperature(forecast.main.temp) }}
                    </p>
                    <p>Description: {{ forecast.weather[0].description }}</p>
                    <img
                        :src="getWeatherIconUrl(forecast.weather[0].icon)"
                        alt="Weather Icon"
                    />
                </div>
            </ul>
        </div>
    </div>
</template>
