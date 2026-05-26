
export const api = {
  getJobs: async () => {
    const response = await fetch(`${BASE}/jobs.php`);
    return response.json();
  },
  getPosts: async () => {
    const response = await fetch(`${BASE}/posts.php`);
    return response.json();
  },
};