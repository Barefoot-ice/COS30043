<template>
  <div class="container py-4">
    <h2 class="mb-4 text-center">Posts</h2>

    <!-- Loading -->
    <div v-if="loading" class="text-center py-5">
      <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
    </div>

    <!-- Error -->
    <div v-else-if="error" class="alert alert-danger">
      {{ error }}
    </div>

    <!-- No posts -->
    <div v-else-if="posts.length === 0" class="alert alert-info text-center">
      No posts found.
    </div>

    <!-- Posts feed -->
    <div v-else class="row g-4 justify-content-center">

      <div
        class="col-12 col-lg-10 col-xl-8 mx-auto"
        v-for="post in paginatedPosts"
        :key="post.post_id"
      >
        <div class="card shadow-lg border-0">

          <div class="card-body p-4">

            <h5 class="card-title mb-2">
              {{ post.post_content?.title || "Untitled" }}
            </h5>

            <p class="card-text text-muted mb-3">
              {{ post.post_content?.body || "" }}
            </p>

            <!-- Tags -->
            <div v-if="post.post_content?.tags?.length" class="mb-2">
              <span
                v-for="tag in post.post_content.tags"
                :key="tag"
                class="badge bg-secondary me-1"
              >
                {{ tag }}
              </span>
            </div>

          </div>

          <div class="card-footer text-muted small d-flex justify-content-between">
            <span>{{ post.username }}</span>
            <span>{{ formatDate(post.created_at) }}</span>
          </div>

        </div>
      </div>

    </div>

    <!-- Pagination -->
    <nav v-if="posts.length > pageSize" class="mt-4">
      <ul class="pagination justify-content-center">

        <li class="page-item" :class="{ disabled: currentPage === 1 }">
          <button class="page-link" @click="currentPage--">Previous</button>
        </li>

        <li class="page-item disabled">
          <span class="page-link">
            Page {{ currentPage }} / {{ totalPages }}
          </span>
        </li>

        <li class="page-item" :class="{ disabled: currentPage === totalPages }">
          <button class="page-link" @click="currentPage++">Next</button>
        </li>

      </ul>
    </nav>

  </div>
</template>

<script>
import { api } from "../lib/api";

export default {
  name: "Social",

  data() {
    return {
      posts: [],
      loading: false,
      error: null,

      currentPage: 1,
      pageSize: 4,
    };
  },

  computed: {
    totalPages() {
      return Math.ceil(this.posts.length / this.pageSize);
    },

    paginatedPosts() {
      const start = (this.currentPage - 1) * this.pageSize;
      const end = start + this.pageSize;
      return this.posts.slice(start, end);
    },
  },

  async created() {
    await this.fetchPosts();
  },

  methods: {
    async fetchPosts() {
      this.loading = true;
      this.error = null;

      try {
        const raw = await api.getPosts();

        this.posts = raw.map(post => ({
          post_id: post.post_id,
          username: post.username,
          post_content: post.post_content,
          created_at: post.created_at,
        }));

      } catch (err) {
        this.error = `Failed to load posts: ${err.message}`;
      } finally {
        this.loading = false;
      }
    },

    formatDate(timestamp) {
      if (!timestamp) return "";

      return new Date(timestamp).toLocaleDateString("en-AU", {
        day: "numeric",
        month: "short",
        year: "numeric",
        hour: "2-digit",
        minute: "2-digit",
      });
    },
  },
};
</script>