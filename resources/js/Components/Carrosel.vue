<script setup>
import { Link } from '@inertiajs/vue3';
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Navigation, Pagination } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import { ref, onMounted, onUnmounted } from 'vue';

const images = [
  { src: 'https://img.odcdn.com.br/wp-content/uploads/2024/06/imagem_2024-06-17_151110069-695x500.jpg', alt: 'Batman', name: 'Batman' },
  { src: 'https://i.pinimg.com/736x/ec/a9/8b/eca98b8528bbdc2486e5935e8a9908be.jpg', alt: 'Superman', name: 'Superman' },
  { src: 'https://encrypted-tbn3.gstatic.com/images?q=tbn:ANd9GcT04A_AFsE4S_M28_bxsWiWAiAqy8qTBjqL9ccj4agFJj-ag5RX', alt: 'Flash', name: 'Flash' },
  { src: 'https://i.pinimg.com/736x/a6/a8/00/a6a800d416c2388423948dedd874fdcd.jpg', alt: 'Aquaman', name: 'Aquaman' },
  { src: 'https://img.odcdn.com.br/wp-content/uploads/2024/06/imagem_2024-06-17_151110069-695x500.jpg', alt: 'Batman', name: 'Batman' },
  { src: 'https://img.odcdn.com.br/wp-content/uploads/2024/06/imagem_2024-06-17_151110069-695x500.jpg', alt: 'Batman', name: 'Batman' },
  { src: 'https://img.odcdn.com.br/wp-content/uploads/2024/06/imagem_2024-06-17_151110069-695x500.jpg', alt: 'Batman', name: 'Batman' },

];

const breakpoints = {
  640: { slidesPerView: 1 },
  768: { slidesPerView: 2.5 },
  1024: { slidesPerView: 4 },
};
const swiperInstance = ref(null);
const isDesktop = ref(true);

const isBeginning = ref(true);
const isEnd = ref(false);

onMounted(() => {
  isDesktop.value = window.innerWidth >= 768;
});

const handleSwiper = (swiper) => {
  swiperInstance.value = swiper;
  updateNavButtons(swiper);

  swiper.on('slideChange', () => {
    updateNavButtons(swiper);
  });
};

const updateNavButtons = (swiper) => {
  isBeginning.value = swiper.isBeginning;
  isEnd.value = swiper.isEnd;
};


const slideNext = () => {
  if (swiperInstance.value) {
    swiperInstance.value.slideNext();
  }
};

const slidePrev = () => {
  if (swiperInstance.value) {
    swiperInstance.value.slidePrev();
  }
};

const handleResize = () => {
  isDesktop.value = window.innerWidth >= 768;
};

onMounted(() => {
  window.addEventListener('resize', handleResize);
});

onUnmounted(() => {
  window.removeEventListener('resize', handleResize);
});

</script>

<template>
  <div class="py-12">
    <div class="md:w-[80%] relative group mx-auto px-2">
      <h2 class="text-xl font-inria absolute dark:text-white">Heróis</h2>
      <Swiper :modules="isDesktop ? [Navigation, Pagination] : [Pagination]" :slides-per-view="1.2" :space-between="16"
        :breakpoints="breakpoints" freeMode grabCursor :pagination="{ clickable: true }"
        class="!py-8 !px-0 w-full mx-auto relative" @swiper="handleSwiper">
        <SwiperSlide v-for="(image, index) in images" :key="index"
          class="rounded-md overflow-x-hidden shadow-md max-w-[200px] select-none">
          <Link href="/category/awd">
          <div class="relative aspect-[3/4] overflow-hidden">
            <img :src="image.src" :alt="image.alt" class="w-full h-full object-cover hover:scale-105 transition-transform duration-200" />
            <div class="font-inria absolute bottom-0 left-0 w-full text-white text-xl p-3">
              {{ image.name }}
            </div>
          </div>
        </Link>
        </SwiperSlide>
      </Swiper>

      <button class="absolute top-1/2 -left-16 transform -translate-y-1/2 z-10 hidden md:block dark:text-white"
        :class="{ 'opacity-30 pointer-events-none': isBeginning }" @click="slidePrev">
        <svg class="size-4" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
          fill="currentColor">
          <path d="M400-80 0-480l400-400 71 71-329 329 329 329-71 71Z" />
        </svg>
      </button>
      <button class="absolute top-1/2 -right-16 transform -translate-y-1/2 z-10 hidden md:block dark:text-white"
        :class="{ 'opacity-30 pointer-events-none': isEnd }" @click="slideNext">
        <svg class="size-4" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
          fill="currentColor">
          <path d="m321-80-71-71 329-329-329-329 71-71 400 400L321-80Z" />
        </svg>
      </button>
    </div>
  </div>
</template>

<style scoped>
.swiper-button-prev,
.swiper-button-next {
  display: none;
}

:deep(.swiper-pagination) {
  @apply hidden md:block;
  bottom: 0;
}

:deep(.swiper-pagination-bullet) {
  background: #ccc;
  opacity: 1;
  transition: background 0.3s;
}

:deep(.swiper-pagination-bullet-active) {
  background: #000;
}
</style>
