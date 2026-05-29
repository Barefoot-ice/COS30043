<template>
  <div class="container py-4">

    <h2 class="mb-4">Social Feed</h2>

    <!-- Create a new Post -->
    <div class="card mb-4">
      <div class="card-body">

        <h5 class="card-title">Create Post</h5>

        <form @submit.prevent="createPost">

          <input
            v-model="newPost.title"
            type="text"
            class="form-control mb-2"
            placeholder="Title"
            required
          />

          <textarea
            v-model="newPost.body"
            class="form-control mb-2"
            placeholder="Write something..."
            rows="3"
            required
          ></textarea>

          <input
            v-model="tagsInput"
            type="text"
            class="form-control mb-2"
            placeholder="Tags (comma separated)"
          />

          <button class="btn btn-primary" :disabled="loadingCreate">
            {{ loadingCreate ? "Posting..." : "Post" }}
          </button>

        </form>

      </div>
    </div>

    <!-- Posts -->
    <div v-if="loading">Loading posts...</div>

    <div v-else>

      <div v-if="posts.length === 0" class="alert alert-info">
        No posts found.
      </div>

      <div v-for="post in posts" :key="post.post_ID" class="card mb-3">
        <div class="card-body">

          <h5 class="card-title">
            {{ post.post_content?.title }}
          </h5>

          <p class="card-text">
            {{ post.post_content?.body }}
          </p>

          <div v-if="post.post_content?.tags?.length">
            <span
              v-for="tag in post.post_content.tags"
              :key="tag"
              class="badge bg-secondary me-1"
            >
              #{{ tag }}
            </span>
          </div>

          <hr />

          <small class="text-muted">
            Post #{{ post.post_ID }} | Account {{ post.account_id }} | {{ post.created_at }}
          </small>

        </div>
      </div>

    </div>

  </div>
</template>

<script>
import { api } from "../lib/api";

export default {
  data() {
    return {
      posts: [],
      loading: false,
      loadingCreate: false,

      newPost: {
        title: "",
        body: ""
      },

      tagsInput: ""
    };
  },

  async mounted() {
    await this.fetchPosts();
  },

  methods: {

    async fetchPosts() {
      this.loading = true;

      try {
        this.posts = await api.getPosts();
      } catch (err) {
        console.error("Failed to load posts:", err);
      } finally {
        this.loading = false;
      }
    },

    async createPost() {
      this.loadingCreate = true;

      try {
        const payload = {
          account_id: 1,
          title: this.newPost.title,
          body: this.newPost.body,
          tags: this.tagsInput
            ? this.tagsInput.split(",").map(t => t.trim()).filter(Boolean)
            : []
        };

        const newPost = await api.createPost(payload);

        if (newPost && newPost.post_ID) {
          this.posts.unshift(newPost);
        }

        this.newPost.title = "";
        this.newPost.body = "";
        this.tagsInput = "";

      } catch (err) {
        console.error("Failed to create post:", err);
      } finally {
        this.loadingCreate = false;
      }
    }
  }
};
</script>