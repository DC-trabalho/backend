<script setup>
import { Link } from '@inertiajs/vue3'
import { Swiper, SwiperSlide } from 'swiper/vue'
import { Navigation, Pagination } from 'swiper/modules'
import 'swiper/css'
import 'swiper/css/navigation'
import 'swiper/css/pagination'
import { ref, onMounted, onUnmounted, watch } from 'vue'

defineProps({
  title: String,
  items: {
    type: Array,
    required: true,
  },
  breakpoints: {
    type: Object,
    default: () => ({
      640: { slidesPerView: 1 },
      768: { slidesPerView: 2.5 },
      1024: { slidesPerView: 4 }
    })
  }
})

const swiperInstance = ref(null)
const isDesktop = ref(true)

const isBeginning = ref(true)
const isEnd = ref(false)

const handleSwiper = (swiper) => {
  swiperInstance.value = swiper
  updateNavButtons(swiper)
  swiper.on('slideChange', () => updateNavButtons(swiper))
}

const updateNavButtons = (swiper) => {
  isBeginning.value = swiper.isBeginning
  isEnd.value = swiper.isEnd
}

const slideNext = () => swiperInstance.value?.slideNext()
const slidePrev = () => swiperInstance.value?.slidePrev()

const handleResize = () => {
  isDesktop.value = window.innerWidth >= 768
}

onMounted(() => {
  handleResize()
  window.addEventListener('resize', handleResize)
})

onUnmounted(() => {
  window.removeEventListener('resize', handleResize)
})
</script>

<template>
  <div class="py-12 pb-0">
    <div class="md:w-[80%] relative group mx-auto px-2">
      <h2 class="text-xl font-inria absolute dark:text-white">{{ title }}</h2>

      <Swiper
        :modules="isDesktop ? [Navigation, Pagination] : [Pagination]"
        :slides-per-view="1.2"
        :space-between="16"
        :breakpoints="breakpoints"
        freeMode
        grabCursor
        :pagination="{ clickable: true }"
        class="!py-8 !px-0 w-full mx-auto relative"
        @swiper="handleSwiper"
      >
        <SwiperSlide
          v-for="(item, index) in items"
          :key="index"
          class="rounded-md overflow-x-hidden shadow-md max-w-[200px] select-none"
        >
          <Link :href="item.link || '#'">
            <div class="relative aspect-[3/4] overflow-hidden">
              <img
                :src="item.src"
                :alt="item.alt"
                class="w-full h-full object-cover hover:scale-105 transition-transform duration-200"
              />
              <div class="font-inria absolute bottom-0 left-0 w-full text-white text-xl p-3">
                {{ item.name }}
              </div>
            </div>
          </Link>
        </SwiperSlide>
      </Swiper>

      <button
        class="absolute top-1/2 -left-16 transform -translate-y-1/2 z-10 hidden md:block dark:text-white"
        :class="{ 'opacity-30 pointer-events-none': isBeginning }"
        @click="slidePrev"
      >
        <svg class="size-4" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
          fill="currentColor">
          <path d="M400-80 0-480l400-400 71 71-329 329 329 329-71 71Z" />
        </svg>
      </button>

      <button
        class="absolute top-1/2 -right-16 transform -translate-y-1/2 z-10 hidden md:block dark:text-white"
        :class="{ 'opacity-30 pointer-events-none': isEnd }"
        @click="slideNext"
      >
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
