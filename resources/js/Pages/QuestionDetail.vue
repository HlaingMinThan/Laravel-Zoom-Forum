<script setup>
import { Head, Link } from "@inertiajs/vue3";

defineProps({
  question: {
    type: Object,
    required: true,
  },
});
</script>

<template>
  <Head :title="question.title" />

  <!-- Question Header -->
  <div class="flex justify-between items-start mb-4 p-10">
    <h1
      class="text-[27px] text-[#e6edf3] leading-tight break-words mb-2 flex-1 pr-4"
    >
      {{ question.title }}
    </h1>
    <Link
      href="/questions/ask"
      class="bg-[#1f6feb] hover:bg-[#388bfd] text-white text-[13px] font-medium px-3 py-2 rounded-[3px] border border-[rgba(240,246,252,0.1)] shadow-sm whitespace-nowrap transition-colors flex-shrink-0"
    >
      Ask Question
    </Link>
  </div>

  <!-- Meta Row -->
  <div
    class="flex flex-wrap gap-4 pb-4 border-b border-[#30363d] text-[13px] text-[#8b949e] mb-6"
  >
    <div>
      <span class="text-[#8b949e]">Asked</span>
      <span class="ml-1 text-[#c9d1d9]">today</span>
    </div>
    <div>
      <span class="text-[#8b949e]">Modified</span>
      <span class="ml-1 text-[#c9d1d9]">today</span>
    </div>
    <div>
      <span class="text-[#8b949e]">Viewed</span>
      <span class="ml-1 text-[#c9d1d9]">12 times</span>
    </div>
  </div>

  <div class="flex gap-6">
    <!-- Main Post Column -->
    <div class="flex-1 min-w-0">
      <!-- Question Area -->
      <div class="flex gap-4">
        <!-- Voting Sidebar -->
        <div class="flex flex-col items-center gap-2 w-10 flex-shrink-0">
          <button
            class="p-2 rounded-full hover:bg-[#21262d] text-[#8b949e] hover:text-[#f78166] transition-colors"
          >
            <svg class="w-9 h-9" fill="currentColor" viewBox="0 0 36 36">
              <path d="M2 26h32L18 10 2 26z"></path>
            </svg>
          </button>
          <div class="text-[21px] font-semibold text-[#c9d1d9]">0</div>
          <button
            class="p-2 rounded-full hover:bg-[#21262d] text-[#8b949e] hover:text-[#f78166] transition-colors"
          >
            <svg class="w-9 h-9" fill="currentColor" viewBox="0 0 36 36">
              <path d="M2 10h32L18 26 2 10z"></path>
            </svg>
          </button>

          <button
            class="mt-2 p-2 hover:bg-[#21262d] rounded text-[#8b949e] hover:text-[#c9d1d9]"
          >
            <svg
              class="w-5 h-5"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"
              ></path>
            </svg>
          </button>
        </div>

        <!-- Post Content -->
        <div class="flex-1 min-w-0">
          <div
            class="prose prose-invert max-w-none text-[15px] text-[#c9d1d9] leading-relaxed mb-6"
          >
            <!-- Using whitespace-pre-line to preserve line breaks if it's plain text, or v-html if HTML -->
            <p class="whitespace-pre-line">{{ question.body }}</p>

            <!-- Code Block Mockup -->
            <!-- 
                                    <div class="bg-[#161b22] p-4 rounded-md overflow-x-auto border border-[#30363d] my-4 font-mono text-[13px]">
                                        <code class="text-[#c9d1d9]">console.log("Hello World");</code>
                                    </div>
                                    -->
          </div>

          <!-- Tags -->
          <div class="flex flex-wrap gap-2 mb-8">
            <span
              class="px-2 py-1 bg-[#1f2d3d] text-[#58a6ff] text-[12px] rounded-[3px] hover:bg-[#2c3e50] cursor-pointer transition-colors"
              >laravel</span
            >
            <span
              class="px-2 py-1 bg-[#1f2d3d] text-[#58a6ff] text-[12px] rounded-[3px] hover:bg-[#2c3e50] cursor-pointer transition-colors"
              >vue.js</span
            >
          </div>

          <!-- Post Actions & User Card -->
          <div class="flex flex-wrap items-center justify-between gap-4 pt-4">
            <div class="flex gap-3 text-[13px] text-[#8b949e]">
              <button class="hover:text-[#c9d1d9]">Share</button>
              <button class="hover:text-[#c9d1d9]">Edit</button>
              <button class="hover:text-[#c9d1d9]">Follow</button>
            </div>

            <!-- Author Card -->
            <div
              class="bg-[#161b22] p-2 rounded-[3px] w-48 border border-[#30363d]"
            >
              <div class="text-[12px] text-[#8b949e] mb-1">
                asked <span class="text-[#c9d1d9]">today</span>
              </div>
              <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-purple-500 rounded-[3px]"></div>
                <div class="flex flex-col text-[13px]">
                  <Link href="#" class="text-[#58a6ff] hover:text-[#79c0ff]">{{
                    question.user?.name || "Anonymous"
                  }}</Link>
                  <span class="text-[#c9d1d9] font-bold text-[12px]">125</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Answers Section Header -->
      <div class="mt-12 flex items-center justify-between mb-4">
        <h2 class="text-[19px] text-[#e6edf3] font-normal">0 Answers</h2>
        <div class="flex items-center gap-2">
          <span class="text-[12px] text-[#8b949e]">Sorted by:</span>
          <select
            class="bg-[#0d1117] border border-[#30363d] text-[#c9d1d9] text-[12px] p-1 rounded-[3px] focus:border-[#58a6ff] outline-none"
          >
            <option>Highest score (default)</option>
            <option>Date modified (newest first)</option>
            <option>Date created (oldest first)</option>
          </select>
        </div>
      </div>

      <!-- Answer Placeholder (if no answers) -->
      <div class="border-t border-[#30363d] py-10 text-center text-[#8b949e]">
        Know someone who can answer? Share a link to this
        <span class="text-[#58a6ff] cursor-pointer">question</span> via email,
        <span class="text-[#58a6ff] cursor-pointer">Twitter</span>, or
        <span class="text-[#58a6ff] cursor-pointer">Facebook</span>.
      </div>

      <!-- Your Answer Section -->
      <div class="mt-8 pt-6 border-t border-[#30363d]">
        <h2 class="text-[19px] text-[#e6edf3] font-normal mb-4">Your Answer</h2>
        <div
          class="border border-[#30363d] rounded-[3px] bg-[#0d1117] overflow-hidden focus-within:border-[#58a6ff] focus-within:ring-1 focus-within:ring-[#58a6ff]/50 transition-all"
        >
          <!-- Toolbar Mock -->
          <div
            class="bg-[#161b22] border-b border-[#30363d] p-2 flex gap-2 overflow-x-auto"
          >
            <button class="p-1 text-[#8b949e] hover:bg-[#21262d] rounded">
              <span class="font-bold font-serif">B</span>
            </button>
            <button class="p-1 text-[#8b949e] hover:bg-[#21262d] rounded">
              <span class="italic font-serif">I</span>
            </button>
            <button class="p-1 text-[#8b949e] hover:bg-[#21262d] rounded">
              <span class="font-mono">&lt;/&gt;</span>
            </button>
          </div>
          <textarea
            rows="8"
            class="w-full bg-[#0d1117] text-[#c9d1d9] p-3 focus:outline-none resize-y text-[14px] font-mono"
            placeholder="Type your answer here..."
          ></textarea>
        </div>

        <div class="mt-4">
          <button
            class="bg-[#1f6feb] hover:bg-[#388bfd] text-white text-[13px] font-medium px-3 py-2.5 rounded-[3px] border border-[rgba(240,246,252,0.1)] shadow-sm transition-colors"
          >
            Post Your Answer
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<style>
/* Custom scrollbar for dark mode if needed */
::-webkit-scrollbar {
  width: 10px;
}
::-webkit-scrollbar-track {
  background: #0d1117;
}
::-webkit-scrollbar-thumb {
  background: #30363d;
  border-radius: 5px;
}
::-webkit-scrollbar-thumb:hover {
  background: #58a6ff;
}
</style>
