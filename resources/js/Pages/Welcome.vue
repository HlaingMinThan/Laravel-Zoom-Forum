<template>
  <!-- Page Header -->
  <div class="p-6 pb-0">
    <div class="flex items-center justify-between mb-6">
      <h1 class="text-[27px] font-normal text-[#e6edf3] leading-tight">
        Top Questions
      </h1>
      <Link
        href="/questions/ask"
        class="bg-[#1f6feb] hover:bg-[#388bfd] text-white text-[13px] font-medium px-3 py-2 rounded-[3px] border border-[rgba(240,246,252,0.1)] shadow-sm whitespace-nowrap transition-colors"
      >
      Ask Question
      </Link>
    </div>

    <!-- Filters -->
    <div class="flex items-center justify-end mb-4">
      <div class="inline-flex border border-[#30363d] rounded-[3px] divide-x divide-[#30363d]">
        <button class="px-3 py-1.5 text-[13px] text-[#c9d1d9] bg-[#21262d] font-medium">
          Latest
        </button>
        <button
          class="px-3 py-1.5 text-[13px] text-[#8b949e] hover:bg-[#21262d] hover:text-[#c9d1d9] bg-transparent transition-colors"
        >
          Hot
        </button>
        <button
          class="px-3 py-1.5 text-[13px] text-[#8b949e] hover:bg-[#21262d] hover:text-[#c9d1d9] bg-transparent transition-colors"
        >
          Week
        </button>
        <button
          class="px-3 py-1.5 text-[13px] text-[#8b949e] hover:bg-[#21262d] hover:text-[#c9d1d9] bg-transparent transition-colors"
        >
          Month
        </button>
      </div>
    </div>
  </div>

  <!-- Question List -->
  <div class="flex flex-col divide-y divide-[#30363d] border-t border-[#30363d]">
    <!-- Question Item -->
    <QuestionCard
      v-for="question in questions.data"
      :key="question.id"
      :question="question"
    />

   

    <!-- Empty State -->
    <div
      v-if="questions.data.length === 0"
      class="py-16 text-center text-[#8b949e]"
    >
      <div class="mb-3">
        <svg
          class="w-12 h-12 mx-auto text-[#30363d]"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="1.5"
            d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
          />
        </svg>
      </div>
      
      <p class="text-lg font-medium text-[#c9d1d9]">No questions found</p>
      <p class="text-[13px] mt-1">
        Be the first to ask a question in this community.
      </p>
    </div>
  </div>

  <!-- Pagination -->
  <div
    class="mt-6 mb-10 flex justify-center"
    v-if="questions.links.length > 3"
  >
    <div class="flex flex-wrap gap-1">
      <template
        v-for="(link, key) in questions.links"
        :key="key"
      >
        <div
          v-if="link.url === null"
          class="px-3 py-2 text-sm text-[#8b949e] border border-transparent rounded-[6px]"
          v-html="link.label"
        ></div>
        <Link
          v-else
          :href="link.url"
          class="px-3 py-2 text-sm border rounded-[6px] transition-colors"
          :class="{
            'bg-[#1f6feb] text-white border-[#1f6feb]': link.active,
            'text-[#c9d1d9] border-transparent hover:bg-[#21262d] hover:border-[#30363d]': !link.active
          }"
        >
        <span v-html="link.label"></span>
        </Link>
      </template>
    </div>
  </div>
</template>
<script>

import QuestionCard from '@/Components/QuestionCard.vue';

import { Link } from "@inertiajs/vue3";
export default {
  components: {
    QuestionCard,
    Link,
  },
  props: {
    questions: {
      type: Object,
    },
  },
};
</script>
