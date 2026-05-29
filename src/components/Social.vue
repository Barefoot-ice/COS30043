<template>
  <div class="container py-4">
    <h2 class="mb-4">Posts</h2>
 
    <!-- Loading -->
    <div v-if="loading" class="text-center py-5">
      <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
    </div>
 
    <!-- Error -->
    <div v-else-if="error" class="alert alert-danger" role="alert">
      {{ error }}
    </div>
 
    <!-- No posts -->
    <div v-else-if="posts.length === 0" class="alert alert-info">
      No posts found.
    </div>
 
    <!-- Posts feed -->
    <div v-else class="row row-cols-1 row-cols-md-2 g-4">
      <div class="col" v-for="post in posts" :key="post.post_id">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <h5 class="card-title">{{ post.content.title }}</h5>
            <p class="card-text text-muted">{{ post.content.body }}</p>
            <div v-if="post.content.tags && post.content.tags.length" class="mt-2">
              <span
                v-for="tag in post.content.tags"
                :key="tag"
                class="badge bg-secondary me-1"
              >{{ tag }}</span>
            </div>
          </div>
          <div class="card-footer text-muted small d-flex justify-content-between">
            <span>Account #{{ post.account_id }}</span>
            <span>{{ formatDate(post.created_at) }}</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
 
<script>
const API_URL = "https://mercury.swin.edu.au/cos30043/s103988219/assignment/api/posts.php";
 
export default {
  name: "Social",
  data() {
    return {
      posts: [],
      loading: false,
      error: null,
    };
  },
  async created() {
    await this.fetchPosts();
  },
  methods: {
    async fetchPosts() {
      this.loading = true;
      this.error = null;
      try {
        const response = await fetch(API_URL);
        if (!response.ok) {
          throw new Error(`Server returned ${response.status}`);
        }
        const raw = await response.json();
 

        this.posts = raw.map((row) => ({
          post_id:    row[0],
          account_id: row[1],
          content:    this.parseContent(row[2]),
          created_at: row[3],
        }));
      } catch (err) {
        this.error = `Failed to load posts: ${err.message}`;
      } finally {
        this.loading = false;
      }
    },
 
    parseContent(raw) {
      try {
        return typeof raw === "string" ? JSON.parse(raw) : raw;
      } catch {
        return { title: "Untitled", body: raw, tags: [] };
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