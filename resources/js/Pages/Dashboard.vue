<template>
  <div class="relative w-full py-6">
    <!-- Margem lateral grande no desktop -->
    <div class="px-4 lg:px-24">
      <h2 class="text-xl font-semibold mb-4">Heróis</h2>
      <div class="relative">
        <Swiper
  :modules="[Navigation]"
  :slides-per-view="1.2"
  :space-between="16"
  :breakpoints="breakpoints"
  :navigation="false" 
  grabCursor
  class="mySwiper"
  ref="swiperRef"
>
          <SwiperSlide
            v-for="(image, index) in images"
            :key="index"
            class="rounded-lg overflow-hidden shadow-md"
          >
            <div class="relative aspect-[3/4]">
              <img
                :src="image.src"
                :alt="image.alt"
                class="w-full h-full object-cover"
              />
              <div
                class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-black/70 to-transparent text-white text-lg font-semibold p-3"
              >
                {{ image.name }}
              </div>
            </div>
          </SwiperSlide>
        </Swiper>

        <!-- Botões de navegação -->
        <button
          class="hidden lg:flex absolute top-1/2 -left-12 transform -translate-y-1/2 z-10 bg-white p-3 rounded-full shadow-md"
          @click="swiperRef.swiper.slidePrev()"
        >
          ‹
        </button>
        <button
          class="hidden lg:flex absolute top-1/2 -right-12 transform -translate-y-1/2 z-10 bg-white p-3 rounded-full shadow-md"
          @click="swiperRef.swiper.slideNext()"
        >
          ›
        </button>
      </div>
    </div>
  </div>
</template>


<script setup>
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Navigation } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/navigation';
import { ref } from 'vue';

const swiperRef = ref(null);

const images = [
  { src: '/images/batman.jpg', alt: 'Batman', name: 'Batman' },
  { src: '/images/batman.jpg', alt: 'Batman', name: 'Batman' },
  { src: '/images/batman.jpg', alt: 'Batman', name: 'Batman' },
  { src: '/images/batman.jpg', alt: 'Batman', name: 'Batman' },
  { src: '/images/batman.jpg', alt: 'Batman', name: 'Batman' },
  { src: '/images/batman.jpg', alt: 'Batman', name: 'Batman' },
  { src: '/images/batman.jpg', alt: 'Batman', name: 'Batman' },

];

const breakpoints = {
  640: {
    slidesPerView: 1.5,
  },
  768: {
    slidesPerView: 2.5,
  },
  1024: {
    slidesPerView: 4,
  },
};

</script>
