<template>
  <div class="flex p-4 pl-4 gap-4 hover:bg-[#161b22] transition-colors duration-150">
    <!-- Stats -->
    <div class="flex flex-col items-end gap-1.5 text-[13px] flex-shrink-0 w-[100px] text-[#8b949e]">
      <div class="font-medium text-[#c9d1d9]">
        <span class="font-bold">{{ question.votes_count }}</span> votes
      </div>
      <div class="font-medium text-[#8b949e] border border-[#30363d] rounded-[3px] px-2 py-0.5">
        <span class="font-bold text-[#c9d1d9]">{{ question.answers_count }}</span> answers
      </div>
      <div class="text-[#8b949e] text-[12px]">
        <span class="font-bold">0</span> views
      </div>
       <button
      @click="translateToEnglish"
      style="
        padding: 10px;
        background-color: #2563eb;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 14px;
        margin-bottom: 12px;
      "
    >
      Translate (EN)
    </button>

   
    </div>
    <!-- Content -->
    <div class="flex-1 min-w-0">
      <h3 class="text-[17px] font-normal text-[#58a6ff] hover:text-[#79c0ff] mb-1 leading-snug break-words">
        <Link :href="route('questions.show', question.id)">{{
          translatedTitle || question.title
        }}</Link>
      </h3>
      <p class="text-[13px] text-[#c9d1d9] mb-2 line-clamp-2 leading-relaxed">
        {{
           translatedBody || question.body || "No description available for this question..."
        }}
      </p>
      <div class="flex flex-wrap items-center justify-between gap-y-2">
        <!-- Tags -->
        <div class="flex flex-wrap gap-1.5">
          <span
            v-for="tag in question.tags"
            :key="tag.id"
            class="px-1.5 py-0.5 bg-[#1f2d3d] text-[#58a6ff] text-[12px] rounded-[3px] hover:bg-[#2c3e50] cursor-pointer transition-colors"
          > {{ tag.name }}</span>
        </div>
        
        <!-- Actions -->
        <div class="flex items-center gap-2 ml-auto" v-if="question.authorize">
            <button @click.prevent="edit" class="text-[#8b949e] hover:text-[#58a6ff] transition-colors p-1" title="Edit">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                  <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.69 1.003l-3.951 1.055 1.055-3.951a4.5 4.5 0 0 1 1.003-1.689l10.862-10.86L16.862 4.487Zm0 0L19.5 7.125" />
                </svg>
            </button>
            <button @click.prevent="deleteQuestion" class="text-[#8b949e] hover:text-[#da3633] transition-colors p-1" title="Delete">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                  <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                </svg>
            </button>
        </div>

        <!-- User Meta -->
        <div class="flex items-center gap-1 text-[12px] text-[#8b949e]">
          <div class="flex items-center gap-1.5">
            <!-- Avatar mock -->
            <div class="w-4 h-4 bg-purple-500 rounded-[2px]"></div>
            <Link
              :href="'/users/' + question.user.id"
              v-if="question.user"
            >
            <span class="text-[#58a6ff] hover:text-[#79c0ff] cursor-pointer">{{ question.user.name }}</span>
            </Link>
            <span
              v-else
              class="text-[#8b949e]"
            >Anonymous</span>
            <span class="text-[#c9d1d9] font-bold">125</span>
          </div>
          <span class="text-[#6e7681]">asked
            <span class="font-medium text-[#c9d1d9]">1 hour ago</span></span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { Link } from "@inertiajs/vue3";
import axios from 'axios';

export default {
  components: { Link },
  props: {
    question: {
      type: Object
    }
  },
   data() {
    return {
      translatedTitle: '',
      translatedBody: ''
    }
  },
  methods: {
    edit() {
      this.$inertia.get(route("questions.edit",this.question.id))
    },
    deleteQuestion() {
      // blank method
      this.$inertia.delete("/questions/"+this.question.id+"/destroy");
    },
    async translateToEnglish() {
      try {
        const res = await axios.post('/translate', {
          title: this.question?.title,
          body: this.question?.body,
          lang: 'en'
        });

        this.translatedTitle = res.data.translatedTitle;
        this.translatedBody = res.data.translatedBody;
      } catch (e) {
        console.error('Translation error:', e);
      }
    }
  }
}
</script>

<style></style>