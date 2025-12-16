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
        <div
          class="inline-flex border border-[#30363d] rounded-[3px] divide-x divide-[#30363d]"
        >
          <button
            class="px-3 py-1.5 text-[13px] text-[#c9d1d9] bg-[#21262d] font-medium"
          >
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
    <div
      class="flex flex-col divide-y divide-[#30363d] border-t border-[#30363d]"
    >
      <!-- Question Item -->
      <div
        v-for="question in questions"
        :key="question.id"
        class="flex p-4 pl-4 gap-4 hover:bg-[#161b22] transition-colors duration-150"
      >
        <!-- Stats -->
        <div
          class="flex flex-col items-end gap-1.5 text-[13px] flex-shrink-0 w-[100px] text-[#8b949e]"
        >
          <div class="font-medium text-[#c9d1d9]">
            <span class="font-bold">0</span> votes
          </div>
          <div
            class="font-medium text-[#8b949e] border border-[#30363d] rounded-[3px] px-2 py-0.5"
          >
            <span class="font-bold text-[#c9d1d9]">0</span> answers
          </div>
          <div class="text-[#8b949e] text-[12px]">
            <span class="font-bold">0</span> views
          </div>
        </div>

        <!-- Content -->
        <div class="flex-1 min-w-0">
          <h3
            class="text-[17px] font-normal text-[#58a6ff] hover:text-[#79c0ff] mb-1 leading-snug break-words"
          >
            <Link :href="route('questions.show',question.id)">{{
              question.title
            }}</Link>
          </h3>
          <p
            class="text-[13px] text-[#c9d1d9] mb-2 line-clamp-2 leading-relaxed"
          >
            {{
              question.body || "No description available for this question..."
            }}
          </p>

          <div class="flex flex-wrap items-center justify-between gap-y-2">
            <!-- Tags -->
            <div class="flex flex-wrap gap-1.5">
              <span
                v-for="tag in question.tags"
                :key="tag.id"
                class="px-1.5 py-0.5 bg-[#1f2d3d] text-[#58a6ff] text-[12px] rounded-[3px] hover:bg-[#2c3e50] cursor-pointer transition-colors"
                > {{ tag.name }}</span
              >
            </div>

            <!-- User Meta -->
            <div
              class="flex items-center gap-1 text-[12px] text-[#8b949e] ml-auto"
            >
              <div class="flex items-center gap-1.5">
                <!-- Avatar mock -->
                <div class="w-4 h-4 bg-purple-500 rounded-[2px]"></div>
                <Link :href="'/users/'+question.user.id" v-if="question.user">
                  <span
                    class="text-[#58a6ff] hover:text-[#79c0ff] cursor-pointer"
                    >{{ question.user.name }}</span
                  >
                </Link>
                <span v-else class="text-[#8b949e]">Anonymous</span>
                <span class="text-[#c9d1d9] font-bold">125</span>
              </div>
              <span class="text-[#6e7681]"
                >asked
                <span class="font-medium text-[#c9d1d9]">1 hour ago</span></span
              >
            </div>
          </div>
        </div>
      </div>

      <!-- Empty State -->
      <div
        v-if="questions.length === 0"
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
</template>
<script>
import { Link } from "@inertiajs/vue3";
export default {
  components: {
    Link,
  },
  props: {
    questions: {
      type: Array,
    },
  },
};
</script>
