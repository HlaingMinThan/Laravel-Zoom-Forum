<template>
    <div class=" my-4 min-h-screen bg-[#0d1117] text-gray-300 font-sans selection:bg-indigo-500 selection:text-white pb-20">
      
      <!-- Profile Cover / Header Background -->
      <div class="h-48 w-full bg-gradient-to-r from-slate-900 via-[#161b22] to-slate-900 relative overflow-hidden">
         <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20 brightness-100 contrast-150"></div>
         <div class="absolute inset-0 bg-gradient-to-t from-[#0d1117] to-transparent"></div>
      </div>

      <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 -mt-20 relative z-10">
        
        <!-- Profile Intro Section -->
        <div class="">
            <!-- Profile Details -->
            <div class="flex-1 pt-20 md:pt-24 text-center md:text-left">
                <h1 class="text-3xl md:text-4xl font-bold text-white mb-2 tracking-tight">
                    {{ user.name }}</h1>
                <p class="text-gray-400 text-lg mb-6 max-w-2xl mx-auto md:mx-0 leading-relaxed">
                   Full-stack developer | Laravel & Vue.js Enthusiast | Open Source Contributor
                </p>
                
                <!-- Meta Info Row -->
                <div class="flex flex-wrap items-center justify-center md:justify-start gap-x-6 gap-y-3 text-sm text-gray-500 mb-8">
                     <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span>San Francisco, CA</span>
                     </div>
                     <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <span>Software Engineer</span>
                     </div>
                     <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span>Joined {{ formatDate(user.created_at) }}</span>
                     </div>
                </div>
            </div>
        </div>

        <!-- Content Grid -->
        <div class="mt-10">
            <!-- Left Column: Stats & Badges (Span 4) -->
            <div class="lg:col-span-4 space-y-6">
                <!-- Stats Grid -->
                <div class="bg-[#161b22] border border-gray-800 rounded-xl p-6 shadow-sm">
                    <h3 class="text-sm font-semibold text-gray-100 uppercase tracking-wider my-5">Community Stats</h3>
                    <div class="flex justify-between gap-4 mt-5">
                        <div class="p-4 w-full bg-[#0d1117] rounded-lg border border-gray-800/50 hover:border-gray-700 transition-colors">
                            <div class="text-2xl font-bold text-white mb-1">{{ user.questions_count || 0 }}</div>
                            <div class="text-xs text-gray-500 font-medium uppercase tracking-wide">Questions</div>
                        </div>
                        <div class="p-4  w-full bg-[#0d1117] rounded-lg border border-gray-800/50 hover:border-gray-700 transition-colors">
                            <div class="text-2xl font-bold text-white mb-1">{{ user.answers_count || 0 }}</div>
                            <div class="text-xs text-gray-500 font-medium uppercase tracking-wide">Answers</div>
                        </div>
                         
                    </div>
                </div>
            </div>
            <!-- Right Column: Activity Feed (Span 8) -->
            <div class="lg:col-span-8">
                 <!-- Tabs -->
                 <div class="flex items-center border-b border-gray-800 mb-6">
                    <button 
                        @click="activeTab = 'all'" 
                        class="px-6 py-3 text-sm font-medium border-b-2 transition-colors duration-200"
                        :class="activeTab === 'all' ? 'border-indigo-500 text-indigo-400' : 'border-transparent text-gray-400 hover:text-gray-200'"
                    >All Activity</button>
                    <button 
                        @click="activeTab = 'questions'" 
                         class="px-6 py-3 text-sm font-medium border-b-2 transition-colors duration-200"
                        :class="activeTab === 'questions' ? 'border-indigo-500 text-indigo-400' : 'border-transparent text-gray-400 hover:text-gray-200'"
                    >Questions</button>
                    <button 
                         @click="activeTab = 'answers'" 
                         class="px-6 py-3 text-sm font-medium border-b-2 transition-colors duration-200"
                        :class="activeTab === 'answers' ? 'border-indigo-500 text-indigo-400' : 'border-transparent text-gray-400 hover:text-gray-200'"
                    >Answers</button>
                 </div>

                 <!-- Feed -->
                 <div class="space-y-4">
                     <div v-if="filteredPosts.length === 0" class="text-center py-12 bg-[#161b22] rounded-xl border border-gray-800 border-dashed">
                         <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-gray-800 mb-3">
                             <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                         </div>
                         <p class="text-gray-400 text-sm font-medium">No activity found in this category.</p>
                     </div>

                     <div v-for="post in filteredPosts" :key="post.uniqueId" 
                        class="group bg-[#161b22] hover:bg-[#1c2128] border border-gray-800 hover:border-gray-700 rounded-xl p-5 transition-all duration-200 flex gap-4"
                     >
                        <div class="flex-shrink-0 mt-1">
                             <span v-if="post.type === 'question'" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-emerald-500/10 text-emerald-500 ring-1 ring-emerald-500/20">
                                <span class="font-bold text-xs">Q</span>
                             </span>
                             <span v-else class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-indigo-500/10 text-indigo-500 ring-1 ring-indigo-500/20">
                                <span class="font-bold text-xs">A</span>
                             </span>
                        </div>
                        
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between gap-4 mb-1">
                                <Link :href="`/questions/${post.routeId}/${post.type === 'answer' ? '#answerId-'+post.answerId : ''}`" class="text-base font-semibold text-gray-200 group-hover:text-indigo-400 transition-colors line-clamp-1">
                                    {{ post.title }}
                                </Link>
                                <span class="text-xs text-gray-500 whitespace-nowrap">{{ formatDate(post.date) }}</span>
                            </div>
                            <p class="text-sm text-gray-400 line-clamp-2 mb-3">
                                {{ post.body || 'No preview available...' }}
                            </p>
                            <div class="flex items-center gap-3 text-xs text-gray-500">
                                <div class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                                    <span>{{ post.votes || 0 }} votes</span>
                                </div>
                                <div class="w-1 h-1 rounded-full bg-gray-700"></div>
                                <span>In <span class="text-gray-300">Web Development</span></span>
                            </div>
                        </div>
                     </div>
                 </div>
                 
                 <div class="mt-6 flex justify-center" v-if="filteredPosts.length > 0">
                     <button class="text-sm text-indigo-400 hover:text-indigo-300 font-medium transition-colors">Load more activity</button>
                 </div>
            </div>
            
        </div>
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
    user: Object,
    questions: Array,
    answers: Array,
  },
  data() {
      return {
          activeTab: 'all'
      }
  },
  computed: {
      filteredPosts() {
          const questions = this.questions.map(q => ({
              uniqueId: 'q-' + q.id,
              routeId: q.id,
              type: 'question',
              title: q.title,
              body: q.body,
              date: q.created_at,
              votes: 0 // Placeholder
          }));
          
          const answers = this.answers.map(a => ({
              uniqueId: 'a-' + a.id,
              routeId: a.question_id,
              type: 'answer',
              answerId : a.id,
              title: a.question ? a.question.title : 'Answer to question #' + a.question_id,
              body: a.body,
              date: a.created_at,
              votes: 0 // Placeholder
          }));

          let all = [];
          
          if (this.activeTab === 'all') {
              all = [...questions, ...answers];
          } else if (this.activeTab === 'questions') {
              all = questions;
          } else if (this.activeTab === 'answers') {
              all = answers;
          }

          // Sort by date desc
          return all.sort((a, b) => new Date(b.date) - new Date(a.date));
      }
  },
  methods: {
    formatDate(dateString) {
      if (!dateString) return "";
      const date = new Date(dateString);
      return new Intl.DateTimeFormat("en-US", {
        year: "numeric",
        month: "short",
        day: "numeric",
      }).format(date);
    },
  },
};
</script>
