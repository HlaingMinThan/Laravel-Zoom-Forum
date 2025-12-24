<template>
  <Head title="Home" />

  <!-- Main Container: Dark Mode Background -->
  <div class="min-h-screen bg-[#0d1117] text-[#c9d1d9] font-sans antialiased">
    <!-- Top Navigation Bar -->
    <header
      class="fixed top-0 w-full z-50 bg-[#161b22] border-b border-[#30363d] h-14 shadow-sm"
    >
      <div
        class="max-w-[1264px] mx-auto px-4 h-full flex items-center justify-between gap-4"
      >
        <!-- Logo -->
        <Link
          href="/"
          class="flex items-center gap-1 hover:bg-[#21262d] px-2 py-1 rounded transition-colors duration-200 group"
        >
          <svg
            class="w-7 h-7 text-orange-500 group-hover:text-orange-400 transition-colors"
            fill="currentColor"
            viewBox="0 0 24 24"
          >
            <path d="M19 15h-6V3h6v12Zm-8 0H5V7h6v8ZM19 17v2H5v-2h14Z" />
            <path d="M18 19H6v2h12v-2Z" />
          </svg>
          <span class="text-lg font-medium text-[#c9d1d9] hidden md:block">
            stack<span class="font-bold">overflow</span>
          </span>
        </Link>

        <!-- Search Bar -->
        <div class="flex-1 max-w-2xl relative group">
          <div
            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"
          >
            <svg
              class="h-4 w-4 text-[#8b949e] group-focus-within:text-[#58a6ff]"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
              />
            </svg>
          </div>
          <input
            v-model="search"
            type="text"
            class="block w-full pl-10 pr-3 py-1.5 text-sm bg-[#0d1117] border border-[#30363d] rounded-[3px] text-[#c9d1d9] placeholder-[#8b949e] focus:outline-none focus:border-[#58a6ff] focus:ring-4 focus:ring-[#58a6ff]/15 transition-all"
            placeholder="Search..."
          />
        </div>

        <!-- Auth/User Actions -->
        <div class="flex items-center gap-2">
          <template v-if="$page.props.auth?.user">
            <Link
              :href="`/users/${$page.props.auth.user.id}`"
              class="flex items-center gap-2 text-sm font-medium hover:bg-[#21262d] px-3 py-2 rounded text-[#c9d1d9]"
            >
              <!-- Avatar Placeholder -->
              <div
                class="w-5 h-5 bg-green-500 rounded flex items-center justify-center text-[10px] text-white font-bold"
              >
                {{ $page.props.auth.user.name.charAt(0) }}
              </div>
              <span>{{ $page.props.auth.user.name }} </span>
            </Link>
            <form @submit.prevent="logout">
              <button
                type="submit"
                class="text-white bg-red-500 text-sm px-2 py-1 rounded-xl"
              >
                logout
              </button>
            </form>
          </template>
          <template v-else>
            <Link
              :href="route('login')"
              class="text-sm font-medium text-[#58a6ff] bg-[#161b22] hover:bg-[#1c2128] border border-[#30363d] hover:border-[#8b949e] px-2.5 py-1.5 rounded-[3px] transition-colors"
            >
              Log in
            </Link>
            <Link
              :href="route('register')"
              class="text-sm font-medium text-white bg-[#238636] hover:bg-[#2ea043] border border-[rgba(240,246,252,0.1)] px-2.5 py-1.5 rounded-[3px] shadow-sm transition-colors"
            >
              Sign up
            </Link>
          </template>
        </div>
      </div>
    </header>

    <!-- Layout Container -->
    <div
      class="max-w-[1264px] mx-auto w-full pt-14 flex justify-center text-left"
    >
      <!-- Left Sidebar (Navigation) -->
      <nav
        class="hidden md:block w-[164px] flex-shrink-0 pt-8 pr-2 sticky top-14 h-[calc(100vh-3.5rem)] text-[13px]"
      >
        <ul class="space-y-1">
          <li>
            <Link
              href="/"
              class="block py-1.5 px-2 text-[#c9d1d9] hover:text-[#c9d1d9] bg-[#21262d] font-bold border-r-4 border-[#f78166] rounded-l-sm"
            >
              Home
            </Link>
          </li>
          <li
            class="mt-4 px-2 text-[11px] font-bold text-[#8b949e] uppercase tracking-wider mb-1"
          >
            Public
          </li>
          <li>
            <Link
              href="#"
              class="flex items-center gap-2 py-1.5 px-2 text-[#8b949e] hover:text-[#c9d1d9] hover:bg-[#21262d] rounded-l-sm transition-colors"
            >
              <svg
                class="w-4 h-4 opacity-70"
                fill="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"
                />
              </svg>
              Questions
            </Link>
          </li>
          <li>
            <Link
              href="#"
              class="block py-1.5 pl-8 pr-2 text-[#8b949e] hover:text-[#c9d1d9] hover:bg-[#21262d] rounded-l-sm transition-colors"
              >Tags</Link
            >
          </li>
          <li>
            <Link
              href="#"
              class="block py-1.5 pl-8 pr-2 text-[#8b949e] hover:text-[#c9d1d9] hover:bg-[#21262d] rounded-l-sm transition-colors"
              >Users</Link
            >
          </li>
          <li>
            <Link
              href="#"
              class="block py-1.5 pl-8 pr-2 text-[#8b949e] hover:text-[#c9d1d9] hover:bg-[#21262d] rounded-l-sm transition-colors"
              >Companies</Link
            >
          </li>
        </ul>
      </nav>

      <!-- Middle Content (Dynamic Question List) -->
      <main
        class="flex-1 min-w-0 max-w-[750px] w-full border-l border-[#30363d] md:border-l-0"
      >
        <slot />
      </main>

      <!-- Right Sidebar (Widgets) -->
      <aside class="hidden xl:block w-[300px] flex-shrink-0 ml-6 pt-6">
        <!-- Blog Widget -->
        <div
          class="bg-[#161b22] border border-[#f1e05a] rounded-[3px] mb-4 text-[13px] overflow-hidden shadow-sm"
        >
          <div
            class="bg-[#f1e05a]/10 border-b border-[#f1e05a]/20 px-4 py-2 font-bold text-[#c9d1d9] text-[12px] uppercase tracking-wide"
          >
            The Recent Questions
          </div>
          <ul class="list-none p-0 bg-[#0d1117]/30">
            <li
              v-for="question in $page.props.latest_questions"
              :key="question.id"
              class="flex items-start gap-2 px-3 py-2.5 hover:bg-[#21262d] cursor-pointer transition-colors"
            >
              <svg
                class="w-4 h-4 text-[#8b949e] flex-shrink-0 mt-0.5"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"
                ></path>
              </svg>
              <span class="text-[#c9d1d9] leading-snug">{{
                question.title
              }}</span>
            </li>
          </ul>
        </div>

        <!-- Featured Widget -->
        <div
          class="bg-[#161b22] border border-[#30363d] rounded-[3px] mb-4 text-[13px] shadow-sm"
        >
          <div
            class="bg-[#21262d] border-b border-[#30363d] px-4 py-2 font-bold text-[#8b949e] text-[12px] uppercase tracking-wide"
          >
            Featured on Meta
          </div>
          <ul class="list-none p-0">
            <li
              class="flex items-start gap-2 px-3 py-2.5 hover:bg-[#21262d] cursor-pointer transition-colors"
            >
              <svg
                class="w-4 h-4 text-[#58a6ff] flex-shrink-0 mt-0.5"
                fill="currentColor"
                viewBox="0 0 20 20"
              >
                <path
                  d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z"
                ></path>
                <path
                  d="M15 7v2a4 4 0 01-4 4H9.828l-1.766 1.767c.28.149.599.233.938.233h2l3 3v-3h2a2 2 0 002-2V9a2 2 0 00-2-2h-1z"
                ></path>
              </svg>
              <span class="text-[#c9d1d9] leading-snug"
                >New responsive search UI</span
              >
            </li>
            <li
              class="flex items-start gap-2 px-3 py-2.5 hover:bg-[#21262d] cursor-pointer transition-colors"
            >
              <svg
                class="w-4 h-4 text-[#58a6ff] flex-shrink-0 mt-0.5"
                fill="currentColor"
                viewBox="0 0 20 20"
              >
                <path
                  d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z"
                ></path>
                <path
                  d="M15 7v2a4 4 0 01-4 4H9.828l-1.766 1.767c.28.149.599.233.938.233h2l3 3v-3h2a2 2 0 002-2V9a2 2 0 00-2-2h-1z"
                ></path>
              </svg>
              <span class="text-[#c9d1d9] leading-snug"
                >Colors update in Dark Mode 2.0</span
              >
            </li>
          </ul>
        </div>

        <!-- Custom Tags -->
        <div
          class="bg-[#161b22] border border-[#30363d] rounded-[3px] p-4 shadow-sm"
        >
          <h4 class="text-[#c9d1d9] font-bold text-[15px] mb-3">
            Popular Tags
          </h4>
          <div class="flex flex-wrap gap-2">
            <Link
              v-for="tag in $page.props.tags"
              :key="tag.id"
              :href="'/?tag=' + tag.id"
            >
              <span
                class="px-2 py-1 bg-[#1f2d3d] text-[#58a6ff] text-[12px] rounded-[3px] hover:bg-[#2c3e50] cursor-pointer transition-colors"
                >{{ tag.name }}</span
              >
            </Link>
          </div>
        </div>
      </aside>
    </div>
  </div>
</template>
<script>
import { Link } from "@inertiajs/vue3";
import debounce from "lodash/debounce";

export default {
  components: { Link },
  data() {
    return {
      search: "",
    };
  },
  watch: {
    search() {
      this.debouncedSearch(this.search)
    },
  },
  methods: {
    logout() {
      this.$inertia.post("/logout");
    },
    async searchData(query) {
      this.$inertia.get("/?query=" + query);
    },
  },
  created() {
    // ✅ create debounce once
    this.debouncedSearch = debounce(this.searchData, 400);
  },
};
</script>
