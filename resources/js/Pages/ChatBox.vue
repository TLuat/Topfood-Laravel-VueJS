<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { Link } from "@inertiajs/vue3";

const userMessage = ref('');
const messages = ref([]);
const assistantReply = ref('');


const sendMessage = async () => {
  const response = await axios.post(route('chat.store'), {
    message: userMessage.value,
  });

  messages.value.push({ role: 'user', content: userMessage.value });
  messages.value.push({ role: 'assistant', content: response.data.reply });

  userMessage.value = '';
};

const testAxios = async () => {
  try {
    const response = await axios.post(route('chat.store'), { message: 'userMessage' });
    console.log('Axios response:', response.data);
  } catch (error) {
    console.error('Error:', error);
  }
};

onMounted(() => {
  testAxios();
});
</script>

<template>
  <v-container>
    <v-row>
      <v-col>
        <!-- Display area for messages -->
        <v-card>
          <v-card-text>
            <div v-for="message in messages" :key="message.id">
              {{ message.role === 'user' ? 'You: ' : 'Assistant: ' }} {{ message.content }}
            </div>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>

    <v-row>
      <v-col>
        <!-- Form for user input -->
        <v-form @submit.prevent="sendMessage">
          <v-text-field v-model="userMessage" label="Type your message" outlined></v-text-field>
          <v-btn type="submit" color="primary">Send</v-btn>
        </v-form>
      </v-col>
    </v-row>
  </v-container>
</template>


