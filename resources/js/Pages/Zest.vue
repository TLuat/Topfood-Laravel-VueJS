<template>
    <v-layout>
        <v-data-iterator
      :items="mice"
      :items-per-page="itemsPerPage"
      :search="search"
    >
      <template v-slot:header="{ page, pageCount, prevPage, nextPage }">
        <h1 class="text-h4 font-weight-bold d-flex justify-space-between mb-4 align-center">
          <v-toolbar class="px-2">
          <v-text-field
            v-model="search"
            clearable
            density="comfortable"
            hide-details
            placeholder="Search"
            prepend-inner-icon="mdi-magnify"
            style="max-width: 300px;"
            variant="solo"
          ></v-text-field>
          <v-btn
              class="me-8"
              variant="text"
              @click="onClickSeeAll"
            >
              <span class="text-decoration-underline text-none">See all</span>
            </v-btn>
        </v-toolbar>
  
          <div class="d-flex align-center">
            
          </div>
        </h1>
      </template>
  
      <template v-slot:default="{ items }">
        <v-row>
          <v-col
            v-for="(item, i) in items"
            :key="i"
            cols="12"
            sm="6"
            xl="3"
          >
            <v-sheet border>
              <v-img
                :gradient="`to top right, rgba(255, 255, 255, .1), rgba(${item.raw.color}, .15)`"
                :src="item.raw.src"
                cover
                height="150"
              ></v-img>
  
              <v-list-item
                :title="item.raw.name"
                lines="two"
                density="comfortable"
                subtitle="Lorem ipsum dil orei namdie dkaf"
              >
                <template v-slot:title>
                  <strong class="text-h6">
                    {{ item.raw.name }}
                  </strong>
                </template>
              </v-list-item>
  
              <v-table density="compact" class="text-caption">
                <tbody>
                  <tr align="right">
                    <th>DPI:</th>
  
                    <td>{{ item.raw.dpi }}</td>
                  </tr>
  
                  <tr align="right">
                    <th>Buttons:</th>
  
                    <td>{{ item.raw.buttons }}</td>
                  </tr>
  
                  <tr align="right">
                    <th>Weight:</th>
  
                    <td>{{ item.raw.weight }}</td>
                  </tr>
  
                  <tr align="right">
                    <th>Wireless:</th>
  
                    <td>{{ item.raw.wireless ? 'Yes' : 'No' }}</td>
                  </tr>
  
                  <tr align="right">
                    <th>Price:</th>
  
                    <td>${{ item.raw.price }}</td>
                  </tr>
                </tbody>
              </v-table>
            </v-sheet>
          </v-col>
        </v-row>
      </template>
  
      <template v-slot:footer="{ page, pageCount, prevPage, nextPage }">
        <div class="d-flex align-center justify-center pa-4">
          <v-btn
            :disabled="page === 1"
            icon="mdi-arrow-left"
            density="comfortable"
            variant="tonal"
            rounded
            @click="prevPage"
          ></v-btn>

          <div class="mx-2 text-caption">
            Page {{ page }} of {{ pageCount }}
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
  </template>
  <script>
    export default {
      data () {
        return {
          itemsPerPage: 4,
          search: '',
          mice: [
            {
              name: 'Logitech G Pro X',
              color: '14, 151, 210',
              dpi: 16000,
              buttons: 8,
              weight: '63g',
              wireless: true,
              price: 149.99,
              description: 'Logitech G Pro X',
              src: 'https://cdn.vuetifyjs.com/docs/images/graphics/mice/1.png',
            },
            {
              name: 'Razer DeathAdder V2',
              color: '12, 146, 47',
              dpi: 20000,
              buttons: 8,
              weight: '82g',
              wireless: false,
              price: 69.99,
              description: 'Razer DeathAdder V2',
              src: 'https://cdn.vuetifyjs.com/docs/images/graphics/mice/2.png',
            },
            {
              name: 'Corsair Dark Core RGB',
              color: '107, 187, 226',
              dpi: 18000,
              buttons: 9,
              weight: '133g',
              wireless: true,
              price: 89.99,
              description: 'Corsair Dark Core RGB',
              src: 'https://cdn.vuetifyjs.com/docs/images/graphics/mice/3.png',
            },
            {
              name: 'SteelSeries Rival 3',
              color: '228, 196, 69',
              dpi: 8500,
              buttons: 6,
              weight: '77g',
              wireless: false,
              price: 29.99,
              description: 'SteelSeries Rival 3',
              src: 'https://cdn.vuetifyjs.com/docs/images/graphics/mice/4.png',
            },
            {
              name: 'HyperX Pulsefire FPS Pro',
              color: '156, 82, 251',
              dpi: 16000,
              buttons: 6,
              weight: '95g',
              wireless: false,
              price: 44.99,
              description: 'HyperX Pulsefire FPS Pro',
              src: 'https://cdn.vuetifyjs.com/docs/images/graphics/mice/5.png',
            },
            {
              name: 'Zowie EC2',
              color: '166, 39, 222',
              dpi: 3200,
              buttons: 5,
              weight: '90g',
              wireless: false,
              price: 69.99,
              description: 'Zowie EC2',
              src: 'https://cdn.vuetifyjs.com/docs/images/graphics/mice/6.png',
            },
            {
              name: 'Roccat Kone AIMO',
              color: '131, 9, 10',
              dpi: 16000,
              buttons: 10,
              weight: '130g',
              wireless: false,
              price: 79.99,
              description: 'Roccat Kone AIMO',
              src: 'https://cdn.vuetifyjs.com/docs/images/graphics/mice/7.png',
            },
            {
              name: 'Logitech G903',
              color: '232, 94, 102',
              dpi: 12000,
              buttons: 11,
              weight: '110g',
              wireless: true,
              price: 129.99,
              description: 'Logitech G903',
              src: 'https://cdn.vuetifyjs.com/docs/images/graphics/mice/8.png',
            },
            {
              name: 'Cooler Master MM711',
              color: '58, 192, 239',
              dpi: 16000,
              buttons: 6,
              weight: '60g',
              wireless: false,
              price: 49.99,
              description: 'Cooler Master MM711',
              src: 'https://cdn.vuetifyjs.com/docs/images/graphics/mice/9.png',
            },
            {
              name: 'Glorious Model O',
              color: '161, 252, 250',
              dpi: 12000,
              buttons: 6,
              weight: '67g',
              wireless: false,
              price: 49.99,
              description: 'Glorious Model O',
              src: 'https://cdn.vuetifyjs.com/docs/images/graphics/mice/10.png',
            },
            {
              name: 'HP Omen Photon',
              color: '201, 1, 2',
              dpi: 16000,
              buttons: 11,
              weight: '128g',
              wireless: true,
              price: 99.99,
              description: 'HP Omen Photon',
              src: 'https://cdn.vuetifyjs.com/docs/images/graphics/mice/11.png',
            },
            {
              name: 'Asus ROG Chakram',
              color: '10, 181, 19',
              dpi: 16000,
              buttons: 9,
              weight: '121g',
              wireless: true,
              price: 159.99,
              description: 'Asus ROG Chakram',
              src: 'https://cdn.vuetifyjs.com/docs/images/graphics/mice/12.png',
            },
            {
              name: 'Razer Naga X',
              color: '100, 101, 102',
              dpi: 16000,
              buttons: 16,
              weight: '85g',
              wireless: false,
              price: 79.99,
              description: 'Razer Naga X',
              src: 'https://cdn.vuetifyjs.com/docs/images/graphics/mice/13.png',
            },
            {
              name: 'Mad Catz R.A.T. 8+',
              color: '136, 241, 242',
              dpi: 16000,
              buttons: 11,
              weight: '145g',
              wireless: false,
              price: 99.99,
              description: 'Mad Catz R.A.T. 8+',
              src: 'https://cdn.vuetifyjs.com/docs/images/graphics/mice/14.png',
            },
            {
              name: 'Alienware 610M',
              color: '109, 110, 114',
              dpi: 16000,
              buttons: 7,
              weight: '120g',
              wireless: true,
              price: 99.99,
              description: 'Alienware 610M',
              src: 'https://cdn.vuetifyjs.com/docs/images/graphics/mice/15.png',
            },
          ],
        }
      },
      methods: {
        onClickSeeAll () {
          this.itemsPerPage = this.itemsPerPage === 4 ? this.mice.length : 4
        },
      },
    }
  </script>
<style scoped>
.border {
    border-right: 1px solid grey;
}
</style>
